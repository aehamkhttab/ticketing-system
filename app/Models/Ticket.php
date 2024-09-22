<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'status',
        'deadline',
        'assigned_user',
    ];

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
