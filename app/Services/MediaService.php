<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class MediaService
{
    protected string $disk = 'public';

    public function processMedia($files)
    {

        $files = is_array($files) ? $files : [$files];

        if (empty($files)) return [];
        $processed = [];

        foreach ($files as $file) {
            $processed[] = $this->singleFile($file);
        }

        return $processed;
    }

    protected function singleFile(UploadedFile $file): array
    {
        $result = [];

        $name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $file_name = Str::uuid() . '.' . $extension;
        $type = $this->getFileType($extension);
        $folder = $this->getSystemDirectory($type);
        $mimeType = $file->getClientMimeType();
        $size = $file->getSize();

        if(!$size) return $result;

        $path = "media/{$folder}/{$file_name}";

        Storage::disk($this->disk)->putFileAs(
            "media/{$folder}",
            $file,
            $file_name
        );

        $result = [
            'name' => $name,
            'file_name' => $file_name,
            'type' => $type,
            'extension' => $extension,
            'mime_type' => $mimeType,
            'size' => $size,
            'path' => $path,
        ];
        return $result;
    }

    protected function getFileType(string $extension): string
    {

        $ext = match ($extension) {
            'jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg' => 'image',
            'mp4', 'mov', 'avi', 'mkv', 'webm'                => 'video',
            'glb', 'gltf', 'obj', 'fbx'                       => 'model',
        };

        return $ext;
    }

    protected function getSystemDirectory(string $type): string
    {
        $directory = match ($type) {
            'image' => 'images',
            'video' => 'videos',
            'model' => 'models',
        };

        return $directory;
    }
}
