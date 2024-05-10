<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spj extends Model
{
    use HasFactory;

    public function booking_details()
    {
        return $this->belongsTo(Booking_detail::class, 'booking_detail_id', 'id');
    }
}
