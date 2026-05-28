<template x-for="(block, index) in blocks" :key="block._key">
    <div class="block-item bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden"
         x-data="{ open: false }" :data-key="block._key">

        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b">
            <div class="flex items-center gap-3">
                <div x-sort:handle class="cursor-move text-gray-400 hover:text-gray-600">⠿</div>
                <div class="font-semibold text-gray-800 text-sm uppercase tracking-wide">
                    <span x-text="block.component"></span>
                </div>
            </div>
            <button type="button" @click.stop="open = !open"
                class="text-xs text-gray-500 hover:text-gray-700 transition">
                <span x-show="open">Скрыть</span>
                <span x-show="!open">Показать</span>
            </button>
        </div>

        <div x-show="open" class="p-5 space-y-4 bg-white">

            <template x-for="field in (registry[block.component]?.fields || [])" :key="field.name">
                <div class="space-y-1">

                    <label x-text="field.label" class="text-xs font-medium text-gray-600"></label>

                    <template x-if="field.type !== 'repeater'">
                        <div x-data="{
                            field: field,
                            content: block.content,
                        }">
                            @include('admin.pages.components.field')
                        </div>
                    </template>

                    <template x-if="field.type === 'repeater'">
                        <div class="space-y-3">

                            <template x-for="(row, ri) in (block.content[field.name] || [])" :key="ri">
                                <div class="border border-gray-200 rounded-xl p-4 space-y-3 bg-gray-50">

                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide"
                                            x-text="`# ${ri + 1}`"></span>
                                        <button type="button"
                                            @click="block.content[field.name].splice(ri, 1)"
                                            class="w-6 h-6 flex items-center justify-center rounded-full
                                                   bg-red-50 text-red-500 hover:bg-red-100 transition text-sm">
                                            −
                                        </button>
                                    </div>

                                    <template x-for="subField in field.fields" :key="subField.name">
                                        <div class="space-y-1">
                                            <label x-text="subField.label"
                                                class="text-xs font-medium text-gray-600"></label>

                                            <div x-data="{
                                                field: subField,
                                                content: row,
                                            }">
                                                @include('admin.pages.components.field')
                                            </div>
                                        </div>
                                    </template>

                                </div>
                            </template>

                            <button type="button"
                                @click="
                                    if (!Array.isArray(block.content[field.name])) block.content[field.name] = [];
                                    const row = {};
                                    field.fields.forEach(f => { row[f.name] = f.type === 'gallery' ? [] : null });
                                    block.content[field.name].push(row)
                                "
                                class="w-full py-2 text-sm text-blue-600 border border-dashed border-blue-300
                                       rounded-xl hover:bg-blue-50 transition flex items-center justify-center gap-1">
                                <span class="text-lg leading-none">+</span>
                                <span>Добавить</span>
                            </button>

                        </div>
                    </template>

                </div>
            </template>

            <button type="button" @click="removeBlock(index)"
                class="text-red-600 text-sm hover:underline">
                Удалить блок
            </button>

        </div>

    </div>
</template>
