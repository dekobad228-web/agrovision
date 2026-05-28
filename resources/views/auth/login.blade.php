@extends('web.index')

@section('title','Вход')

@section('content')

<section class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md px-6 py-8 bg-white rounded-xl shadow-lg">
        <h1 class="text-2xl font-semibold text-center mb-6">Вход</h1>
        <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
            @csrf
            <div class="space-y-4">
                <input 
                    type="text" 
                    name="name" 
                    placeholder="Логин" 
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400"
                >
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Пароль" 
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400"
                >
            </div>
            <button 
                type="submit" 
                class="w-full bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-2 rounded-lg transition"
            >
                Войти
            </button>
            @if ($errors->any())
                <div class="text-red-500 text-sm mt-2 text-center">
                    {{ $errors->first() }}
                </div>
            @endif
        </form>
    </div>
</section>

@endsection