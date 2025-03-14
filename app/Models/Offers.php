<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offers extends Model
{
    protected $fillable = ['user_id', 'name', 'network_id', 'domain_id', 'device_urls', 'age', 'click_rate', 'details', 'countries', 'status', 'port', 'allow_multiple_clicks', 'proxy_check'];
    protected $casts = [
        'device_urls' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(Staff::class, 'user_id');
    }

    public function network()
    {
        return $this->belongsTo(Network::class, 'network_id');
    }

    public function domain()
    {
        return $this->belongsTo(Domain::class, 'domain_id');
    }
}
