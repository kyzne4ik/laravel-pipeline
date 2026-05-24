<?php

namespace App\Http\Controllers;

use App\Models\CreativeActivity;
use Illuminate\Http\Request;

use Illuminate\View\View;

class ActivityController extends Controller
{
    public function show(CreativeActivity $activity): View
    {
        $masterClasses = $activity->masterClasses()
            ->with(['instructor', 'enrollments'])
            ->orderBy('date')
            ->orderBy('time_slot')
            ->get();

        return view('classes.show', compact('activity', 'masterClasses'));
    }
}
