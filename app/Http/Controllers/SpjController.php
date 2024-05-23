<?php

namespace App\Http\Controllers;

use App\Models\Spj;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Booking_detail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SpjController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $booking = Booking::whereHas('details', function ($details) {
            // $details->where('is_in', null);
        })->orderBy('created_at', 'desc')->get();


        return view('layouts.spj.index', [
            'booking' => $booking
        ]);
    }

    public function detail($id)
    {
        $detail = Booking_detail::with('armadas')->where('booking_id', $id)->orderBy('created_at', 'desc')->get();

        return view('layouts.spj.detail', [
            'detail' => $detail
        ]);
    }

    public function data($id)
    {
        $spj = Spj::where('id', $id)->first();

        return view('layouts.spj.data', [
            'spj' => $spj
        ]);
    }

    public function biaya_lain(Request $request)
    {
        $spj = Spj::where('id', $request->spj_id)->first();
        $spj->biaya_lain = $request->biaya_lain;
        $spj->keterangan_spj = $request->keterangan_spj;
        $spj->save();

        return redirect('/spj/detail/' . $spj->booking_details->bookings->id);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function keluar(Request $request, $id)
    {
        try {
            $detail = Booking_detail::where('id', $id)->first();


            $count = Spj::whereMonth("created_at", date("m"))
                ->whereYear("created_at", date("Y"))
                ->where('type', '1')
                ->count();

            $next = $count + 1;
            $array_bln = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");

            $spj = new Spj();
            $spj->booking_detail_id = $detail->id;
            $spj->no_spj = "SPJ/BKO/" . date("Y") . "/" . $array_bln[date('n')] . "/" . $next;
            $spj->type = '1';
            $spj->save();

            $detail->is_out = 1;
            $detail->save();

            DB::commit();
            return redirect('spj/print/out/' . $spj->id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return redirect()->back()->with('error', 'Gagal Membuat SPJ Keluar ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function detail_out($id)
    {
        $spj = Spj::find($id);

        return view('layouts.spj.create_out', [
            'spj' => $spj
        ]);
    }

    public function print($id){
        $spj = Spj::find($id);

        return view('layouts.spj.out', [
            'spj' => $spj
        ]);
    }

    public function detail_in($id)
    {
        $spj = Spj::find($id);


        return view('layouts.spj.create_in', [
            'spj' => $spj
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function store_print_out(Request $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validate([
                'lokasi_jemput' => 'required',
                'jam_jemput' => 'required',
                'km_keluar' => 'required',
                'uang_jalan' => 'required',
                'tujuan' => 'required',

            ]);

            $spj = Spj::where('id', $request->spj_id)->first();
            $spj->update($validatedData);

            DB::commit();
            // return redirect()->route('payment')->with('success', 'Payment berhasil disimpan');
            return redirect('spj/print/out/' . $spj->id)->with('success', 'SPJ berhasil Dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            // return redirect()->route('payment')->with('error', 'Gagal menyimpan Pembayaran ' . $e->getMessage());
            return redirect('spj/print/out/' . $spj->id)->with('error', 'Gagal membuat SPJ ' . $e->getMessage());
        }
    }

    public function store_print_in(Request $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validate([
                'bbm' => 'required',
                'uang_makan' => 'required',
                'parkir' => 'required',
                'tol' => 'required',
                'km_masuk' => 'required',

            ]);
            $pengeluaran = $request->bbm + $request->uang_makan + $request->parkir + $request->tol;

            $spj = Spj::where('id', $request->spj_id)->first();
            $spj->sisa_uang_jalan = $spj->uang_jalan - $pengeluaran - $spj->biaya_lain;
            $spj->pengeluaran = $pengeluaran + $spj->biaya_lain;
            $spj->type = 2;
            $spj->update($validatedData);

            $sisa_uang_jalan = $spj->where('booking_detail_id' , $spj->booking_detail_id)->sum('sisa_uang_jalan');
            $detail = Booking_detail::where('id', $spj->booking_detail_id)->first();

            $detail->is_in = 1;
            $detail->total_sisa_uang_jalan = $sisa_uang_jalan;
            $detail->total_pengeluaran = $pengeluaran + $spj->biaya_lain;;
            $detail->save();


            $booking = Booking::where('id', $detail->booking_id)->first();
            $pendapatan = Booking_detail::where('booking_id', $detail->booking_id)->sum('total_pengeluaran');

            $booking->total_pendapatan = $booking->grand_total - $pendapatan;
            $booking->save();


            DB::commit();
            return redirect('spj/print/in/' . $spj->id)->with('success', 'SPJ berhasil Dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);
            return redirect('spj/print/in/' . $spj->id)->with('error', 'Gagal menyimpan Pembayaran ' . $e->getMessage());
        }
    }

    public function masuk(Request $request, $id)
    {
        try {
            $detail = Booking_detail::where('id', $id)->first();

            $count = Spj::whereMonth("created_at", date("m"))
                ->whereYear("created_at", date("Y"))
                ->where('type', '2')
                ->count();

            $next = $count + 1;
            $array_bln = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");

            $spj = new Spj();
            $spj->booking_detail_id = $detail->id;
            $spj->no_spj = "SPJ/BKI/PP/" . date("Y") . "/" . $array_bln[date('n')] . "/" . $next;
            $spj->type = '2';
            $spj->save();

            $detail->is_in = 1;
            $detail->save();

            DB::commit();
            return redirect('spj/print/in/' . $spj->id);
        } catch (\Exception $e) {

            DB::rollBack();
            Log::info($e);

            return redirect()->back()->with('error', 'Gagal Membuat SPJ Masuk ' . $e->getMessage());
        }
    }
}
