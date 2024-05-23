<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Pool;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $page = $request->input('page', 1);

        $pool = Pool::where('nama_pool', 'LIKE', "%$search%")
        ->paginate(10, ['*'], 'page', $page); // Mengatur jumlah item per halaman menjadi 10

        return view('layouts.admin.pool.index', [
            'pools' => $pool,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pool $pool)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pool $pool)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pool $pool)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pool $pool)
    {
        //
    }
}
