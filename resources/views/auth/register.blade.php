@extends('layouts.app')

@section('title', 'Регистрация')
@section('page_title', 'Регистрация')

@section('content')
<div class="row--small">
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group" style="margin-bottom: 15px;">
            <label>ФИО</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label>Пароль</label>
            <input type="password" name="password" required>
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label>Подтвердите пароль</label>
            <input type="password" name="password_confirmation" required>
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label>Номер телефона</label>
            <input type="tel" name="phone" value="{{ old('phone') }}" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn">Зарегистрироваться</button>
        </div>
    </form>
</div>
@endsection