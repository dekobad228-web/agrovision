@extends('web.index')

@section('template_name', 'По умолчанию')
@section('title', $currentPage->title)

@section('content')

    @foreach ($blocks as $theme => $block)
        @php
            $isMultiple = count($blocks) > 1;
            $sectionsCount = count($block);

            $classes = ['theme-section'];

            if ($isMultiple) {
                $classes[] = 'theme-section-multiple';
                $classes[] = $loop->first ? 'theme-section-multiple--first' : 'theme-section-multiple--second';
            } else {
                $classes[] = 'theme-section-single';
                if ($sectionsCount > 3) {
                    $classes[] = 'theme-section-single--large';
                }
            }
        @endphp
        <div class="{{ $theme }} {{ implode(' ', $classes) }}">
            @if ($isMultiple && !$loop->first)
                <x-ui.ellipse />
            @endif
            @foreach ($block as $section)
                @php
                    $viewPath = 'components.blocks.' . $section->component;
                @endphp
                @if (View::exists($viewPath))
                    @include($viewPath, [
                        'content' => $section->content ?? [],
                    ])
                @endif
            @endforeach
        </div>
    @endforeach
@endsection
