<?php

namespace App\Http\Controllers\Hrd;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin\Pool;
use App\Models\Admin\Rute;
use Illuminate\Http\Request;
use App\Models\Hrd\Kondektur;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class KondekturController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('perpage', 10);

        $query = Kondektur::with('users.biodata','biodatas', 'pools', 'rutes');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nokondektur', 'LIKE', '%' . $search . '%')
                    ->orWhere('biodatas.nik', 'LIKE', '%' . $search . '%')
                    ->orWhere('rutes.kode_rute', 'LIKE', '%' . $search . '%');
            });
        }

        $kondekturs = $query->paginate($perPage);

        return view('layouts.hrd.kondektur.index', [
            'kondekturs' => $kondekturs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $rutes = Rute::all();
        $pools = Pool::all();

        return view('layouts.hrd.kondektur.create', [
            'users'=> $users,
            'rutes'=> $rutes,
            'pools'=> $pools,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'rute_id' => 'required|exists:rutes,id',
            'pool_id' => 'required|exists:pools,id',
            'tgl_masuk' => 'required|date',
            'tanggal_kp' => 'required|date',
            'nojamsostek' => 'nullable|string',
            'ket_kondektur' => 'nullable|string',
        ]);

        // Tentukan apakah nomor induk harus dihasilkan otomatis atau diatur manual
        if ($request->has('nokondektur')) {
            // Nomor induk diatur manual
            $nokondekturBaru = $request->nokondektur;
        } else {
            // Dapatkan tahun dan bulan saat ini
            $tahunBulan = Carbon::now()->format('ym');

            // Dapatkan nomor urut terakhir
            $nomorUrutTerakhir = Kondektur::where('nokondektur', 'like', $tahunBulan . '%')->max('nokondektur');

            // Jika tidak ada nomor urut sebelumnya, beri nomor urut awal
            if (!$nomorUrutTerakhir) {
                $nomorUrutTerakhir = 0;
            } else {
                $nomorUrutTerakhir = intval(substr($nomorUrutTerakhir, -5));
            }

            // Tambahkan 1 ke nomor urut terakhir
            $nomorUrutBaru = $nomorUrutTerakhir + 1;

            // Buat nokondektur baru dengan format yang diinginkan
            $nokondekturBaru = "K2" . $tahunBulan . str_pad($nomorUrutBaru, 5, '0', STR_PAD_LEFT);
        }

        try {
            // Mulai transaksi database
            DB::beginTransaction();

            // Periksa apakah nojamsostek sudah ada jika diisi
            if (!empty($request->nojamsostek)) {
                $existingKondektur = Kondektur::where('nojamsostek', $request->nojamsostek)->first();
                if ($existingKondektur) {
                    return redirect()->back()->withErrors(['nojamsostek' => 'No Jamsostek sudah ada'])->withInput();
                }
            }

            // Simpan biodata dengan mengaitkannya dengan user yang baru dibuat
            $kondektur = Kondektur::create([
                'user_id' => $request->user_id,
                'nokondektur' => $nokondekturBaru,
                'rute_id' => $request->rute_id,
                'pool_id' => $request->pool_id,
                'tgl_masuk' => $request->tgl_masuk,
                'tanggal_kp' => $request->tanggal_kp,
                'nojamsostek' => $request->nojamsostek,
                'ket_kondektur' => $request->ket_kondektur,
            ]);

            // Commit transaksi
            DB::commit();

            return redirect()->route('kondektur')->with('success', 'Kondektur have been created successfully!');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();

            Log::error('Error creating kondektur: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan kondektur.'])->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kondektur = Kondektur::findOrFail($id);
        $users = User::all();
        $rutes = Rute::all();
        $pools = Pool::all();

        return view('layouts.hrd.kondektur.edit', compact('kondektur', 'users', 'rutes', 'pools'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
        'user_id' => 'required|exists:users,id',
        'nokondektur' => 'nullable|string',
        'rute_id' => 'required|exists:rutes,id',
        'pool_id' => 'required|exists:pools,id',
        'tgl_masuk' => 'required|date',
        'tanggal_kp' => 'required|date',
        'nojamsostek' => 'nullable|string',
        'ket_kondektur' => 'nullable|string',
    ]);

        try {
            // Mulai transaksi database
            DB::beginTransaction();

            // Perbarui data kondektur yang sesuai
            $kondektur = Kondektur::findOrFail($id);
            $kondektur->update($validatedData);
            // $kondektur->update([
            //     'user_id' => $request->user_id,
            //     'nokondektur' => $request->nokondektur,
            //     'rute_id' => $request->rute_id,
            //     'tanggal_kp' => $request->tanggal_kp,
            //     'tgl_masuk' => $request->tgl_masuk,
            //     'nojamsostek' => $request->nojamsostek,
            //     'ket_kondektur' => $request->ket_kondektur,
            // ]);

            // Commit transaksi
            DB::commit();

            return redirect()->route('kondektur')->with('success', 'Kondektur have been updated successfully!');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();

            Log::error('Error updating kondektur: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui kondektur.'])->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}