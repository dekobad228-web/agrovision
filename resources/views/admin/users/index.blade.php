@extends('admin.dashboard.index')

@section('title', 'Пользователи')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <!-- Заголовок + кнопка создания -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Пользователи
            </h1>
            <p class="mt-1 text-sm text-gray-600">
                Управление учётными записями
            </p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Создать пользователя
            </a>
        </div>
    </div>

    <!-- Список пользователей -->
    @if($users->isEmpty())
        <div class="bg-white shadow rounded-lg p-8 text-center text-gray-500">
            Пользователей пока нет
        </div>
    @else
        <div class="bg-white shadow overflow-hidden rounded-lg">
            <ul role="list" class="divide-y divide-gray-200">
                @foreach($users as $user)
                    <li>
                        <a href="{{ route('admin.users.show', $user->id) }}"
                           class="block hover:bg-gray-50 transition-colors">
                            <div class="px-6 py-5 flex items-center justify-between">
                                <div class="flex items-center min-w-0 flex-1">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <span class="text-indigo-600 font-medium">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div class="ml-4 truncate">
                                        <div class="text-sm font-medium text-gray-900 truncate">
                                            {{ $user->name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>

                                <div class="ml-6 flex-shrink-0 flex flex-col items-end">
                                    <!-- Роли -->
                                    <div class="flex flex-wrap gap-1.5 justify-end mb-1.5">
                                        @forelse($user->roles as $role)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                {{ $role->name }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-gray-500 italic">
                                                без ролей
                                            </span>
                                        @endforelse
                                    </div>

                                    <!-- Дата создания -->
                                    <div class="text-xs text-gray-500">
                                        Создан: {{ $user->created_at->format('d.m.Y') }}
                                        <span class="text-gray-400">·</span>
                                        {{ $user->created_at->diffForHumans() }}
                                    </div>
                                </div>

                                <div class="ml-4 flex-shrink-0">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection