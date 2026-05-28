@extends('web.index')

@section('template_name', 'Кастомная главная')
@section('title', $currentPage->title)

@section('content')
<h1>Кастомная главная страница</h1>

<h1 class="text-h1-400">
    H1 400
</h1>
<h1 class="text-h1-500">
    H1 500
</h1>
<h1 class="text-h1-600">
    H1 600
</h1>
<h1 class="text-h1-700">
    H1 700
</h1>

@endsection