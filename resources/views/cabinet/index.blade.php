@extends('layouts.app')

@section('title', 'Личный кабинет')
@section('page_title', '')

@section('content')
<div class="driver-page-photo">
    @if($user->role === 'instructor')
        <img src="{{ $user->photo_path ? asset($user->photo_path) : asset('img/driver-page.png') }}">
    @endif
</div>	
<div class="driver-page-name">{{ $user->name }}</div>
<div class="driver-page-text">
    <div class="driver-page-my">
        {{ $user->role === 'instructor' ? 'Мои мастер-классы' : 'Мои записи' }}
    </div>
    <table class="driver-page-table">
        <tbody>
            @if($user->role === 'instructor')
                @forelse($masterClasses as $class)
                <tr>
                    <td>
                        @php
                            $date = \Carbon\Carbon::parse($class->date);
                            $months = [1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля', 5 => 'мая', 6 => 'июня', 7 => 'июля', 8 => 'августа', 9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря'];
                            $time = explode('-', $class->time_slot)[0];
                        @endphp
                        {{ $date->day }} {{ $months[$date->month] }} {{ $time }}
                    </td>
                    <td>
                        <b>{{ $class->title }}</b>
                        <div class="cabinet-visitor-list">
                        @foreach($class->enrollments as $index => $enrollment)
                            <div class="cabinet-visitor">
                                <p>{{ $index + 1 }}. {{ $enrollment->user->name }}</p>
                                <p>email: {{ $enrollment->user->email }} </p>
                                <p>tel: {{ $enrollment->user->phone }} </p>
                            </div>
                        @endforeach
                        </div>
                        @if($class->enrollments->isEmpty())
                            <p>Записей пока нет</p>
                        @endif
                        <div style="margin-top: 10px;">
                            <a href="{{ route('master-classes.edit', $class->id) }}" style="font-size: 12px; color: #666; text-decoration: underline;">Редактировать описание/стоимость</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2">У вас пока нет мастер-классов.</td>
                </tr>
                @endforelse
            @else
                {{-- Visitor View --}}
                @forelse($user->enrollments as $enrollment)
                <tr>
                    <td>
                        @php
                            $date = \Carbon\Carbon::parse($enrollment->masterClass->date);
                            $months = [1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля', 5 => 'мая', 6 => 'июня', 7 => 'июля', 8 => 'августа', 9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря'];
                            $time = explode('-', $enrollment->masterClass->time_slot)[0];
                        @endphp
                        {{ $date->day }} {{ $months[$date->month] }} {{ $time }}
                    </td>
                    <td>
                        <b>{{ $enrollment->masterClass->title }}</b>
                        <p>Ведущий: {{ $enrollment->masterClass->instructor->name }}</p>
                        <p>Место: ВДНХ, 120в</p>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2">Вы еще не записались ни на один мастер-класс.</td>
                </tr>
                @endforelse
            @endif
        </tbody>
    </table>
</div>
@if($user->role === 'instructor')
    <div class="driver-page-btn-wrapper">
        <a href="{{ route('master-classes.create') }}" class="driver-page-btn btn" style="text-decoration: none; display: inline-block; text-align: center; line-height: 40px;">
            Добавить мастер-класс
        </a>
    </div>
@endif
@endsection
