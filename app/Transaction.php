<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'user_id'
    ];

    public function saveTransaction($description) 
    {
        $this->description = $description;
        $this->user_id = Auth::user()->id;
        $this->save();
    }
}

