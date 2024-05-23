<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\TypePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $booking = Booking::with('payments')->orderBy('created_at', 'desc')->get();

        return view('layouts.payment.index', [
            'booking' => $booking,
            // 'request' => [
            //     'start' => $start,
            //     'end' => $end,
            // ],
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
            $validatedData = $request->validate([
                'booking_id' => 'required',
                'type_payment_id' => 'required',
                'price' => 'required',
                'image' => 'required',

            ]);

            $payment = new Payment($validatedData);
            $payment->image = $request->file('image')->store('payments');
            $payment->save();

            $totalPayment = $payment->where('booking_id', $payment->booking_id)->sum('price');

            $booking = Booking::where('id', $payment->booking_id)->first();
            $booking->total_payment = $totalPayment;
            $booking->save();

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

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
