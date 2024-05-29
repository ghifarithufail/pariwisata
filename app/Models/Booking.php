<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // public function Payments()
    // {
    //     return $this->belongsTo(Payment::class, 'id', 'booking_id');
    // }

    public function details()
    {
        return $this->hasMany(Booking_detail::class, 'booking_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'booking_id', 'id');
    }

    public function tujuan()
    {
        return $this->belongsTo(Tujuan::class, 'tujuan_id', 'id');
    }

    public function tujuans()
    {
        // Explode the comma-separated IDs
        $tujuanIds = explode(',', $this->tujuan_id);

        // Query the Tujuan model with the exploded IDs
        return Tujuan::whereIn('id', $tujuanIds)->get();
    }
}
