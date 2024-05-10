<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking_detail extends Model
{
    use HasFactory;

    public function bookings()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class, 'bus_id', 'id');
    }
}
