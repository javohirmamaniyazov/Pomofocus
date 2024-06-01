<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'orderNumber', 'content', 'note', 'isActive', 'isFinished', 'isDeleted', 'user_id'
    ];
}

