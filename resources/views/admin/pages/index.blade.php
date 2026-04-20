@extends('admin.dashboard.index')

@section('title', 'Страницы')

@section('content')

<div class="max-w-5xl mx-auto px-6 py-8" x-data="{ handle: (item, position) => { ... }">
    <h1 class="text-3xl font-bold mb-6">
        Редактирование страниц
    </h1>
    <a href="{{ route('admin.pages.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md font-medium">
        Создать новую страницу
    </a>
    <div class="grid gap-4" x-sort="handle">
        @foreach($pages as $page)
        <a href="{{ route('admin.pages.show', $page->id) }}"
            class="block bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md hover:border-blue-400 transition" x-sort:item="{{ $page->id }}" data-index="{{ $page->id }}">
            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <h2 class="text-sm text-gray-500 uppercase tracking-wide">
                        Заголовок
                    </h2>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $page->title }}
                    </p>
                </div>
                <div>
                    <h2 class="text-sm text-gray-500 uppercase tracking-wide">
                        Slug
                    </h2>
                    <p class="text-gray-700">
                        {{ $page->slug }}
                    </p>
                </div>
                <div>
                    <h2 class="text-sm text-gray-500 uppercase tracking-wide">
                        Публикация
                    </h2>
                    <p class="font-medium {{ $page->is_published ? 'text-green-600' : 'text-red-500' }}">
                        {{ $page->is_published ? 'Опубликована' : 'Черновик' }}
                    </p>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection