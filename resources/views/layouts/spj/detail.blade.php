@extends('main')
@section('content')

    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    </head>
    <div class="card text-center">
        <h5 class="card-header">SPJ</h5>
    </div>
    <div class="card mt-4">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover" style="zoom: 0.75">
                <thead>
                    <tr>
                        <th>Nama Bus</th>
                        <th>Kondektur</th>
                        <th>Supir</th>
                        <th class="text-center">SPJ</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($detail as $data)
                        <tr>
                            <td>{{ $data->bus->nama }}</td>
                            <td>{{ $data->supir_id }}</td>
                            <td>{{ $data->Kondektur_id }}</td>
                            <td class="text-center">
                                {{-- <div class="dropdown text-center">
                                    <a href="{{ route('spj/keluar', $data->details->id) }}">
                                        <button type="button" class="btn rounded-pill btn-warning"
                                            fdprocessedid="c80zr4">SPJ KELUAR</button>
                                    </a>
                                </div> --}}
                                @if ($data->is_out == null)
                                    <form method="POST" action="{{ route('spj/keluar', $data->id) }}"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn rounded-pill btn-danger"
                                            fdprocessedid="c80zr4">SPJ KELUAR</button>
                                    </form>
                                @elseif($data->is_in == null)
                                    <form method="POST" action="{{ route('spj/masuk', $data->id) }}"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn rounded-pill btn-success"
                                            fdprocessedid="c80zr4">SPJ Masuk</button>
                                    </form>
                                @else
                                    done
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Jika terdapat pesan sukses dari server, tampilkan pesan toastr
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        // Jika terdapat pesan error dari server, tampilkan pesan toastr
        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>
@endsection
