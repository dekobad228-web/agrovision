<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\PageBlock;
use App\View\Components as Components;
use Illuminate\Console\View\Components\Component;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use phpDocumentor\Reflection\Types\Nullable;
use App\Enums\PageTheme;

class PagesController extends Controller
{
    public function index()
    {
        $pages = Page::with('blocks')->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        $templates = $this->getAvailableTemplates();

        $themes = collect(PageTheme::cases())
            ->mapWithKeys(fn($theme) => [
                $theme->value => $theme->admin()
            ])->toArray();

        return view('admin.pages.create', compact('templates', 'themes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:pages,slug',
                'is_published' => 'nullable',
                'template' => 'nullable|string|max:50',
                'theme' => 'nullable|string',
            ],
            [
                'slug.unique' => 'Страница с таким url уже существует'
            ]
        );

        $page = Page::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'is_published' => $request->has('is_published'),
            'template' => $validated['template'] ?? 'default',
            'theme' => $validated['theme'] ?? 'light',
        ]);

        return redirect()->route('admin.pages.show', $page)->with('success', 'Страница «{$page->title}» успешно создана!');
    }

    public function show(Page $page)
    {
        $page->load(['blocks' => fn($query) => $query->orderBy('position')]);

        $availableComponents = $this->getAvailableComponents();

        $componentRegistry = collect($availableComponents)
            ->mapWithKeys(function ($class, $name) {
                return [
                    $name => [
                        'name'   => $class::name(),
                        'fields' => $class::fields(),
                    ]
                ];
            })->all();

        $templates = $this->getAvailableTemplates();
        usort($templates, function ($a, $b) use ($page) {
            if ($a['file'] === $page->template) return -1;
            if ($b['file'] === $page->template) return 1;
            return 0;
        });

        $themes = collect(PageTheme::cases())
            ->map(fn($theme) => [
                'value' => $theme->value,
                'label' => $theme->admin()
            ])
            ->toArray();

        usort($themes, function ($a, $b) use ($page) {
            if ($a['value'] === $page->theme->value) return -1;
            if ($b['value'] === $page->theme->value) return 1;
        });

        return view('admin.pages.show', compact(
            'page',
            'availableComponents',
            'componentRegistry',
            'templates',
            'themes',
        ));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'is_published' => 'nullable',
            'template' => 'nullable|string|max:50',
            'theme' => 'nullable|string',

            'blocks' => 'nullable|array',
            'blocks.*.id' => 'nullable|exists:page_blocks,id',
            'blocks.*.component' => 'required|string',
            'blocks.*.content' => 'required|array',
            'blocks.*.position' => 'nullable|integer|min:0',
        ]);

        $page->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'is_published' => $request->has('is_published'),
            'template' => $validated['template'] ?? 'default',
            'theme' => $validated['theme'] ?? 'light',
        ]);

        $this->syncBlocks($page, $validated['blocks'] ?? []);
        return redirect()
            ->route('admin.pages.show', $page)
            ->with('success', 'Страница и все блоки успешно сохранены');
    }

    public function syncBlocks(Page $page, array $blocksData): void
    {
        $blocksData = array_values($blocksData ?? []);
        $existingBlockIds = $page->blocks()->pluck('id')->all();

        $incomingIds = collect($blocksData)
            ->pluck('id')
            ->filter()
            ->all();

        $idsToDelete = array_diff($existingBlockIds, $incomingIds);

        if (!empty($idsToDelete)) {
            PageBlock::whereIn('id', $idsToDelete)->delete();
        }

        foreach ($blocksData as $index => $blockData) {
            $content = $blockData['content'];
            if (!empty($blockData['id'])) {
                $block = PageBlock::findOrFail($blockData['id']);

                $block->update([
                    'component' => $blockData['component'],
                    'content' => $content,
                    'position' => $index,
                ]);
            } else {
                $page->blocks()->create([
                    'component' => $blockData['component'],
                    'content' => $content,
                    'position' => $index,
                ]);
            }
        }
    }

    public function getAvailableComponents(): array
    {
        $components = [];

        foreach (glob(app_path('View/Components') . '/*.php') as $file) {
            $class = 'App\\View\\Components\\' . basename($file, '.php');
            if (!class_exists($class)) continue;

            if (method_exists($class, 'name')) {
                $name = $class::name();
                $components[$name] = $class;
            } else {
                $components[strtolower(basename($file, '.php'))] = $class;
            }
        }

        return $components;
    }

    public function getAvailableTemplates(): array
    {
        $templates = [];
        $files = glob(resource_path('views/web/pages/*.blade.php'));

        foreach ($files as $file) {
            $content = file_get_contents($file);

            if (preg_match("/@section\(\s*'template_name'\s*,\s*'([^']+)'\s*\)/", $content, $matches)) {
                $templateName = $matches[1];
            } else {
                $templateName = basename($file, '.blade.php');
            }

            $templates[] = [
                'file' => basename($file),
                'template_name' => $templateName,
            ];
        }

        usort($templates, function ($a, $b) {
            if ($a['file'] === 'default.blade.php') return -1;
            if ($b['file'] === 'default.blade.php') return 1;
            return 0;
        });

        return $templates;
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Страница успешно удалена');
    }
}
