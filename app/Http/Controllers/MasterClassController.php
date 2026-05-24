<?php

namespace App\Http\Controllers;

use App\Models\CreativeActivity;
use App\Models\MasterClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MasterClassController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        if ($user->role !== 'instructor') {
            abort(403, 'Unauthorized action.');
        }

        $masterClasses = MasterClass::where('instructor_id', $user->id)
            ->with(['activity', 'enrollments.user'])
            ->orderBy('date')
            ->orderBy('time_slot')
            ->get();

        return view('cabinet.index', compact('masterClasses', 'user'));
    }

    public function create(): View
    {
        if (Auth::user()->role !== 'instructor') {
            abort(403);
        }

        $activities = CreativeActivity::all();

        $busySlots = MasterClass::select('date', 'time_slot')
            ->get()
            ->groupBy('date')
            ->map(function ($items) {
                return $items->pluck('time_slot')->toArray();
            });

        return view('classes.create', compact('activities', 'busySlots'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (Auth::user()->role !== 'instructor') {
            abort(403);
        }

        $validated = $request->validate([
            'activity_id' => 'required|exists:creative_activities,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time_slot' => 'required|in:09:00-11:00,11:00-13:00,13:00-15:00,15:00-17:00',
            'capacity' => 'required|integer|min:1',
            'cost' => 'required|numeric|min:0',
        ]);

        $collision = MasterClass::where('date', $validated['date'])
            ->where('time_slot', $validated['time_slot'])
            ->exists();

        if ($collision) {
            return back()->withErrors(['time_slot' => 'Выбранные дата и время уже заняты.'])->withInput();
        }

        $validated['instructor_id'] = Auth::id();
        MasterClass::create($validated);

        return redirect()->route('cabinet')->with('success', 'Мастер-класс успешно добавлен.');
    }

    public function edit(MasterClass $masterClass): View
    {
        if (Auth::id() !== $masterClass->instructor_id) {
            abort(403);
        }

        return view('classes.edit', compact('masterClass'));
    }

    public function update(Request $request, MasterClass $masterClass): RedirectResponse
    {
        if (Auth::id() !== $masterClass->instructor_id) {
            abort(403);
        }

        $validated = $request->validate([
            'description' => 'required|string',
            'cost' => 'required|numeric|min:0',
        ]);

        $masterClass->update($validated);

        return redirect()->route('cabinet')->with('success', 'Мастер-класс успешно обновлен.');
    }
}
