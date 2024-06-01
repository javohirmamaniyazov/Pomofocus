<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimerSetting extends Model
{
    use HasFactory;
    
    protected $table = 'timer_settings';
    
    protected $fillable = [
        'user_id',
        'pomodoro_time',
        'short_break_time',
        'long_break_time',
    ];
}
