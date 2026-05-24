<?php

namespace App\Http\Controllers;

use App\Models\MasterClass;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EnrollmentController extends Controller
{
    public function confirm(MasterClass $masterClass): View
    {
        if (Auth::user()->role !== 'visitor') {
            abort(403);
        }

        return view('classes.confirm', compact('masterClass'));
    }

    public function store(Request $request, MasterClass $masterClass): RedirectResponse
    {
        if (Auth::user()->role !== 'visitor') {
            abort(403);
        }

        $startTime = \Carbon\Carbon::parse($masterClass->date . ' ' . explode('-', $masterClass->time_slot)[0]);
        if ($startTime->isPast()) {
            return redirect()->route('activity.show', $masterClass->activity_id)
                ->withErrors(['error' => 'Запись на прошедший мастер-класс невозможна.']);
        }

        if ($masterClass->available_spots <= 0) {
            return redirect()->route('activity.show', $masterClass->activity_id)
                ->withErrors(['error' => 'К сожалению, свободных мест больше нет.']);
        }

        $userId = Auth::id();

        $alreadyEnrolled = Enrollment::where('user_id', $userId)
            ->where('master_class_id', $masterClass->id)
            ->exists();

        if ($alreadyEnrolled) {
            return redirect()->route('activity.show', $masterClass->activity_id)
                ->withErrors(['error' => 'Вы уже записаны на этот мастер-класс.']);
        }

        Enrollment::create([
            'user_id' => $userId,
            'master_class_id' => $masterClass->id,
        ]);

        return redirect()->route('activity.show', $masterClass->activity_id)
            ->with('success', 'Вы успешно записались на мастер-класс!');
    }
}
