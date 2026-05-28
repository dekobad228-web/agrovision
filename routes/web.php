<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PagesController;

Route::get('/', [PagesController::class, 'home'])->name('home');

Route::get('{slug}', [PagesController::class, 'index'])
    ->where('slug', '^(?!admin|login|register|password|api|storage|vite|horizon|nova|filament).*$')
    ->name('page.index');

Route::get('/contacts', function () {
    return view('web.pages.contacts');
})->name('contacts');

Route::get('/admin/media', function (\Illuminate\Http\Request $request) {
    if ($request->boolean('json')) {
        return response()->json(
            \App\Models\Media::ordered()->get()
        );
    }
    abort(404);
})->middleware(['auth']);

require_once __DIR__ . '/admin.php';
require_once __DIR__ . '/auth.php';
