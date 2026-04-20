@extends('admin.dashboard.index')

@section('title', 'Создание страницы')

@section('content')
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Создание новой страницы</h1>

        <form method="POST" action="{{ route('admin.pages.store') }}">
            @csrf

            <div class="bg-white p-6 rounded-lg shadow space-y-6">

                <!-- Заголовок -->
                <div>
                    <label class="block text-sm font-medium mb-2">Заголовок страницы</label>
                    <input type="text"
                           name="title"
                           value="{{ old('title') }}"
                           class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:border-blue-500"
                           required>
                    @error('title')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label class="block text-sm font-medium mb-2">URL (slug)</label>
                    <input type="text"
                           name="slug"
                           value="{{ old('slug') }}"
                           class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:border-blue-500"
                           required>
                    @error('slug')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-xs mt-1">Используйте только латинские буквы, цифры, дефисы</p>
                </div>

                <!-- Шаблон страницы -->
                <div>
                    <label class="block text-sm font-medium mb-2">Шаблон страницы</label>
                    <select name="template"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:border-blue-500 bg-white">
                        @foreach($templates as $template)
                            <option value="{{ $template['file'] }}" {{ old('template') === $template['file'] ? 'selected' : '' }}>
                                {{ $template['template_name'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('template')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Тема страницы -->
                <div>
                    <label class="block text-sm font-medium mb-2">Тема страницы</label>
                    <select name="theme"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:border-blue-500 bg-white">
                        @foreach($themes as $value => $label)
                            <option value="{{ $value }}" {{ old('theme') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('theme')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Публикация -->
                <div>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_published" {{ old('is_published') ? 'checked' : '' }}>
                        <span>Опубликовать сразу</span>
                    </label>
                </div>

                <!-- Кнопка -->
                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-medium">
                        Создать страницу
                    </button>
                </div>

            </div>
        </form>
    </div>
@endsection