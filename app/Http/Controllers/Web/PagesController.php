<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Menu;

class PagesController extends Controller
{
    public function index(string $slug)
    {
        $currentPage = Page::where('slug', $slug)
            ->where('is_published', true)
            ->with(['blocks' => fn($q) => $q->orderBy('position')])
            ->firstOrFail();

        $menus = Menu::with(['items' => fn($q) => $q->orderBy('position')])
            ->orderBy('position')
            ->get()
            ->keyBy('slug');

        $blocks = $currentPage->getBlockTheme();

        return view($currentPage->template_view, compact(
            'currentPage',
            'menus',
            'blocks'
        ));
    }

    public function home()
    {

        return $this->index('home');
    }
}
