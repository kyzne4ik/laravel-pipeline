@extends('layouts.app')

@section('title', $activity->title)
@section('page_title', $activity->title)

@section('content')
    <img src="{{ $activity->image_path ? asset($activity->image_path) : asset('img/elifant.png') }}">
    @php
        $paragraphs = explode("\n", $activity->description);
    @endphp
    @foreach($paragraphs as $p)
        @if(trim($p))
            <p>{{ $p }}</p>
        @endif
    @endforeach
@endsection

@section('after_main')
<div class="row shedule">
    <div class="row--small">
        <h2>Расписание</h2>
        <div class="drivers">
            @forelse($masterClasses as $class)
                <div class="driver">
                    <div class="driver-left">
                        <div class="driver-photo">
                            <img src="{{ $class->instructor->photo_path ? asset($class->instructor->photo_path) : asset('img/driver1.png') }}">
                        </div>
                        <div class="driver-text">
                            <div class="driver-name">{{ $class->instructor->name }}</div>
                            <div class="driver-desc">
                                {{ $class->description }}
                            </div>
                        </div>
                    </div>
                    <div class="driver-right">
                         @auth
                             @if(Auth::user()->role === 'visitor')
                                 @php
                                     $isEnrolled = $class->enrollments->contains('user_id', Auth::id());
                                     $startTime = \Carbon\Carbon::parse($class->date . ' ' . explode('-', $class->time_slot)[0]);
                                     $isPast = $startTime->isPast();
                                 @endphp
                                 @if($isPast)
                                     <button class="driver-btn" disabled style="background: #ccc; cursor: not-allowed; border-color: #ccc;">Запись закрыта</button>
                                 @elseif($isEnrolled)
                                     <button class="driver-btn" disabled style="background: #e67e22; cursor: default; border-color: #e67e22; color: white;">вы записаны</button>
                                 @elseif($class->available_spots > 0)
                                     <a href="{{ route('enrollment.confirm', $class->id) }}" class="driver-btn">записаться</a>
                                 @else
                                     <button class="driver-btn" disabled style="background: #ccc; cursor: not-allowed; border-color: #ccc;">мест нет</button>
                                 @endif
                             @endif
                         @endauth
                        <div class="driver-time">
                            @php
                                $date = \Carbon\Carbon::parse($class->date);
                                $months = [
                                    1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля', 
                                    5 => 'мая', 6 => 'июня', 7 => 'июля', 8 => 'августа', 
                                    9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря'
                                ];
                                $monthName = $months[$date->month];
                                $time = explode('-', $class->time_slot)[0];
                            @endphp
                            {{ $date->day }} {{ $monthName }} {{ $time }}
                        </div>
                    </div>	
                </div>
            @empty
                <span>Пока нет запланированных мастер-классов по этому виду творчества.</span>
            @endforelse
        </div>
    </div>
</div>
@endsection
