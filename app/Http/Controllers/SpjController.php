<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Booking_detail;
use App\Models\Spj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpjController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $booking = Booking::whereHas('details', function($details){
            $details->where('is_in', null);
        })->orderBy('created_at', 'desc')->get();


        return view('layouts.spj.index',[
            'booking' => $booking
        ]);
    }

    public function detail($id){
        $detail = Booking_detail::where('booking_id', $id)->orderBy('created_at', 'desc')->get();

        return view('layouts.spj.detail',[
            'detail' => $detail
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function keluar(Request $request,$id)
    {
        try {
            $detail = Booking_detail::where('id',$id)->first();
            

            $count = Spj::whereMonth("created_at", date("m"))
                ->whereYear("created_at", date("Y"))
                ->where('type','1')
                ->count();

            $next = $count+1;
            $array_bln = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");

            $spj = new Spj();
            $spj->booking_detail_id = $detail->id;
            $spj->no_spj = "SPJ/BKO/" . date("Y") . "/" . $array_bln[date('n')] ."/" . $next;
            $spj->type = '1';
            $spj->save();

            $detail->is_out = 1;
            $detail->save();

            DB::commit();
            return redirect('spj/print/out/' . $spj->id);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::info($e);

            return redirect()->back()->with('error', 'Gagal Membuat SPJ Keluar ' . $e->getMessage());
        }
    }

    public function masuk(Request $request,$id)
    {
        try {
            $detail = Booking_detail::where('id',$id)->first();
            
            $count = Spj::whereMonth("created_at", date("m"))
                ->whereYear("created_at", date("Y"))
                ->where('type','2')
                ->count();

            $next = $count+1;
            $array_bln = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");

            $spj = new Spj();
            $spj->booking_detail_id = $detail->id;
            $spj->no_spj = "SPJ/BKI/PP/" . date("Y") . "/" . $array_bln[date('n')] ."/" . $next;
            $spj->type = '2';
            $spj->save();

            $detail->is_in = 1;
            $detail->save();

            DB::commit();
            return redirect()->back()->with('success', 'SPJ Masuk Berhasil Dibuat');
        } catch (\Exception $e) {

            DB::rollBack();
            \Log::info($e);

            return redirect()->back()->with('error', 'Gagal Membuat SPJ Masuk ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function print_out($id)
    {
        $spj = Spj::find($id);
        return view('layouts.spj.out',[
            'spj' => $spj
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Spj $spj)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Spj $spj)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Spj $spj)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Spj $spj)
    {
        //
    }
}
