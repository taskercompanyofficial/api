<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersOffers extends Model
{
    protected $fillable = ['user_id', 'offer_ids'];

    public function user()
    {
        return $this->belongsTo(Staff::class, 'user_id');
    }
}
