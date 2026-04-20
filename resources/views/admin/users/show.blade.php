@extends('admin.dashboard.index')

@section('title', 'Пользователь')

@section('content')

<div class="max-w-3xl mx-auto space-y-8">

    {{-- Карточка пользователя --}}
    <div class="bg-white shadow rounded-xl p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            {{ $user->name }}
        </h2>

        <ul class="space-y-2 text-gray-600">
            <li><span class="font-semibold">ID:</span> {{ $user->id }}</li>
            <li><span class="font-semibold">Email:</span> {{ $user->email }}</li>
            <li>
                <span class="font-semibold">Дата регистрации:</span>
                {{ $user->created_at->format('d.m.Y H:i') }}
            </li>
        </ul>
    </div>


    {{-- Форма редактирования --}}
    <div class="bg-white shadow rounded-xl p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-6">
            Редактировать пользователя
        </h3>

        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-5">
            @csrf

            {{-- Имя --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Имя
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                @error('email')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
                @enderror
            </div>


            {{-- Новый пароль --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Новый пароль
                </label>

                <input
                    type="password"
                    name="password"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            {{-- Подтверждение пароля --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Подтверждение пароля
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>


            {{-- Кнопка --}}
            <div class="pt-3">
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-lg transition">
                    Сохранить
                </button>
            </div>

        </form>
        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Вы уверены?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Удалить</button>
        </form>
    </div>

</div>

@endsection