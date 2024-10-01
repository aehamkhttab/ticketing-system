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
        'assigned_user_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function assigned_user()
    {
        //Edit to belongstomany after adding pivot table
        return $this-> belongsTo(User::class, 'assigned_user_id');
    }
}
