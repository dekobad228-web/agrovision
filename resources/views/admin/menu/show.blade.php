@extends('admin.dashboard.index')

@section('title', 'Редактирование меню')

@section('content')
<div class="w-full min-h-screen bg-gray-50 px-6 py-8 space-y-8">

    <!-- HEADER -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Редактирование меню</h1>
        <p class="text-gray-500 mt-1">{{ $menu->name }}</p>
    </div>

    <!-- DELETE -->
    <form action="{{ route('admin.menu.destroy', $menu) }}"
          method="POST"
          onsubmit="return confirm('Вы уверены?');">
        @csrf
        @method('DELETE')

        <button type="submit"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl">
            Удалить
        </button>
    </form>

    <!-- UPDATE -->
    <form method="POST"
          action="{{ route('admin.menu.update', $menu->id) }}"
          class="space-y-8">

        @csrf
        @method('PATCH')

        <!-- MENU SETTINGS -->
        <div class="bg-white rounded-2xl shadow-sm p-8 space-y-6">

            <h2 class="text-xl font-semibold text-gray-900">Основные настройки</h2>

            <!-- NAME -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Название</label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $menu->name) }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:border-blue-500">
            </div>

            <!-- SLUG -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                <input type="text"
                       name="slug"
                       value="{{ old('slug', $menu->slug) }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:border-blue-500">
            </div>

        </div>

        <!-- ITEMS -->
        <div class="bg-white rounded-2xl shadow-sm p-8 space-y-6">

            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900">Пункты меню</h2>

                <button type="button"
                        onclick="addItem()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm">
                    + Добавить
                </button>
            </div>

            <!-- CONTAINER -->
            <div id="items" class="space-y-4" x-data="{ handle: (item, position) => { ... } }" x-sort="handle">

                @foreach ($menu->items as $i => $item)
                    @php $isPage = $item->type === 'page'; @endphp

                    <div class="menu-item p-5 rounded-xl bg-gray-50 space-y-4 relative"
                         x-sort:item="{{ $i }}">

                        <input type="hidden" name="items[{{ $i }}][id]" value="{{ $item->id }}">

                        <!-- TYPE -->
                        <select name="items[{{ $i }}][type]"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3"
                                onchange="toggleType(this)">
                            <option value="page" @selected($isPage)>Страница</option>
                            <option value="external" @selected(!$isPage)>Внешняя ссылка</option>
                        </select>

                        <!-- TITLE -->
                        <input type="text"
                               name="items[{{ $i }}][title]"
                               value="{{ $item->title }}"
                               placeholder="Название"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3">

                        <!-- PAGE -->
                        <div class="page-block" style="{{ $isPage ? '' : 'display:none' }}">
                            <select name="items[{{ $i }}][page_id]"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3">
                                <option value="">Выберите страницу</option>

                                @foreach ($pages as $page)
                                    <option value="{{ $page['id'] }}"
                                            @selected($item->page_id == $page['id'])>
                                        {{ $page['title'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- EXTERNAL -->
                        <div class="external-block" style="{{ !$isPage ? '' : 'display:none' }}">
                            <input type="text"
                                   name="items[{{ $i }}][url]"
                                   value="{{ $item->url }}"
                                   placeholder="https://example.com"
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3">
                        </div>

                        <!-- DELETE -->
                        <button type="button"
                                onclick="removeBlock(this)"
                                class="absolute top-4 right-4 text-red-600 text-sm">
                            Удалить
                        </button>

                    </div>
                @endforeach

            </div>
        </div>

        <!-- SAVE -->
        <div class="flex justify-end">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl">
                Сохранить
            </button>
        </div>

    </form>
</div>
@endsection

<script>
    let index = {{ count($menu->items) }};
    const pageOptions = @json($pages);

    function toggleType(select) {
        const block = select.closest('.menu-item');
        if (!block) return;

        const page = block.querySelector('.page-block');
        const external = block.querySelector('.external-block');

        if (select.value === 'page') {
            page.style.display = 'block';
            external.style.display = 'none';
        } else {
            page.style.display = 'none';
            external.style.display = 'block';
        }
    }

    function addItem() {
        const container = document.getElementById('items');

        let pageOptionsHtml = `<option value="">Выберите страницу</option>`;

        for (const page of pageOptions) {
            pageOptionsHtml += `<option value="${page.id}">${page.title}</option>`;
        }

        const i = index;

        const html = `
        <div class="menu-item p-5 rounded-xl bg-gray-50 space-y-4 relative"
             x-sort:item="${i}">

            <input type="hidden" name="items[${i}][id]" value="">

            <select name="items[${i}][type]"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3"
                    onchange="toggleType(this)">
                <option value="page">Страница</option>
                <option value="external">Внешняя ссылка</option>
            </select>

            <input type="text"
                   name="items[${i}][title]"
                   placeholder="Название"
                   class="w-full border border-gray-300 rounded-xl px-4 py-3">

            <div class="page-block">
                <select name="items[${i}][page_id]"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3">
                    ${pageOptionsHtml}
                </select>
            </div>

            <div class="external-block" style="display:none">
                <input type="text"
                       name="items[${i}][url]"
                       placeholder="https://example.com"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3">
            </div>

            <button type="button"
                    onclick="removeBlock(this)"
                    class="absolute top-4 right-4 text-red-600 text-sm">
                Удалить
            </button>

        </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
        index++;
    }

    function removeBlock(btn) {
        if (confirm('Удалить этот блок?')) {
            btn.closest('.menu-item')?.remove();
        }
    }
</script>
