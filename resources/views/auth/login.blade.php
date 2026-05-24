@extends('layouts.app')

@section('title', 'Вход')
@section('page_title', 'Вход')

@section('content')
<div class="row">
    <div style="max-width: 500px; margin: 0 auto; padding: 20px; background: #fff;">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div style="margin-bottom: 15px;">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 8px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" required style="width: 100%; padding: 8px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <button type="submit" class="btn">Войти</button>
            </div>
            
            <div style="margin-top: 15px;">
                <a href="{{ route('register') }}">Регистрация</a>
            </div>
        </form>
    </div>
</div>
@endsection