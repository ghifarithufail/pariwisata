<?php

namespace App\Models;

use App\Models\Admin\Pool;
use App\Models\Admin\Rute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Armada extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function pools()
    {
        return $this->hasOne(Pool::class, 'id', 'pool_id');
    }

    public function rutes()
    {
        return $this->hasOne(Rute::class, 'id', 'rute_id');
    }

    public function booking_details()
    {
        return $this->belongsTo(Booking_detail::class, 'id', 'armada_id');
    }
}
