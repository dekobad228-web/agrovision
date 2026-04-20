@extends('admin.dashboard.index')

@section('title', 'Меню')

@section('content')
<div class="w-full px-6 py-8 space-y-10 bg-gray-50 min-h-screen">

    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Меню</h1>
        <p class="text-gray-500 mt-1">Управление навигационными меню</p>
    </div>

    <!-- Form Block -->
    <div class="w-full bg-white rounded-2xl shadow-sm p-8 space-y-6">

        <h2 class="text-xl font-semibold text-gray-900">
            Создать меню
        </h2>

        <form method="POST" action="{{ route('admin.menu.store') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Название
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3
                           focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    placeholder="Главное меню"
                    required
                >
                @error('name')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Slug
                </label>
                <input
                    type="text"
                    name="slug"
                    value="{{ old('slug') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3
                           focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    placeholder="main-menu"
                    required
                >
                <p class="text-gray-400 text-xs mt-2">
                    Только латиница, цифры и дефис
                </p>

                @error('slug')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Button -->
            <div class="flex justify-end">
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl
                           font-medium transition shadow-sm"
                >
                    Создать меню
                </button>
            </div>
        </form>
    </div>

    <!-- List Block -->
    <div class="w-full bg-white rounded-2xl shadow-sm p-8 space-y-4">

        <h2 class="text-xl font-semibold text-gray-900">
            Существующие меню
        </h2>

        <div class="space-y-3">
            @foreach ($menus as $menu)
                <a
                    href="{{ route('admin.menu.show', $menu->id) }}"
                    class="flex items-center justify-between p-5 rounded-xl
                           bg-gray-50 hover:bg-blue-50 transition group"
                >
                    <div>
                        <div class="font-medium text-gray-900 group-hover:text-blue-600">
                            {{ $menu->name }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $menu->slug }}
                        </div>
                    </div>

                    <div class="text-gray-400 group-hover:text-blue-500 transition">
                        →
                    </div>
                </a>
            @endforeach
        </div>

    </div>

</div>
@endsection