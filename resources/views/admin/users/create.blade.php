@extends('admin.dashboard.index')

@section('title', 'Создание пользователя')

@section('content')

<div class="max-w-2xl mx-auto px-4 py-8">

    <h1 class="text-2xl font-bold mb-8">Создание нового пользователя</h1>

    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
        @csrf

        <!-- Имя пользователя -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                Имя пользователя
            </label>
            <input 
                type="text" 
                name="name" 
                id="name"
                value="{{ old('name') }}"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5"
                required
                autocomplete="username"
            >
            @error('name')
                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                Email
            </label>
            <input 
                type="email" 
                name="email" 
                id="email"
                value="{{ old('email') }}"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5"
                required
                autocomplete="email"
            >
            @error('email')
                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Пароль -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                Пароль
            </label>
            <input 
                type="password" 
                name="password" 
                id="password"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5"
                required
                autocomplete="new-password"
                minlength="8"
            >
            @error('password')
                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Подтверждение пароля -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                Подтверждение пароля
            </label>
            <input 
                type="password" 
                name="password_confirmation" 
                id="password_confirmation"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5"
                required
                autocomplete="new-password"
            >
        </div>

        <!-- Роли (множественный выбор) -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Роли
            </label>

            <div class="space-y-2">
                @foreach($roles ?? [] as $role)
                    <label class="inline-flex items-center">
                        <input 
                            type="checkbox" 
                            name="roles[]" 
                            value="{{ $role->id }}" 
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}
                        >
                        <span class="ml-2 text-sm text-gray-700">{{ $role->name }}</span>
                    </label>
                @endforeach

                @if(!$roles ?? false)
                    <p class="text-sm text-gray-500 italic">Роли не найдены в базе данных</p>
                @endif
            </div>

            @error('roles')
                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Кнопки -->
        <div class="flex items-center justify-end gap-4 pt-6">
            <a href="{{ route('admin.users.index') }}"
               class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                Отмена
            </a>
            
            <button type="submit"
                    class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Создать пользователя
            </button>
        </div>
    </form>

</div>

@endsection