<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, softDeletes;
    //use HasUuids;


    /**
     * In guarded put the field that user can not edit on it.
     */
    /**
     * protected $guarded = [ 'user_id' ];
     * */


     protected $fillable = ['title','description','status','deadline','assigned_user_id'];


    /**
     * For change response datatype (just response) in all system.
     */
    /**
     * protected $casts = ['deadline' => 'datetime',];
     * */

    /**
     * Attribute will be active when user don't pass the field e.g. "title".
     */
    /**
     * protected $attributes = ['title' => 'default title',];
     * */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function assigned_user()
    {
        //TODO: Make Relation is  belongs to many after adding pivot table
        return $this-> belongsTo(User::class, 'assigned_user_id');
    }
}
