@extends('main')
@section('content')
    <div class="card text-center">
        <h5 class="card-header">Report SPJ</h5>
    </div>
    <div class="card mt-4">

        <div class="card-header" style="zoom: 0.8">
            <form>
                <div class="form-group row">
                    {{-- <div class="col-sm-3 mt-2">
                        <input type="date" class="form-control" placeholder="NIK" name="tanggal" id="tanggal">
                    </div> --}}
                    <div class="col-sm-3 mt-2">
                        {{-- <label for="date1">Kecamatan:</label> --}}
                        <input type="date" style="height: 40px" class="form-control" placeholder="kelurahan atau kecamatan"
                            value="{{ $request['date_start'] }}" name="date_start" id="date_start">
                    </div>
                    <div class="col-sm-3 mt-2">
                        {{-- <label for="date1">Kecamatan:</label> --}}
                        <input type="date" style="height: 40px" class="form-control"
                            placeholder="kelurahan atau kecamatan" value="{{ $request['date_end'] }}" name="date_end"
                            id="date_end">
                    </div>
                    <div class="col-sm-3 mt-2">
                        <input type="text" class="form-control" placeholder="No Booking" name="no_booking"
                            id="no_booking">
                    </div>
                    {{-- <div class="col-sm-3 mt-2">
                        <input type="text" class="form-control" placeholder="No Spj" name="no_spj"
                            id="no_booking">
                    </div> --}}
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary rounded text-white mt-2 mr-2" style="height: 40px"
                            id="search_btn">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card mt-4">
        <div class="d-flex justify-content-end mt-3" style="zoom: 0.75; margin-right: 60px">
            <div class="d-flex">
                <a href="{{ route('spj/excel', [
                    'date_start' => $request['date_start'],
                    'date_end' => $request['date_end'],
                    'no_spj' => $request['no_spj'],
                    'no_booking' => $request['no_booking'],
                ]) }}"
                    class="me-2">
                    <button type="button" class="btn btn-primary">excel</button>
                </a>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover" style="zoom: 0.75">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>No Booking</th>
                        <th>Tujuan</th>
                        <th>Harga Booking</th>
                        <th>Total Bus</th>
                        <th>Uang Jalan</th>
                        <th class="text-center">Detail</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($booking as $data)
                        <tr>
                            <td>{{ $data->customer }}</td>
                            <td>{{ $data->no_booking }}</td>
                            <td>{{ $data->tujuan->nama_tujuan }}</td>
                            <td>{{ number_format($data->grand_total) }}</td>
                            <td>{{ $data->total_bus }}</td>
                            <td>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($data->details as $item)
                                    @php
                                        $total += $item->total_sisa_uang_jalan + $item->total_pengeluaran;
                                    @endphp
                                @endforeach
                                {{ number_format($total) }}
                            </td>

                            <td class="text-center">
                                <a href="{{ route('report/spj/detail', $data->id) }}">
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
