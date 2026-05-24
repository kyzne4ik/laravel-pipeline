@extends('layouts.app')

@section('title', 'Подтверждение записи')
@section('page_title', 'Подтверждение записи')

@section('content')
<div class="row--small">
    <h3>Подтвердите вашу запись</h3>
    <p><strong>Пользователь:</strong> {{ Auth::user()->name }}</p>
    <p><strong>Вид творчества:</strong> {{ $masterClass->activity->title }}</p>
    <p><strong>Мастер-класс:</strong> {{ $masterClass->title }}</p>
    <p><strong>Ведущий:</strong> {{ $masterClass->instructor->name }}</p>
    <p><strong>Дата и время:</strong> {{ \Carbon\Carbon::parse($masterClass->date)->format('d.m.Y') }} ({{ $masterClass->time_slot }})</p>
    <p><strong>Стоимость:</strong> {{ $masterClass->cost }} руб.</p>

    <form method="POST" action="{{ route('enrollment.store', $masterClass->id) }}">
        @csrf
        <button type="submit" class="btn-enroll" style="background-color: green;">Подтвердить</button>
        <a href="{{ route('activity.show', $masterClass->activity_id) }}" class="btn-enroll" style="background-color: red; color: white; text-decoration: none;">Отмена</a>
    </form>
</div>
@endsection