<header class="bg-white shadow-md">
    <div class="container mx-auto px-6 py-4 flex items-center justify-between">
        {{-- Название и роль --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Шапка админ панель</h1>
            <p class="text-gray-600 text-sm">Ваша роль: {{ Auth::user()->roles->first()->name }}</p>
        </div>

        {{-- Форма выхода --}}
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-md transition-colors">
                Выйти
            </button>
        </form>
    </div>
</header>