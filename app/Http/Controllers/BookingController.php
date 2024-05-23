<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use App\Models\Booking;
use App\Models\Booking_detail;
use App\Models\Bus;
use App\Models\Pengemudi;
use App\Models\Tujuan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $booking = Booking::with('details')->orderBy('created_at', 'desc')->get();

        return view('layouts.booking.index', [
            'booking' => $booking,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $start = $request->input('start', now()->format('Y-m-d'));
        $end = $request->input('end', now()->format('Y-m-d'));

        $tanggal_mulai = date('Y-m-d', strtotime($request->input('start')));
        $tanggal_akhir = date('Y-m-d', strtotime($request->input('end')));

        $bus = collect();

        $buses = Armada::whereDoesntHave('booking_details.bookings', function ($query) use ($tanggal_mulai, $tanggal_akhir) {
            $query->whereDate('date_start', '<=', $tanggal_akhir)
                ->whereDate('date_end', '>=', $tanggal_mulai)
                ->where('booking_status', 1);
        })
            ->orderBy('id', 'asc');

        if ($request['type']) {
            $buses = $buses->where('keterangan', $request['type']);
        }

        $bus = $buses->get();

        $allBusesFull = $bus->isEmpty();

        return view('layouts.booking.create', [
            'bus' => $bus,
            'allBusesFull' => $allBusesFull,
            'request' => [
                'start' => $start,
                'end' => $end,
            ],
        ]);
    }

    public function report()
    {
        $booking = Booking::with('details')->orderBy('created_at', 'DESC')->get();

        return view('layouts.booking.report', [
            'booking' => $booking,
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
                'customer' => 'nullable',
                'telephone' => 'nullable',
                'date_start' => 'nullable',
                'date_end' => 'nullable',
                'telephone' => 'nullable',
                'total_bus' => 'nullable',
                'harga_std' => 'required',
                'grand_total' => 'required',
                'keterangan' => 'nullable',
                'biaya_jemput' => 'nullable',
                'diskon' => 'nullable',
                'tujuan_id' => 'nullable',
            ]);

            $booking = new Booking($validatedData);

            $count = Booking::whereMonth("created_at", date("m"))
                ->whereYear("created_at", date("Y"))
                ->count();

            $next = $count + 1;
            $array_bln = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");

            $booking->no_booking = "BK/PP/" . date("Y") . "/" . $array_bln[date('n')] . "/" . $next;

            $booking->save();


            foreach ($request->input('bus_id') as $value) {
                $detail = new Booking_detail();
                $detail->booking_id = $booking->id;
                $detail->armada_id = $value;
                $detail->harga_std = $request->harga_std;
                $detail->diskon = $request->diskon;
                $detail->total_harga = $detail->harga_std - ($detail->harga_std * ($detail->diskon / 100));
                $detail->save();
            }

            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function pengemudi($id)
    {
        $booking = Booking::find($id);
        $pengemudi = Pengemudi::orderBy('created_at', 'desc')->get();

        return view('layouts.booking.edit', [
            'booking' => $booking,
            'pengemudi' => $pengemudi,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $bookingId = $request->input('booking_id'); // Retrieve bookingId from request data
            $detail = Booking_detail::where('id', $bookingId)->first(); // Find Booking_detail by bookingId

            if (!$detail) {
                return response()->json(['error' => 'Booking detail not found'], 404);
            }

            $detail->supir_id =  $request->input('supir_id');
            $detail->Kondektur_id = $request->input('kondektur_id');
            $detail->save();

            DB::commit();

            return response()->json(['success' => 'Data updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }


    public function jadwal()
    {

        $jadwal = Booking_detail::whereHas('bookings', function ($bookings) {
            $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
            $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
            
            $bookings->whereDate('date_start', '>=', $startOfMonth)
                ->whereDate('date_end', '<=', $endOfMonth);
        })
            ->whereNotNull('supir_id')->get();

        // $jadwal = Booking::with('details')->whereDate('date_start', '>=', Carbon::now())
        // ->whereDate('date_end', '<=', Carbon::now())->get();

        return view('layouts.jadwal.index', [
            'jadwal' => $jadwal
        ]);
    }

    public function getTujuan(Request $request)
    {
        $tujuan = [];
        $tujuan = Tujuan::where('nama_tujuan', 'LIKE', "%$request->name%")->get();

        return response()->json($tujuan);
    }

    public function getTotalHargaStd(Request $request)
    {
        $tujuanId = $request->tujuan_id;
        $totalHargaStd = 0;

        if ($tujuanId) {
            $tujuan = Tujuan::findOrFail($tujuanId);
            $totalHargaStd = $tujuan->harga_std;
        }

        return response()->json(['total_harga_std' => $totalHargaStd]);
    }

    public function edit(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $pengemudi = Pengemudi::orderBy('created_at', 'desc')->get();

        $start = $request->input('start', now()->format('Y-m-d'));
        $end = $request->input('end', now()->format('Y-m-d'));

        $tanggal_mulai = date('Y-m-d', strtotime($request->input('start')));
        $tanggal_akhir = date('Y-m-d', strtotime($request->input('end')));

        $bus = collect();

        $buses = Armada::whereDoesntHave('booking_details.bookings', function ($query) use ($tanggal_mulai, $tanggal_akhir) {
            $query->whereDate('date_start', '<=', $tanggal_akhir)
                ->whereDate('date_end', '>=', $tanggal_mulai)
                ->where('booking_status', 1);
        })
            ->orderBy('id', 'asc');

        if ($request['type']) {
            $buses = $buses->where('keterangan', $request['type']);
        }

        $bus = $buses->get();

        $allBusesFull = $bus->isEmpty();

        return view('layouts.booking.editReservation', [
            'booking' => $booking,
            'pengemudi' => $pengemudi,
            'bus' => $bus,
            'allBusesFull' => $allBusesFull,
            'request' => [
                'start' => $start,
                'end' => $end,
            ],
        ]);
    }

    public function updateBusReservation(Request $request)
    {
        try {
            DB::beginTransaction();

            $bookingId = $request->input('booking_id');
            $detail = Booking_detail::where('id', $bookingId)->first();


            if (!$detail) {
                return response()->json(['error' => 'Booking detail not found'], 404);
            }

            $detail->armada_id = $request->input('bus_id');
            $detail->save();

            DB::commit();

            return response()->json(['success' => 'Data updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error($e);
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function updateDateReservation(Request $request)
    {
        try {
            DB::beginTransaction();

            $bookingId = $request->input('booking_id');
            $booking = Booking::where('id', $bookingId)->first();

            if (!$booking) {
                return response()->json(['error' => 'Booking not found'], 404);
            }

            $booking->date_start = $request->input('start');
            $booking->date_end = $request->input('end');
            $booking->save();


            DB::commit();

            return response()->json(['success' => 'Data updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error($e);
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
