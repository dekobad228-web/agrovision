@extends('admin.dashboard.index')

@section('title', 'Альбомы')

@section('content')
    <div class="px-6 py-8">
        <h1 class="text-3xl font-bold mb-6">
            Редактирование Альбомы
        </h1>
        <a href="{{ route('admin.album.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md font-medium">
            Создать новый альбом
        </a>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
            @foreach ($albums as $album)
                <a href="{{ route('admin.album.show', $album->slug) }}"
                    class="group block p-5 rounded-2xl border transition
                   {{ $album->is_system
                       ? 'bg-blue-50 border-blue-200 hover:shadow-md'
                       : 'bg-white border-gray-200 hover:shadow-md' }}">

                    <div class="flex items-start justify-between mb-2">
                        <h2 class="text-lg font-semibold text-gray-800 group-hover:text-blue-600 transition">
                            {{ $album->title }}
                        </h2>

                        @if ($album->is_system)
                            <span class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-600">
                                системный
                            </span>
                        @endif
                    </div>

                    <p class="text-sm text-gray-500">
                        {{ $album->slug }}
                    </p>

                </a>
            @endforeach
        </div>
    </div>
@endsection
