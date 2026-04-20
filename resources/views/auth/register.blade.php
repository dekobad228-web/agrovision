@extends('web.index')

@section('title','Регистрация')

@section('content')
<section class="section-register">
    <div class="container">
        <div class="section-register__block">
            <form method="POST" action="{{ route('register') }}" class="section-register__form">
                @csrf

                <div class="section-register__box">
                    <label for="name">
                        <input type="text" name="name" placeholder="Логин" value="{{ old('name') }}" required>
                    </label>
                    <label for="email">
                        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                    </label>
                    <label for="password">
                        <input type="password" name="password" placeholder="Пароль" required>
                    </label>
                    <label for="password_confirmation">
                        <input type="password" name="password_confirmation" placeholder="Подтвердите пароль" required>
                    </label>
                </div>
                <button type="submit" class="btn btnsection-register__btn">
                    Зарегистрироваться
                </button>
                @if ($errors->any())
                <div class="errors">
                    @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif
            </form>
        </div>
    </div>
</section>
@endsection