<template x-for="(block, index) in blocks" :key="block.id">

    <div class="block-item bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden" x-data="{ open: true }">

        <input type="hidden" :name="`blocks[${index}][component]`" :value="block.component">

        <!-- HEADER -->
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b">

            <div class="flex items-center gap-3">

                <div x-sort:handle class="cursor-move text-gray-400 hover:text-gray-600">
                    ⠿
                </div>

                <div class="font-semibold text-gray-800 text-sm uppercase tracking-wide">
                    <span x-text="block.component"></span>
                </div>

            </div>

            <button type="button" @click.stop="open = !open"
                class="text-xs text-gray-500 hover:text-gray-700 transition">

                <span x-show="!open">Скрыть</span>
                <span x-show="open">Показать</span>

            </button>

        </div>

        <!-- CONTENT -->
        <div x-show="!open" class="p-5 space-y-4 bg-white">

            <template x-for="field in (registry[block.component]?.fields || [])" :key="field.name">

                <div class="space-y-1">

                    <label x-text="field.label" class="text-xs font-medium text-gray-600"></label>

                    <template x-if="field.type === 'text'">
                        <input type="text"
                            class="w-full border border-gray-200 bg-gray-50 rounded-lg px-3 py-2
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                            :name="`blocks[${index}][content][${field.name}]`" x-model="block.content[field.name]">
                    </template>

                    <template x-if="field.type === 'textarea'">
                        <textarea
                            class="w-full border border-gray-200 bg-gray-50 rounded-lg px-3 py-2
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                            :name="`blocks[${index}][content][${field.name}]`" x-model="block.content[field.name]">
                    </textarea>
                    </template>

                    {{-- Поле image --}}
                    <template x-if="field.type === 'image'">
                        <div>
                            <input type="hidden" :name="`blocks[${index}][content][${field.name}][id]`"
                                :value="block.content[field.name]?.id ?? ''">
                            <input type="hidden" :name="`blocks[${index}][content][${field.name}][url]`"
                                :value="block.content[field.name]?.url ?? ''">
                            <input type="hidden" :name="`blocks[${index}][content][${field.name}][path]`"
                                :value="block.content[field.name]?.path ?? ''">
                            <input type="hidden" :name="`blocks[${index}][content][${field.name}][name]`"
                                :value="block.content[field.name]?.name ?? ''">
                            <input type="hidden" :name="`blocks[${index}][content][${field.name}][file_name]`"
                                :value="block.content[field.name]?.file_name ?? ''">
                            <input type="hidden" :name="`blocks[${index}][content][${field.name}][alt_text]`"
                                :value="block.content[field.name]?.alt_text ?? ''">
                            <input type="hidden" :name="`blocks[${index}][content][${field.name}][type]`"
                                :value="block.content[field.name]?.type ?? ''">
                            <input type="hidden" :name="`blocks[${index}][content][${field.name}][mime_type]`"
                                :value="block.content[field.name]?.mime_type ?? ''">
                            <input type="hidden" :name="`blocks[${index}][content][${field.name}][extension]`"
                                :value="block.content[field.name]?.extension ?? ''">
                            <input type="hidden" :name="`blocks[${index}][content][${field.name}][size]`"
                                :value="block.content[field.name]?.size ?? ''">

                            {{-- Превью --}}
                            <template x-if="block.content[field.name]?.id">
                                <div class="relative w-32 h-32 rounded-lg overflow-hidden border border-gray-200">
                                    <img :src="block.content[field.name].url"
                                        :alt="block.content[field.name].alt_text" class="w-full h-full object-cover">
                                    <button type="button" @click="block.content[field.name] = null"
                                        class="absolute top-1 right-1 bg-white rounded-full p-0.5 shadow text-red-500 text-xs">
                                        ✕
                                    </button>
                                </div>
                            </template>

                            {{-- Кнопка --}}
                            <button type="button" @click="openMediaPicker(block, field)"
                                class="mt-2 px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 rounded-lg border border-gray-300 transition">
                                <span
                                    x-text="block.content[field.name]?.id ? 'Заменить изображение' : 'Выбрать изображение'"></span>
                            </button>
                        </div>
                    </template>

                    {{-- Поле gallery --}}
                    <template x-if="field.type === 'gallery'">
                        <div>
                            <template x-for="(media, mi) in (block.content[field.name] || [])" :key="media.id">
                                <div>
                                    <input type="hidden" :name="`blocks[${index}][content][${field.name}][${mi}][id]`"
                                        :value="media.id">
                                    <input type="hidden"
                                        :name="`blocks[${index}][content][${field.name}][${mi}][url]`"
                                        :value="media.url">
                                    <input type="hidden"
                                        :name="`blocks[${index}][content][${field.name}][${mi}][path]`"
                                        :value="media.path">
                                    <input type="hidden"
                                        :name="`blocks[${index}][content][${field.name}][${mi}][name]`"
                                        :value="media.name">
                                    <input type="hidden"
                                        :name="`blocks[${index}][content][${field.name}][${mi}][file_name]`"
                                        :value="media.file_name">
                                    <input type="hidden"
                                        :name="`blocks[${index}][content][${field.name}][${mi}][alt_text]`"
                                        :value="media.alt_text ?? ''">
                                    <input type="hidden"
                                        :name="`blocks[${index}][content][${field.name}][${mi}][type]`"
                                        :value="media.type">
                                    <input type="hidden"
                                        :name="`blocks[${index}][content][${field.name}][${mi}][mime_type]`"
                                        :value="media.mime_type">
                                    <input type="hidden"
                                        :name="`blocks[${index}][content][${field.name}][${mi}][extension]`"
                                        :value="media.extension">
                                    <input type="hidden"
                                        :name="`blocks[${index}][content][${field.name}][${mi}][size]`"
                                        :value="media.size">
                                </div>
                            </template>

                            {{-- Превью галереи --}}
                            <div class="flex flex-wrap gap-2">
                                <template x-for="(media, mi) in (block.content[field.name] || [])"
                                    :key="media.id">
                                    <div class="relative w-24 h-24 rounded-lg overflow-hidden border">
                                        <img x-show="media.type === 'image'" :src="media.url"
                                            class="w-full h-full object-cover">
                                        <div x-show="media.type === 'video'"
                                            class="w-full h-full bg-gray-800 flex items-center justify-center text-white text-xs">
                                            🎬 <span x-text="media.file_name" class="truncate max-w-[60px]"></span>
                                        </div>
                                        <button type="button" @click="block.content[field.name].splice(mi, 1)"
                                            class="absolute top-1 right-1 bg-white rounded-full p-0.5 shadow text-red-500 text-xs">
                                            ✕
                                        </button>
                                    </div>
                                </template>
                            </div>

                            <button type="button" @click="openMediaPicker(block, field)"
                                class="mt-2 px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 rounded-lg border border-gray-300 transition">
                                Добавить медиа
                            </button>
                        </div>
                    </template>

                </div>

            </template>

            <button type="button" @click="removeBlock(index)" class="text-red-600 text-sm hover:underline">
                Удалить блок
            </button>

        </div>

    </div>

</template>
