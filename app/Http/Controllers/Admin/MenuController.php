<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use Symfony\Component\HttpFoundation\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::select('id', 'name', 'slug')->get();

        return view('admin.menu.index', compact('menus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'position' => 'nullable|integer|min:0',
            ],
            [
                'slug.unique' => 'Меню с таким ключом уже существует',
            ]
        );

        $menu = Menu::create([
            'name' => $validated['name'] ?? '',
            'slug' => $validated['slug'],
        ]);

        return redirect()
            ->route('admin.menu.index', $menu)
            ->with('success', 'Меню успешно создано');
    }

    public function show(Menu $menu)
    {
        $menu->load(['items' => fn($query) => $query->orderBy('position')]);

        $pages = Page::select('id', 'title', 'slug')
            ->where('is_published', true)
            ->orderBy('title')
            ->get()
            ->toArray();

        return view('admin.menu.show', compact(
            'pages',
            'menu'
        ));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',

            'items' => 'nullable|array',
            'items.*.id' => 'nullable|exists:menu_items,id',
            'items.*.title' => 'required|string|max:255',
            'items.*.type' => 'required|in:page,link,external',
            'items.*.page_id' => 'nullable|integer|exists:pages,id',
            'items.*.url' => 'nullable|string|max:255',
            'items.*.position' => 'nullable:integer:min:0',
        ]);

        $menu->update([
            'name' => $validated['name'],
            'slug' => $validated['slug']
        ]);

        $this->syncItems($menu, $validated['items'] ?? []);

        return redirect()
            ->route('admin.menu.show', $menu)
            ->with('success', 'Пункты меню добавлены');
    }

    public function syncItems(Menu $menu, array $itemsData): void
    {
        $itemsData = array_values($itemsData ?? []);
        $existingBlocksIds = $menu->items()->pluck('id')->all();

        $incomingIds = collect($itemsData)
            ->pluck('id')
            ->filter()
            ->all();

        $idsToDelete = array_diff($existingBlocksIds, $incomingIds);

        if(!empty($idsToDelete)) {
            MenuItem::whereIn('id', $idsToDelete)->delete();
        }

        foreach($itemsData as $index => $item) {
            $data = [
                'title' => $item['title'] ?? 'Без названия',
                'type' => $item['type'] ?? 'link',
            ];
            
            if(($item['type'] ?? '') === 'page') {
                $data['page_id'] = $item['page_id'] ?? null;
                $slug = Page::find($item['page_id'])?->slug;
                $data['url'] = $slug ?? null;
            } else {
                $data['url'] = $item['url'] ?? '#';
                $data['page_id'] = null;
            }

            if(!empty($item['id'])) {
                MenuItem::where('id', $item['id'])
                    ->where('menu_id', $menu->id)
                    ->update($data);
            } else {
                $menu->items()->create($data);
            }
        }
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Страница успешно удалена');
    }
}
