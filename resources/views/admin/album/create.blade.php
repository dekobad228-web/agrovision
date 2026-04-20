@extends('admin.dashboard.index')

@section('title', 'Создать альбом')

@section('content')
<div class="p-6 max-w-2xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">
        Создание нового альбома
    </h1>

    @if ($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 rounded-lg p-4">
            <ul class="text-sm text-red-700 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>— {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.album.store') }}">
        @csrf

        <div class="bg-white p-6 rounded-lg shadow space-y-6">

            {{-- Заголовок --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Заголовок альбома
                </label>

                <input
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
                    class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:border-blue-500"
                    required
                >

                @error('title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Slug --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Slug
                </label>

                <input
                    type="text"
                    name="slug"
                    value="{{ old('slug') }}"
                    class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:border-blue-500"
                    required
                >

                @error('slug')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror

                <p class="text-gray-500 text-xs mt-1">
                    Используйте латинские буквы, цифры и дефис (пример: letniy-albom)
                </p>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-medium transition"
                >
                    Создать альбом
                </button>
            </div>

        </div>
    </form>
</div>
@endsection