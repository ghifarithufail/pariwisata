@extends('main')
@section('content')
    <div class="card text-center">
        <h5 class="card-header">Jadwal Supir</h5>
    </div>
    <div class="card mt-4">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover" style="zoom: 0.75">
                <thead>
                    <tr>
                        <th>Supir</th>
                        <th>Kondektur</th>
                        <th>Nama Customer</th>
                        <th>No Booking</th>
                        <th>Bus</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($jadwal as $data)
                        <tr>
                            <td>{{ $data->supir_id }}</td>
                            <td>{{ $data->Kondektur_id }}</td>
                            <td>{{ $data->bookings->customer }}</td>
                            <td>{{ $data->bookings->no_booking }}</td>
                            <td>{{ $data->bus_id }}</td>
                            <td>{{ $data->bookings->tujuan_id }}</td>
                            <td>{{ $data->bookings->lokasi_jemput }}</td>
                            <td>
                                <div class="dropdown text-center">
                                    <a href="{{ route('booking/edit', $data->id) }}">
                                        <button type="button" class="btn rounded-pill btn-warning"
                                            fdprocessedid="c80zr4">detail</button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
