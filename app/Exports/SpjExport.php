<?php

namespace App\Exports;

use App\Models\Anggota;
use App\Models\Booking;
use App\Models\Korcam;
use App\Models\Korhan;
use App\Models\KorTps;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Reservation;
use App\Models\Spj;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SpjExport implements FromView, ShouldAutoSize
{

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $request = $this->request;

        $no_spj = $request->input('no_spj');
        $no_booking = $request->input('no_booking');
        $tanggal = $request->input('tanggal');
        $date_start = $request->input('date_start', now()->startOfMonth()->format('Y-m-d'));
        $date_end = $request->input('date_end', now()->endOfMonth()->format('Y-m-d'));

        $bookings = Booking::orderBy('created_at', 'desc')
            ->whereHas('details.spjs', function ($spjs) {
                $spjs->where('type', 2);
            });

        // $spjs = Spj::with('booking_details')
        //     ->where('type', 2)
        //     ->orderBy('created_at', 'desc');

        if ($request['date_start']) {
            $bookings->whereDate('date_start', '>=', $request['date_start']);
        }

        if ($request['date_end']) {
            $bookings->whereDate('date_end', '<=', $request['date_end']);
        }

        if ($request['no_spj']) {
            $bookings->whereHas('details.spjs', function ($spjs) use ($request) {
                $spjs->where('no_spj', $request['no_spj']);
            });
        };

        if ($request['no_booking']) {
            $bookings->where('no_booking', $request['no_booking']);
        };

        $booking = $bookings->get();


        return view('layouts.spj.excel', [
            'request' => [
                'no_spj' => $no_spj,
                'tanggal' => $tanggal,
                'no_booking' => $no_booking,
                'date_start' => $date_start,
                'date_end' => $date_end,
            ],
            'booking' => $booking,


        ]);
    }
}
