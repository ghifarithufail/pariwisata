<?php

namespace App\Http\Controllers;

use App\Exports\PaymentExport;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\TypePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Excel;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $customer = $request->input('customer');
        $no_booking = $request->input('no_booking');

        $bookings = Booking::with('payments')->where('payment_status', '2')->orderBy('created_at', 'desc');

        if ($request['customer']) {
            $bookings->where('customer', 'like', '%' . $request['customer'] . '%');
        };

        if ($request['no_booking']) {
            $bookings->where('no_booking', $request['no_booking']);
        };

        $booking = $bookings->get();

        return view('layouts.payment.index', [
            'booking' => $booking,
            'request' => [
                'customer' => $customer,
                'no_booking' => $no_booking,
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $booking = Booking::find($id);
        $type = TypePayment::orderby('name', 'asc')->get();


        return view('layouts.payment.create', [
            'booking' => $booking,
            'type' => $type,
            // 'request' => [
            //     'start' => $start,
            //     'end' => $end,
            // ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validasi data request
            $validatedData = $request->validate([
                'booking_id' => 'required',
                'type_payment_id' => 'required',
                'price' => 'required',
                'image' => 'nullable|image', // Menambahkan validasi bahwa image bisa nullable
            ]);

            // Buat instance Payment dengan data validasi
            $payment = new Payment($validatedData);

            // Hitung nomor payment selanjutnya
            $count = Payment::whereMonth("created_at", date("m"))
                ->whereYear("created_at", date("Y"))
                ->count();
            $next = $count + 1;
            $array_bln = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");

            // Set nomor payment
            $payment->no_payment = "BK/PP/INV/" . date("Y") . "/" . $array_bln[date('n')] . "/" . $next;

            // Cari booking terkait
            $booking = Booking::where('id', $payment->booking_id)->first();

            // Jika ada file image dalam request, simpan file tersebut
            if ($request->hasFile('image')) {
                $payment->image = $request->file('image')->store('payments');
            }

            // Simpan payment
            $payment->save();

            // Hitung total pembayaran untuk booking terkait
            $totalPayment = Payment::where('booking_id', $payment->booking_id)->sum('price');

            // Update total payment dalam booking
            $booking->total_payment = $totalPayment;
            $booking->save();

            // Jika total payment sama dengan grand total booking, update status payment
            if ($booking->grand_total == $booking->total_payment) {
                $booking->payment_status = 1;
                $booking->save();
            }

            DB::commit();
            return redirect()->route('payment')->with('success', 'Payment berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);
            return redirect()->route('payment')->with('error', 'Gagal menyimpan Pembayaran ' . $e->getMessage());
        }
    }

    public function report(Request $request)
    {

        $no_booking = $request->input('no_booking');
        $date_start = $request->input('date_start', now()->startOfMonth()->format('Y-m-d'));
        $date_end = $request->input('date_end', now()->endOfMonth()->format('Y-m-d'));

        $bookings = Booking::orderBy('created_at', 'desc');

        if ($request['date_start']) {
            $bookings->whereDate('created_at', '>=', $request['date_start']);
        }

        if ($request['date_end']) {
            $bookings->whereDate('created_at', '<=', $request['date_end']);
        }

        if ($request['no_booking']) {
            $bookings->where('no_booking', $request['no_booking']);
        };

        $booking = $bookings->get();
        return view('layouts.payment.report', [
            'booking' => $booking,
            'request' => [
                'no_booking' => $no_booking,
                'date_start' => $date_start,
                'date_end' => $date_end,
            ],
        ]);
    }
    public function excel(Request $request){
        return Excel::download(new PaymentExport($request),'payment.xlsx');
    }

    public function detail_report($id)
    {
        $booking = Booking::find($id);

        return view('layouts.payment.detail', [
            'booking' => $booking,
        ]);
    }
}
