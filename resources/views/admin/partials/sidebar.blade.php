<aside class="w-64 bg-gray-800 text-gray-100 min-h-screen p-6 flex flex-col">
    <div class="flex-1 space-y-2">
        {{-- <a href="{{ route('admin') }}"
            class="block px-4 py-2 rounded-md hover:bg-gray-700 hover:text-white transition-colors font-medium">
            Главная
        </a> --}}

        <a href="{{ route('admin.album.index') }}"
            class="block px-4 py-2 rounded-md hover:bg-gray-700 hover:text-white transition-colors font-medium">
            Медиабиблиотека
        </a>

        <a href="{{ route('admin.users.index') }}"
            class="block px-4 py-2 rounded-md hover:bg-gray-700 hover:text-white transition-colors font-medium">
            Пользователи
        </a>

        <a href="{{ route('admin.menu.index') }}"
            class="block px-4 py-2 rounded-md hover:bg-gray-700 hover:text-white transition-colors font-medium">
            Элементы меню
        </a>

        <a href="{{ route('admin.pages.index') }}"
            class="block px-4 py-2 rounded-md hover:bg-gray-700 hover:text-white transition-colors font-medium">
            Страницы
        </a>

        {{-- <a href="{{ route('admin.settings') }}"
            class="block px-4 py-2 rounded-md hover:bg-gray-700 hover:text-white transition-colors font-medium">
            Настройки
        </a>

        <a href="{{ route('admin.statistics') }}"
            class="block px-4 py-2 rounded-md hover:bg-gray-700 hover:text-white transition-colors font-medium">
            Статистика
        </a> --}}
    </div>
</aside>
