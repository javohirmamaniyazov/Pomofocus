<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\TimerSetting;

class TimerSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }
    
    public function index()
    {
        return TimerSetting::all();
    }
    
    public function store(Request $request)
    {
        $timerSetting = TimerSetting::create($request->validate([
            'user_id' => 'required|exists:users,id',
            'pomodoro_time' => 'integer',
            'short_break_time' => 'integer',
            'long_break_time' => 'integer',
        ]));

        return $timerSetting;
    }

    public function update(Request $request, TimerSetting $timerSetting)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'pomodoro_time' => 'integer',
            'short_break_time' => 'integer',
            'long_break_time' => 'integer',
        ]);

        $timerSetting->update($validated);

        return $timerSetting;
    }
}
