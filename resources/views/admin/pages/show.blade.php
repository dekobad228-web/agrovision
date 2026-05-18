@extends('admin.dashboard.index')

@section('title', 'Редактирование страницы')

@section('content')
    <div class="w-full min-h-screen px-8 py-6 space-y-6">

        <h1 class="text-2xl font-semibold text-gray-800">
            Редактирование страницы: {{ $page->title }}
        </h1>

        <form method="POST" action="{{ route('admin.pages.update', $page) }}" id="page-form" x-data="pageEditor(@js($page->blocks), @js($componentRegistry))"
            @submit="serializeBlocks()">
            @csrf
            @method('PATCH')

            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm space-y-6">

                <div class="grid grid-cols-2 gap-6">

                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-600">Заголовок</label>
                        <input type="text" name="title" value="{{ old('title', $page->title) }}"
                            class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-2.5
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-600">Slug</label>
                        <input type="text" name="slug" value="{{ old('slug', $page->slug) }}"
                            class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-2.5
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                    </div>

                </div>

                <div class="grid grid-cols-2 gap-6">

                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-600">
                            Шаблон страницы
                        </label>
                        <select name="template"
                            class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-2.5
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">

                            @foreach ($templates as $template)
                                <option value="{{ $template['file'] }}"
                                    {{ old('template') === $template['file'] ? 'selected' : '' }}>
                                    {{ $template['template_name'] }}
                                </option>
                            @endforeach

                        </select>

                        @error('template')
                            <p class="text-red-600 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-600">
                            Тема страницы
                        </label>
                        <select name="theme"
                            class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-2.5
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">

                            @foreach ($themes as $value)
                                <option value="{{ $value['value'] }}" {{ old('theme') === $value ? 'selected' : '' }}>
                                    {{ $value['label'] }}
                                </option>
                            @endforeach

                        </select>

                        @error('theme')
                            <p class="text-red-600 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" name="is_published"
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        {{ old('is_published', $page->is_published) ? 'checked' : '' }}>
                    Страница опубликована
                </label>

            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">

                <input type="hidden" name="blocks_json" id="blocks-json">

                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    Блоки страницы
                </h2>

                <div class="flex items-center gap-3 mb-6">
                    <select id="new-component-select"
                        class="border border-gray-200 bg-gray-50 rounded-lg px-4 py-2.5
                       focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                        x-model="selectedComponent" x-init="selectedComponent = $el.options[0]?.value">

                        @foreach ($availableComponents ?? [] as $name => $class)
                            <option value="{{ (string) $name }}">{{ $class::label() }}</option>
                        @endforeach

                    </select>

                    <button type="button" @click="addBlock()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium transition">
                        + Добавить
                    </button>
                </div>

                <div id="blocks-container" class="space-y-4" x-sort @sort="syncBlocksOrder()">
                    @include('admin.pages.components.block')
                </div>

            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl font-semibold shadow-sm transition">
                    Сохранить
                </button>
            </div>

        </form>

        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Вы уверены?');">
            @csrf
            @method('DELETE')

            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg transition">
                Удалить
            </button>
        </form>

    </div>

    @include('admin.pages.components.modal')
@endsection
