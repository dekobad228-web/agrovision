@extends('admin.dashboard.index')

@section('title', 'Редактирование страницы')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Редактирование страницы: {{ $page->title }}</h1>

    <form method="POST" action="{{ route('admin.pages.update', $page) }}" id="page-form">
        @csrf
        @method('PATCH')

        {{-- 1. Данные самой страницы --}}
        <div class="bg-white p-6 rounded-lg shadow mb-8">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium mb-1">Заголовок</label>
                    <input type="text"
                        name="title"
                        value="{{ old('title', $page->title) }}"
                        class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Slug</label>
                    <input type="text"
                        name="slug"
                        value="{{ old('slug', $page->slug) }}"
                        class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
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
                        @foreach($themes as $value)
                        <option value="{{ $value['value'] }}" {{ old('theme') === $value ? 'selected' : '' }}>
                            {{ $value['label'] }}
                        </option>
                        @endforeach
                    </select>
                    @error('theme')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label class="flex items-center gap-2">
                    <input type="checkbox"
                        name="is_published"
                        {{ old('is_published', $page->is_published) ? 'checked' : '' }}>
                    <span class="text-sm">Страница опубликована</span>
                </label>
            </div>
        </div>

        {{-- 2. Блоки страницы --}}
        <div class="bg-white p-6 rounded-lg shadow" x-data="{ handle: (item, position) => { ... } }">
            <h2 class="text-xl font-semibold mb-6">Блоки страницы</h2>

            <div id="blocks-container" class="space-y-8" x-sort="handle">
                @foreach($page->blocks as $index => $block)
                @include('admin.partials.block-form', [
                'block' => $block,
                'index' => $index,
                'availableComponents' => $availableComponents ?? []
                ])
                @endforeach
            </div>

            {{-- Добавление нового блока --}}
            <div class="mt-8 flex items-center gap-4">
                <select id="new-component-select"
                    class="border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:border-blue-500">
                    @foreach($availableComponents ?? [] as $name => $class)
                    <option value="{{ $name }}">{{ $class::name() }}</option>
                    @endforeach
                </select>
                <button type="button"
                    onclick="addNewBlock()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md font-medium">
                    + Добавить блок
                </button>
            </div>
        </div>

        {{-- Кнопка сохранения --}}
        <div class="mt-10 flex justify-end">
            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-10 py-4 rounded-lg text-lg font-semibold">
                Сохранить страницу и все блоки
            </button>
        </div>
    </form>
    <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Вы уверены?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Удалить</button>
    </form>
</div>

{{-- Registry компонентов для JS --}}
<script>
    window.componentRegistry = @json($componentRegistry ?? []);
</script>

{{-- JS: добавление / удаление блоков --}}
<script>
    function addNewBlock() {
        const select = document.getElementById('new-component-select');
        const componentName = select.value;
        if (!componentRegistry[componentName]) return alert('Компонент не найден');

        const registry = componentRegistry[componentName];
        const container = document.getElementById('blocks-container');
        const index = container.children.length;

        let html = `
                <div class="block-item bg-gray-50 p-6 rounded-xl border border-gray-200 relative" x-sort:item="${index}" data-index="${index}">
                    <input type="hidden" name="blocks[${index}][id]" value="">
                    <input type="hidden" name="blocks[${index}][component]" value="${componentName}">

                    <button type="button" onclick="removeBlock(this)" 
                            class="absolute top-4 right-4 text-red-600 hover:text-red-800 text-sm font-medium">
                        Удалить блок
                    </button>

                    <h3 class="font-semibold text-lg mb-5">${registry.name}</h3>
            `;

        registry.fields.forEach(field => {
            const fieldName = `blocks[${index}][content][${field.name}]`;
            html += `
                    <div class="mb-5">
                        <label class="block text-sm font-medium mb-2">${field.label}</label>
                `;

            if (field.type === 'text' || field.type === 'media') {
                html += `<input type="text" name="${fieldName}" value="" class="w-full border border-gray-300 rounded-md px-4 py-3">`;
            } else if (field.type === 'textarea') {
                html += `<textarea name="${fieldName}" class="w-full border border-gray-300 rounded-md px-4 py-3 h-28"></textarea>`;
            }

            html += `</div>`;
        });

        html += `</div>`;

        container.insertAdjacentHTML('beforeend', html);
    }

    function removeBlock(btn) {
        if (confirm('Удалить этот блок навсегда?')) {
            btn.closest('.block-item').remove();
        }
    }
</script>
@endsection