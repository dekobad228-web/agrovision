<div id="modal-media-picker"
    class="modal base-modal fixed inset-0 z-50 flex items-center justify-center p-4
           aria-hidden:opacity-0 aria-hidden:pointer-events-none
           opacity-100 pointer-events-auto transition-opacity duration-300"
    aria-hidden="true">

    {{-- Overlay --}}
    <div
        class="absolute inset-0 bg-black/60 backdrop-blur-sm"
        data-micromodal-close>
    </div>

    {{-- Container --}}
    <div
        class="modal__container relative w-full max-w-6xl overflow-hidden rounded-3xl bg-white shadow-2xl border border-gray-200 z-10"
        @click.stop>

        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4 bg-gradient-to-r from-white to-gray-50">
            <div class="flex flex-col">
                <h2 class="text-lg font-semibold text-gray-900">Медиабиблиотека</h2>
                <p class="text-sm text-gray-500">Выберите изображения или видео</p>
            </div>
            <button
                data-micromodal-close
                class="flex h-10 w-10 items-center justify-center rounded-xl text-gray-400 transition hover:bg-gray-100 hover:text-gray-700">
                ✕
            </button>
        </div>

        {{-- Grid --}}
        <div
            class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 p-6 overflow-y-auto max-h-[65vh]"
            x-data
            x-show="$store.mediaPicker.items.length">

            <template x-for="item in $store.mediaPicker.filtered" :key="item.id">
                <div
                    @click="$store.mediaPicker.toggle(item)"
                    :class="$store.mediaPicker.isSelected(item)
                        ? 'ring-4 ring-blue-500 ring-offset-2 border-blue-400 scale-[0.98]'
                        : 'border-gray-200 hover:border-gray-300 hover:shadow-lg hover:-translate-y-0.5'"
                    class="group relative aspect-square overflow-hidden rounded-2xl border bg-gray-100 cursor-pointer transition-all duration-200">

                    <img
                        x-show="item.type === 'image'"
                        :src="item.url"
                        class="h-full w-full object-cover transition duration-300 group-hover:scale-105">

                    <div
                        x-show="item.type === 'video'"
                        class="flex h-full w-full flex-col items-center justify-center gap-2 bg-gradient-to-br from-gray-900 to-gray-800 text-white p-3">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 backdrop-blur">
                            <span class="text-3xl">🎬</span>
                        </div>
                        <span x-text="item.file_name" class="max-w-full truncate text-center text-xs text-gray-200"></span>
                    </div>

                    <div class="absolute inset-0 bg-black/0 transition group-hover:bg-black/10"></div>

                    <div
                        x-show="$store.mediaPicker.isSelected(item)"
                        class="absolute top-3 right-3 flex h-7 w-7 items-center justify-center rounded-full bg-blue-500 text-sm font-bold text-white shadow-lg">
                        ✓
                    </div>
                </div>
            </template>
        </div>

        {{-- Loader --}}
        <div
            class="flex flex-col items-center justify-center gap-3 p-14 text-center text-gray-400"
            x-data
            x-show="!$store.mediaPicker.items.length">
            <div class="h-10 w-10 animate-spin rounded-full border-4 border-gray-200 border-t-blue-500"></div>
            <span class="text-sm">Загрузка медиа...</span>
        </div>

        {{-- Footer --}}
        <div
            class="flex items-center justify-between border-t border-gray-100 bg-gray-50/80 backdrop-blur px-6 py-4"
            x-data
            x-show="$store.mediaPicker.multi">
            <div class="text-sm text-gray-600">
                Выбрано:
                <span x-text="$store.mediaPicker.selected.length" class="font-semibold text-gray-900"></span>
            </div>
            <button
                @click="$store.mediaPicker.confirm()"
                :disabled="$store.mediaPicker.selected.length === 0"
                class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-40">
                Вставить выбранные
            </button>
        </div>

    </div>
</div>