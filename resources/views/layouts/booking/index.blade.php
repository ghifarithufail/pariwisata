@extends('main')
@section('content')
    <div class="card text-center">
        <h5 class="card-header">Bookings</h5>
    </div>
    <div class="card mt-4">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover" style="zoom: 0.75">
                <thead>
                    <tr>
                        <th>No Booking</th>
                        <th>Nama</th>
                        <th>Telephone</th>
                        <th>Tanggal Awal</th>
                        <th>Tanggal Akhir</th>
                        {{-- <th>Penjemputan</th> --}}
                        <th>Tujuan</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($booking as $data)
                        <tr>
                            <td>{{ $data->no_booking }}</td>
                            <td>{{ $data->customer }}</td>
                            <td>{{ $data->telephone }}</td>
                            <td>{{ $data->date_start }}</td>
                            <td>{{ $data->date_end }}</td>
                            {{-- <td>{{ $data->lokasi_jemput }}</td> --}}
                            <td>
                                @foreach ($data->tujuans() as $item)
                                    {{ $item->nama_tujuan }}
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </td>

                            <td>
                                <a href="{{ route('booking/pengemudi', $data->id) }}">
                                    <button type="button" class="btn rounded-pill btn-primary" fdprocessedid="c80zr4">Input
                                        Supir</button>
                                </a>
                                <a href="{{ route('booking/edit', $data->id) }}">
                                    <button type="button" class="btn rounded-pill btn-warning"
                                        fdprocessedid="c80zr4">detail</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
