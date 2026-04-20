<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumMediaController extends Controller
{
    public function show(Album $album, Media $media)
    {
        $this->ensureMediaBelongsToAlbum($album, $media);

        return view('admin.album.media.show', compact('album', 'media'));
    }

    public function store(Album $album, Request $request, MediaService $service)
    {
        $request->validate([
            'media'   => ['required', 'array', 'min:1'],
            'media.*' => ['file', 'max:20480'],
        ]);

        $files = $request->file('media');
        $processedFiles = $service->processMedia($files);

        if (empty($processedFiles)) {
            return back()->withErrors([
                'media' => 'Ошибка обработки файлов',
            ]);
        }

        $count = 0;

        foreach ($processedFiles as $fileData) {
            $systemAlbum = $this->systemAlbum($fileData['type']);

            $media = Media::create([
                'name'      => $fileData['name'],
                'file_name' => $fileData['file_name'],
                'type'      => $fileData['type'],
                'mime_type' => $fileData['mime_type'],
                'extension' => $fileData['extension'],
                'path'      => $fileData['path'],
                'size'      => $fileData['size'],
                'user_id'   => auth()->id(),
            ]);

            $album->media()->syncWithoutDetaching([$media->id]);

            if ($systemAlbum) {
                $systemAlbum->media()->syncWithoutDetaching([$media->id]);
            }

            $count++;
        }

        return redirect()
            ->route('admin.album.show', $album)
            ->with('success', "Успешно загружено файлов: {$count}");
    }

    public function update(Album $album, Media $media)
    {
        $this->ensureMediaBelongsToAlbum($album, $media);

        return redirect()
            ->route('admin.album.media.show', [$album, $media])
            ->with('success', 'Изображение успешно изменено');
    }

    public function destroy(Album $album, Media $media)
    {
        $this->ensureMediaBelongsToAlbum($album, $media);

        if ($album->is_system) {
            $media->albums()->detach();

            if (!empty($media->path) && Storage::disk('public')->exists($media->path)) {
                Storage::disk('public')->delete($media->path);
            }

            $media->delete();

            return redirect()
                ->route('admin.album.show', $album)
                ->with('success', 'Файл полностью удален из системы');
        }

        $album->media()->detach($media->id);

        return redirect()
            ->route('admin.album.show', $album)
            ->with('success', 'Файл удален только из текущего альбома');
    }

    protected function systemAlbum(string $type): ?Album
    {
        $slug = match ($type) {
            'image'    => 'images',
            'video'    => 'videos',
            'model'    => 'models',
            'document' => 'documents',
            default    => null,
        };

        if (!$slug) {
            return null;
        }

        return Album::query()
            ->where('is_system', true)
            ->where('slug', $slug)
            ->first();
    }

    protected function ensureMediaBelongsToAlbum(Album $album, Media $media): void
    {
        $exists = $album->media()
            ->where('media.id', $media->id)
            ->exists();

        abort_unless($exists, 404);
    }
}
