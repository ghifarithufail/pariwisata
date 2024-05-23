@extends('main')
@section('content')
    <div class="card text-center">
        <h5 class="card-header">Bookings Report</h5>
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
                        <th>Bus</th>
                        <th>Tujuan</th>
                        <th>Biaya Jemput</th>
                        <th>Harga Standar</th>
                        <th>Diskon</th>
                        <th>Total Harga</th>
                        {{-- <th class="text-center">Actions</th> --}}
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @php
                        $previousBookingId = null;
                    @endphp
                    @foreach ($booking as $data)
                        @foreach ($data->details as $item)
                            <tr>
                                <td>{{ $data->no_booking }}</td>
                                <td>{{ $data->customer }}</td>
                                <td>{{ $data->telephone }}</td>
                                <td>{{ $data->date_start }}</td>
                                <td>{{ $data->date_end }}</td>
                                <td>{{ $item->armadas->nobody }}</td>
                                <td>{{ $data->tujuan->nama_tujuan }}</td>
                                <td>
                                    @if ($previousBookingId !== $data->id)
                                        {{ number_format($data->biaya_jemput) }}
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>{{ number_format($item->harga_std) }}</td>
                                <td>{{ number_format($item->diskon) }}%</td>
                                <td>{{ number_format($item->total_harga) }}</td>
                            </tr>
                            @php
                                $previousBookingId = $data->id;
                            @endphp
                        @endforeach
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
