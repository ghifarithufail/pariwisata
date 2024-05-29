
@extends('main')
@section('content')
    <div class="card text-center">
        <h5 class="card-header">Report Payment</h5>
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
                        <input type="date" style="height: 40px" class="form-control"
                            placeholder="kelurahan atau kecamatan" value="{{ $request['date_start'] }}" name="date_start" id="date_start">
                    </div>
                    <div class="col-sm-3 mt-2">
                        {{-- <label for="date1">Kecamatan:</label> --}}
                        <input type="date" style="height: 40px" class="form-control"
                            placeholder="kelurahan atau kecamatan" value="{{ $request['date_end'] }}" name="date_end" id="date_end">
                    </div>
                    <div class="col-sm-3 mt-2">
                        <input type="text" class="form-control" placeholder="No Booking" name="no_booking" id="no_booking">
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary rounded text-white mt-2 mr-2" style="height: 40px"
                            id="search_btn">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card mt-4">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover" style="zoom: 0.75">
                <thead>
                    <tr>
                        <th>No Booking</th>
                        <th>Bus</th>
                        <th>Tujuan</th>
                        <th>Harga Booking</th>
                        <th>Status Pemabyaran</th>
                        <th class="text-center">Detail</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($booking as $data)
                        <tr>
                            <td>{{ $data->no_booking }}</td>
                            <td>{{ $data->customer }}</td>
                            <td>{{ $data->tujuan->nama_tujuan }}</td>
                            <td>{{ number_format($data->grand_total) }}</td>
                            <td>
                                @if ($data->payment_status == 1)
                                    Lunas
                                @else
                                    Belum Lunas
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('report/payment/detail', $data->id) }}">
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
