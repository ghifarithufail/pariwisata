<?php

namespace App\Models;

use App\Models\Hrd\Kondektur;
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

    public function armadas()
    {
        return $this->belongsTo(Armada::class, 'armada_id', 'id');
    }

    public function spjs()
    {
        return $this->belongsTo(Spj::class, 'id', 'booking_detail_id');
    }

    public function pengemudis(){
        return $this->belongsTo(Pengemudi::class, 'supir_id', 'id');
    }

    public function kondekturs(){
        return $this->belongsTo(Kondektur::class, 'Kondektur_id', 'id');
    }
}
