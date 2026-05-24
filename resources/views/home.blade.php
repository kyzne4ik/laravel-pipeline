@extends('layouts.app')

@section('title', 'Главная')
@section('page_title', '')

@section('content')
<div class="row--small">
    <h3>О нас</h3>
    <p>Компания «Очумелые ручки» имеет сайт для обмена информацией с потенциальными или актуальными клиентами. Мы предлагаем различные мастер-классы по множеству видов творчества.</p>
</div>

@if(Auth::check() && Auth::user()->role === 'visitor' && $enrolledClasses->count() > 0)
    <div class="row--small" style="margin-top: 40px;">
        <h3 style="color: #20416c;">Мои записи на мастер-классы</h3>
        <table class="driver-page-table" style="width: 100%; margin-top: 20px;">
            <thead>
                <tr style="text-align: left;">
                    <th style="padding: 10px; border-bottom: 2px solid #20416c;">Дата и время</th>
                    <th style="padding: 10px; border-bottom: 2px solid #20416c;">Название</th>
                    <th style="padding: 10px; border-bottom: 2px solid #20416c;">Ведущий</th>
                    <th style="padding: 10px; border-bottom: 2px solid #20416c;">Тип</th>
                </tr>
            </thead>
            <tbody>
                @foreach($enrolledClasses as $mc)
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #ccc;">
                            {{ \Carbon\Carbon::parse($mc->date)->format('d.m.Y') }}<br>
                            <small>{{ $mc->time_slot }}</small>
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #ccc;">
                            <strong>{{ $mc->title }}</strong>
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #ccc;">
                            {{ $mc->instructor->name }}
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #ccc;">
                            {{ $mc->activity->title }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
