<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard.index');
    })->name('admin');

    Route::prefix('album')->name('admin.album.')->group(function () {

        Route::controller(Admin\AlbumController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');

            Route::get('/{album:slug}', 'show')->name('show');
            Route::patch('/{album:slug}', 'update')->name('update');
            Route::delete('/{album:slug}', 'destroy')->name('destroy');
        });

        Route::prefix('{album:slug}')
            ->name('media.')
            ->controller(Admin\AlbumMediaController::class)
            ->group(function () {

                Route::post('/media', 'store')->name('store');

                Route::get('/{media}', 'show')->name('show');
                Route::patch('/{media}', 'update')->name('update');
                Route::delete('/{media}', 'destroy')->name('destroy');
            });
    });

    Route::prefix('users')
        ->controller(Admin\UsersController::class)
        ->name('admin.users.')
        ->group(function () {
            Route::get('/', 'index')
                ->name('index');

            Route::get('/create', 'create')
                ->name('create');
            Route::post('/create', 'store')
                ->name('store');

            Route::get('/{user}', 'show')
                ->name('show');
            Route::post('/{user}', 'update')
                ->name('update');
            Route::delete('/{user}', 'destroy')
                ->name('destroy');
        });

    Route::prefix('menu')
        ->controller(Admin\MenuController::class)
        ->name('admin.menu.')
        ->group(function () {
            Route::get('/', 'index')
                ->name('index');

            Route::post('/', 'store')
                ->name('store');

            Route::get('/{menu}', 'show')
                ->name('show');
            Route::patch('/{menu}', 'update')
                ->name('update');
            Route::delete('{menu}', 'destroy')
                ->name('destroy');
        });

    Route::prefix('pages')
        ->controller(Admin\PagesController::class)
        ->name('admin.pages.')
        ->group(function () {

            Route::get('/', 'index')
                ->name('index');

            Route::get('/create', 'create')
                ->name('create');
            Route::post('/create', 'store')
                ->name('store');

            Route::get('/{page}', 'show')
                ->name('show');
            Route::patch('/{page}', 'update')
                ->name('update');
            Route::delete('/{page}', 'destroy')
                ->name('destroy');
        });

    Route::get('/settings', function () {
        return view('admin.settings.index');
    })->name('admin.settings');

    Route::get('/statistics', function () {
        return view('admin.statistics.index');
    })->name('admin.statistics');
});
