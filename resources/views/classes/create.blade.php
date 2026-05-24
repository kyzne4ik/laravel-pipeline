@extends('layouts.app')

@section('title', 'Добавление мастер-класса')
@section('page_title', '')

@section('content')
<form method="POST" action="{{ route('master-classes.store') }}">
    @csrf
    <h2>Форма добавления мастер-класса</h2>
    <div class="form-group" style="margin-bottom: 15px;">
        <label>Вид творчества</label>
        <select name="activity_id" required>
            @foreach($activities as $activity)
                <option value="{{ $activity->id }}" {{ old('activity_id') == $activity->id ? 'selected' : '' }}>{{ $activity->title }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group" style="margin-bottom: 15px;">
        <label>Название мастер-класса</label>
        <input type="text" name="title" value="{{ old('title') }}" required>
    </div>
    <div class="form-group" style="margin-bottom: 15px;">
        <label>Описание мастер-класса</label>
        <textarea name="description" required style="height: 100px;">{{ old('description') }}</textarea>
    </div>
    <div class="form-group" style="margin-bottom: 15px;">
        <label>Дата</label>
        <input type="date" name="date" id="class_date" value="{{ old('date') }}" required>
    </div>
    <div class="form-group" style="margin-bottom: 15px;">
        <label>Время</label>
        <select name="time_slot" id="time_slot" required>
            @php
                $slots = ['09:00-11:00', '11:00-13:00', '13:00-15:00', '15:00-17:00'];
            @endphp
            @foreach($slots as $slot)
                <option value="{{ $slot }}" {{ old('time_slot') == $slot ? 'selected' : '' }}>{{ $slot }}</option>
            @endforeach
        </select>
    </div>

    <script>
        const busySlots = @json($busySlots);
        const dateInput = document.getElementById('class_date');
        const slotSelect = document.getElementById('time_slot');

        function updateSlots() {
            const selectedDate = dateInput.value;
            const busyForDate = busySlots[selectedDate] || [];
            
            Array.from(slotSelect.options).forEach(option => {
                if (busyForDate.includes(option.value)) {
                    option.disabled = true;
                    option.style.color = '#ccc';
                    if (option.selected) {
                        slotSelect.value = "";
                    }
                } else {
                    option.disabled = false;
                    option.style.color = '';
                }
            });
        }

        dateInput.addEventListener('change', updateSlots);
        window.addEventListener('load', updateSlots);
    </script>
    <div class="form-group" style="margin-bottom: 15px;">
        <label>Количество человек в группе</label>
        <input type="number" name="capacity" value="{{ old('capacity') }}" min="1" required>
    </div>
    <div class="form-group" style="margin-bottom: 15px;">
        <label>Стоимость (руб.)</label>
        <input type="number" name="cost" value="{{ old('cost') }}" step="0.01" min="0" required>
    </div>
    <div class="form-group">
        <button type="submit" class="btn">Добавить</button>
    </div>
</form>
@endsection