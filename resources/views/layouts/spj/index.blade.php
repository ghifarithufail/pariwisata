@extends('main')
@section('content')

    <div class="card text-center">
        <h5 class="card-header">SPJ</h5>
    </div>
    <div class="card mt-4">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover" style="zoom: 0.75">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Tanggal Awal</th>
                        <th>Tanggal Akhir</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($booking as $data)
                        <tr>
                            <td>{{ $data->customer }}</td>
                            <td>{{ $data->date_start }}</td>
                            <td>{{ $data->date_end }}</td>
                            <td>
                                <div class="dropdown text-center">
                                    <a href="{{ route('spj/detail', $data->id) }}">
                                        <button type="button" class="btn rounded-pill btn-warning"
                                            fdprocessedid="c80zr4">SPJ</button>
                                    </a>
                                </div>
                                {{-- <form  method="POST" action="{{ route('spj/keluar', $data->details->id) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn rounded-pill btn-warning"
                                            fdprocessedid="c80zr4">SPJ KELUAR</button>
                                </form> --}}
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
