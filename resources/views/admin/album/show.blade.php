@extends('admin.dashboard.index')

@section('title', 'Альбом')

@section('content')
<div class="container mx-auto py-6 space-y-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">
            {{ $album->title }}
            <span class="text-gray-500 text-lg font-normal">({{ $media->count() }} файлов)</span>
        </h1>

        <a href="{{ route('admin.album.index') }}" class="btn btn-secondary">
            ← Все альбомы
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
            <ul class="text-sm text-red-700 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>— {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($album->is_system)
        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6">
            <h2 class="text-lg font-semibold text-yellow-900 mb-2">
                Системный альбом
            </h2>
            <p class="text-sm text-yellow-800">
                Системный альбом недоступен для редактирования.
            </p>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">
                    Настройки альбома
                </h2>
            </div>

            <form
                method="POST"
                action="{{ route('admin.album.update', $album->slug) }}"
                class="space-y-5"
            >
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">
                            Название
                        </label>
                        <input
                            type="text"
                            name="title"
                            value="{{ old('title', $album->title) }}"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500"
                            required
                        >
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">
                            Slug
                        </label>
                        <input
                            type="text"
                            name="slug"
                            value="{{ old('slug', $album->slug) }}"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500"
                            required
                        >
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">
                            Позиция
                        </label>
                        <input
                            type="number"
                            name="position"
                            value="{{ old('position', $album->position) }}"
                            min="0"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500"
                        >
                    </div>
                </div>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-xl shadow-sm hover:bg-black active:scale-[0.98] transition"
                    >
                        Сохранить изменения
                    </button>
                </div>
            </form>

            <div class="border-t pt-4 flex justify-end">
                <form
                    method="POST"
                    action="{{ route('admin.album.destroy', $album->slug) }}"
                    onsubmit="return confirm('Удалить альбом? Связи с файлами будут удалены.')"
                >
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 text-white text-sm font-medium rounded-xl shadow-sm hover:bg-red-700 active:scale-[0.98] transition"
                    >
                        Удалить альбом
                    </button>
                </form>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">
                Загрузка медиа
            </h2>
        </div>

        <form
            method="POST"
            action="{{ route('admin.album.media.store', $album->slug) }}"
            enctype="multipart/form-data"
            class="space-y-5"
        >
            @csrf

            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700">
                    Выберите файлы
                </label>

                <div class="relative flex flex-col items-center justify-center w-full p-6 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 hover:border-blue-400 hover:bg-blue-50 transition cursor-pointer">
                    <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 0l-4 4m4-4l4 4M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2" />
                    </svg>

                    <p class="text-sm text-gray-600">
                        Перетащите файлы или <span class="text-blue-600 font-medium">выберите</span>
                    </p>

                    <input
                        type="file"
                        name="media[]"
                        multiple
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                    >
                </div>

                <p class="text-xs text-gray-400">
                    Поддерживаются изображения, видео и документы до 20MB
                </p>
            </div>

            <div class="flex items-center justify-end">
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-xl shadow-sm hover:bg-blue-700 active:scale-[0.98] transition"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Добавить
                </button>
            </div>
        </form>
    </div>

    @if($media->isEmpty())
        <div class="bg-gray-50 border border-dashed border-gray-300 rounded-xl p-12 text-center">
            <p class="text-gray-500 text-lg">В альбоме пока нет медиафайлов</p>
            <p class="text-sm text-gray-400 mt-2">Загрузите файлы через форму выше</p>
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            @foreach($media as $item)
                <a
                    href="{{ route('admin.album.media.show', [$album->slug, $item->id]) }}"
                    class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition"
                >
                    <div class="aspect-square bg-gray-100 relative">
                        @if($item->type === 'image')
                            <img
                                src="{{ Storage::url($item->path) }}"
                                alt="{{ $item->name }}"
                                class="w-full h-full object-cover"
                            >
                        @elseif($item->type === 'video')
                            <video
                                src="{{ Storage::url($item->path) }}"
                                class="w-full h-full object-cover"
                                muted
                            ></video>
                            <div class="absolute top-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded">
                                VIDEO
                            </div>
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400">
                                <span class="text-4xl">📄</span>
                            </div>
                        @endif
                    </div>

                    <div class="p-3">
                        <p class="font-medium text-sm line-clamp-2 mb-1" title="{{ $item->name }}">
                            {{ $item->name }}
                        </p>

                        <div class="flex justify-between text-xs text-gray-500">
                            <span>{{ strtoupper($item->extension) }}</span>
                            <span>{{ number_format($item->size / 1024, 1) }} KB</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

</div>
@endsection