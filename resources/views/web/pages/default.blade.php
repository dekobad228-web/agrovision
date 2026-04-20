@extends('web.index')

@section('template_name', 'По умолчанию')
@section('title', $currentPage->title)

@section('content')

@foreach($blocks as $theme => $block)
    <div class="{{ $theme }} theme-section">
        @foreach($block as $section)
            @php
                $viewPath = 'components.blocks.' . $section->component;
            @endphp
            @if(View::exists($viewPath))
                @include($viewPath, [
                    'content' => $section->content ?? [],
                ])
            @endif
        @endforeach
    </div>
@endforeach
@endsection