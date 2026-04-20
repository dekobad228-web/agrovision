@extends('admin.dashboard.index')

@section('title', 'Файл: ' . $media->name)

@section('content')
<div class="container mx-auto py-6 space-y-6">

    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">
                {{ $media->name }}
            </h1>
            <p class="text-sm text-gray-500">
                Альбом: {{ $album->title }}
            </p>
        </div>

        <a href="{{ route('admin.album.show', $album->slug) }}"
           class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl text-sm">
            ← Назад в альбом
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

        {{-- Просмотр файла --}}
        <div class="flex justify-center items-center bg-gray-50 rounded-xl p-6 mb-6">

            @if($media->type === 'image')
                <img
                    src="{{ Storage::url($media->path) }}"
                    alt="{{ $media->name }}"
                    class="max-h-[500px] rounded-xl shadow"
                >

            @elseif($media->type === 'video')
                <video
                    src="{{ Storage::url($media->path) }}"
                    controls
                    class="max-h-[500px] rounded-xl shadow"
                ></video>

            @else
                <div class="text-center space-y-3">
                    <div class="text-5xl">📄</div>
                    <a
                        href="{{ Storage::url($media->path) }}"
                        target="_blank"
                        class="text-blue-600 hover:underline text-sm"
                    >
                        Скачать файл
                    </a>
                </div>
            @endif

        </div>

        {{-- Информация --}}
        <div class="grid grid-cols-2 gap-4 text-sm text-gray-600 mb-6">

            <div>
                <span class="block text-gray-400">Тип</span>
                {{ $media->type }}
            </div>

            <div>
                <span class="block text-gray-400">Формат</span>
                {{ strtoupper($media->extension) }}
            </div>

            <div>
                <span class="block text-gray-400">Размер</span>
                {{ number_format($media->size / 1024, 1) }} KB
            </div>

            <div>
                <span class="block text-gray-400">ID</span>
                {{ $media->id }}
            </div>

        </div>

        {{-- Действия --}}
        <div class="flex justify-between items-center">

            <a
                href="{{ Storage::url($media->path) }}"
                target="_blank"
                class="px-4 py-2 bg-blue-100 text-blue-700 rounded-xl text-sm hover:bg-blue-200"
            >
                Скачать
            </a>

            <form
                method="POST"
                action="{{ route('admin.album.media.destroy', [$album->slug, $media->id]) }}"
                onsubmit="return confirm('Удалить файл?')"
            >
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="px-4 py-2 bg-red-100 text-red-700 rounded-xl text-sm hover:bg-red-200"
                >
                    Удалить
                </button>
            </form>

        </div>

    </div>

</div>
@endsection