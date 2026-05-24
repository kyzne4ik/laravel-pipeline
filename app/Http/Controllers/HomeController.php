<?php

namespace App\Http\Controllers;

use App\Models\CreativeActivity;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $activities = CreativeActivity::all();
        $enrolledClasses = collect();

        if (Auth::check() && Auth::user()->role === 'visitor') {
            $enrolledClasses = Enrollment::where('user_id', Auth::id())
                ->with('masterClass.activity', 'masterClass.instructor')
                ->get()
                ->pluck('masterClass')
                ->sortBy(['date', 'time_slot']);
        }

        return view('home', compact('activities', 'enrolledClasses'));
    }
}
