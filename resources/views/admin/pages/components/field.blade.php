<template x-if="field.type === 'text'">
    <input type="text"
        class="w-full border border-gray-200 bg-gray-50 rounded-lg px-3 py-2
               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
        x-model="content[field.name]">
</template>

<template x-if="field.type === 'textarea'">
    <textarea
        class="w-full border border-gray-200 bg-gray-50 rounded-lg px-3 py-2
               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
        x-model="content[field.name]">
    </textarea>
</template>

<template x-if="field.type === 'wysiwyg'">
    <div
        x-data="tinymceEditor(content, field.name)"
        x-init="init()"
        x-effect="$el.__x && destroy()"
    >
        <textarea :id="editorId"></textarea>
    </div>
</template>

<template x-if="field.type === 'image'">
    <div>
        <template x-if="content[field.name]?.id">
            <div class="relative w-32 h-32 rounded-lg overflow-hidden border border-gray-200">
                <img :src="content[field.name].url" :alt="content[field.name].alt_text"
                    class="w-full h-full object-cover">
                <button type="button" @click="content[field.name] = null"
                    class="absolute top-1 right-1 bg-white rounded-full p-0.5 shadow text-red-500 text-xs">✕</button>
            </div>
        </template>

        <button type="button" @click="openMediaPicker(content, field)"
            class="mt-2 px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 rounded-lg border border-gray-300 transition">
            <span x-text="content[field.name]?.id ? 'Заменить изображение' : 'Выбрать изображение'"></span>
        </button>
    </div>
</template>

<template x-if="field.type === 'gallery'">
    <div>
        <div class="flex flex-wrap gap-2">
            <template x-for="(media, mi) in (content[field.name] || [])" :key="media.id">
                <div class="relative w-24 h-24 rounded-lg overflow-hidden border">
                    <img x-show="media.type === 'image'" :src="media.url" class="w-full h-full object-cover">
                    <div x-show="media.type === 'video'"
                        class="w-full h-full bg-gray-800 flex items-center justify-center text-white text-xs">
                        🎬 <span x-text="media.file_name" class="truncate max-w-[60px]"></span>
                    </div>
                    <button type="button" @click="content[field.name].splice(mi, 1)"
                        class="absolute top-1 right-1 bg-white rounded-full p-0.5 shadow text-red-500 text-xs">✕</button>
                </div>
            </template>
        </div>

        <button type="button" @click="openMediaPicker(content, field)"
            class="mt-2 px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 rounded-lg border border-gray-300 transition">
            Добавить медиа
        </button>
    </div>
</template>
