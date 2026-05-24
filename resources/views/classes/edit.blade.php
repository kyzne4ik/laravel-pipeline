@extends('layouts.app')

@section('title', 'Редактирование мастер-класса')
@section('page_title', '')

@section('content')
<form method="POST" action="{{ route('master-classes.update', $masterClass->id) }}">
    @csrf
    @method('PUT')
    <h2>Редактирование: {{ $masterClass->title }}</h2>
    
    <div class="form-group" style="margin-bottom: 15px;">
        <label>Описание мастер-класса</label>
        <textarea name="description" required style="height: 100px;">{{ old('description', $masterClass->description) }}</textarea>
    </div>
    
    <div class="form-group" style="margin-bottom: 15px;">
        <label>Стоимость (руб.)</label>
        <input type="number" name="cost" value="{{ old('cost', $masterClass->cost) }}" step="0.01" min="0" required>
    </div>
    <div class="form-group">
        <button type="submit" class="btn">Сохранить</button>
        <a href="{{ route('cabinet') }}" style="margin-left: 10px;">Отмена</a>
    </div>
</form>
@endsection