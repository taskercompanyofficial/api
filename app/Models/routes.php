<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class routes extends Model
{
    protected $fillable = ['sort_order', 'parent_route_id', 'key', 'name', 'icon', 'path', 'meta', 'status'];

    public function parentroute()
    {
        return $this->belongsTo('parent_route_id');
    }

    public function sub_routes()
    {
        return $this->hasMany(routes::class, 'parent_route_id');
    }

    protected $casts = [
        'meta' => 'array',
    ];
}
