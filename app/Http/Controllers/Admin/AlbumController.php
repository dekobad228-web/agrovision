<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::with('media')
            ->orderBy('position')
            ->get();

        return view('admin.album.index', compact('albums'));
    }

    public function create()
    {
        return view('admin.album.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'title' => ['required', 'string', 'max:255'],
                'slug' => ['required', 'string', 'max:255', 'unique:albums,slug'],
                'position' => ['nullable', 'integer', 'min:0'],
            ],
            [
                'slug.unique' => 'Альбом с таким ключом уже существует',
            ]
        );

        $album = Album::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'user_id' => auth()->id(),
            'position' => $validated['position'] ?? 0,
        ]);

        return redirect()
            ->route('admin.album.index')
            ->with('success', 'Альбом успешно создан');
    }

    public function show(Album $album)
    {
        $album->load([
            'media' => function ($query) {
                $query->ordered()->with('user');
            }
        ]);

        $media = $album->media;

        return view('admin.album.show', compact('album', 'media'));
    }

    public function update(Request $request, Album $album)
    {
        $validated = $request->validate(
            [
                'title' => ['required', 'string', 'max:255'],
                'slug' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('albums', 'slug')->ignore($album->id),
                ],
                'position' => ['nullable', 'integer', 'min:0'],
            ],
            [
                'slug.unique' => 'Альбом с таким ключом уже существует',
            ]
        );

        $album->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'user_id' => auth()->id(),
            'position' => $validated['position'] ?? 0,
        ]);

        return redirect()
            ->route('admin.album.show', $album)
            ->with('success', 'Альбом успешно изменен');
    }

    public function destroy(Album $album)
    {
        if ($album->is_system) {
            return redirect()
                ->route('admin.album.index')
                ->with('error', 'Системный альбом удалить нельзя');
        }

        $album->media()->detach();
        $album->delete();

        return redirect()
            ->route('admin.album.index')
            ->with('success', 'Альбом успешно удален!');
    }
}
