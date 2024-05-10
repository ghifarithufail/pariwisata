<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function Payments()
    {
        return $this->belongsTo(Payment::class, 'id', 'booking_id');
    }

    public function details()
    {
        return $this->hasMany(Booking_detail::class, 'booking_id', 'id');
    }

}
