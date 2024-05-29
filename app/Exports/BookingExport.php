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
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BookingExport implements FromView, ShouldAutoSize
{

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $request = $this->request;

        $customer = $request->input('customer');
        $no_booking = $request->input('no_booking');
        $tanggal = $request->input('tanggal');
        $date_start = $request->input('date_start', now()->startOfMonth()->format('Y-m-d'));
        $date_end = $request->input('date_end', now()->endOfMonth()->format('Y-m-d'));

        $bookings = Booking::with('details')->whereHas('details', function ($details) {
            $details->whereNotNull('is_in');
        })
            ->orderBy('created_at', 'DESC');

        if ($request['date_start']) {
            $bookings->whereDate('date_start', '>=', $request['date_start']);
        }

        if ($request['date_end']) {
            $bookings->whereDate('date_end', '<=', $request['date_end']);
        }

        if ($request['customer']) {
            $bookings->where('customer', 'like', '%' . $request['customer'] . '%');
        };

        if ($request['no_booking']) {
            $bookings->where('no_booking', $request['no_booking']);
        };

        if ($request['tanggal']) {
            $bookings->where('date_start', $request['tanggal']);
        };

        $booking = $bookings->get();


        return view('layouts.booking.excel', [
            'request' => [
                'customer' => $customer,
                'tanggal' => $tanggal,
                'no_booking' => $no_booking,
                'date_start' => $date_start,
                'date_end' => $date_end,
            ],
            'booking' => $booking,


        ]);
    }
}
