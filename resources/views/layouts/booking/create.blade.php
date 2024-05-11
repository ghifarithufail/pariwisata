@extends('main')
@section('content')

    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    </head>
    <style>
        .bus-items {
            height: 250px;
            overflow-y: auto;
            /* Menambahkan scrollbar jika konten melebihi ketinggian */
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Wizard examples /</span> Property Listing
        </h4> --}}

        <!-- Property Listing Wizard -->
        <div class="card text-center">
            <h5 class="card-header">Bookings</h5>
        </div>
        <div class="card mt-4">
            <div class="card-body">
                <div class="card-header" style="zoom: 0.8">
                    <form>
                        <div class="form-group row">
                            <div class="col-sm-4 mt-2">
                                <input type="date" class="form-control" placeholder="NIK" name="start"
                                    value="{{ $request['start'] }}" id="start">
                            </div>
                            <div class="col-sm-4 mt-2">
                                <input type="date" class="form-control" placeholder="NIK" name="end"
                                    value="{{ $request['end'] }}" id="end">
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-primary rounded text-white mt-2 mr-2"
                                    style="height: 40px" id="search_btn">Search</button>
                            </div>
                        </div>
                    </form>
                </div>

                @if (!request()->filled('start') && !request()->filled('end'))
                    <div class="text-center">
                        <p>Silahkan Pilih Tanggal Terlebih Dahulu</p>
                    </div>
                @elseif ($bus->isNotEmpty())
                    <div id="wizard-property-listing" class="bs-stepper vertical mt-2 linear">
                        <div class="bs-stepper-content">
                            <form action="{{ route('booking/store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div id="personal-details"
                                    class="content active dstepper-block fv-plugins-bootstrap5 fv-plugins-framework">
                                    <div class="row g-3 bus-items" style="zoom: 0.8">
                                        <div class="col-12">
                                            <div class="row g-3">
                                                @foreach ($bus as $data)
                                                    <div class="col-sm-2 mb-md-0 mb-2">
                                                        <div class="form-check custom-option custom-option-icon">
                                                            <label class="form-check-label custom-option-content"
                                                                for="{{ $data->id }}">
                                                                <span class="custom-option-body">
                                                                    <i class="bx bx-bus"></i>
                                                                    <span
                                                                        class="custom-option-title">{{ $data->nobody }}</span>
                                                                    <small>{{ $data->nopolisi }}</small>
                                                                </span>
                                                                <input name="bus_id[]" class="form-check-input"
                                                                    type="checkbox" value="{{ $data->id }}"
                                                                    id="{{ $data->id }}">
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3" style="zoom: 0.8">

                                        <div class="col-sm-6 fv-plugins-icon-container">
                                            <label class="form-label" for="customer">Customer</label>
                                            <input type="text" id="customer" name="customer" class="form-control"
                                                value="{{ old('customer') }}">
                                        </div>
                                        <div class="col-sm-6 fv-plugins-icon-container">
                                            <label class="form-label" for="telephone">Telephone</label>
                                            <input type="text" id="telephone" name="telephone" class="form-control">
                                        </div>
                                        <div class="col-sm-6 fv-plugins-icon-container">
                                            <label class="form-label" for="lokasi_jemput">lokasi jemput</label>
                                            <input type="number" id="lokasi_jemput" name="lokasi_jemput"
                                                class="form-control">
                                        </div>
                                        <div class="col-sm-6 fv-plugins-icon-container">
                                            <label class="form-label" for="total_passanger">total passanger</label>
                                            <input type="number" id="total_passanger" name="total_passanger"
                                                class="form-control">
                                        </div>
                                        <div class="col-sm-6 fv-plugins-icon-container">
                                            <label class="form-label" for="tujuan_id">tujuan id</label>
                                            <input type="number" id="tujuan_id" name="tujuan_id" class="form-control">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="total_bus">Total Bus</label>
                                            <input type="number" id="total_bus" name="total_bus" class="form-control"
                                                readonly>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="date_start">Tanggal Awal</label>
                                            <input type="text" id="date_start"
                                                value="{{ \Carbon\Carbon::parse($request['start'])->format('j F Y') }}"
                                                name="date_start" class="form-control" placeholder="Month Day Year"
                                                disabled>

                                            <input type="date" id="date_start" value="{{ $request['start'] }}"
                                                name="date_start" class="form-control" placeholder="john.doe" hidden>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="date_end">Tanggal Akhir</label>
                                            <input type="text" id="date_end"
                                                value="{{ \Carbon\Carbon::parse($request['end'])->format('j F Y') }}"
                                                name="date_end" class="form-control" placeholder="john.doe" disabled>

                                            <input type="date" id="date_end" value="{{ $request['end'] }}"
                                                name="date_end" class="form-control" placeholder="john.doe" hidden>
                                        </div>
                                        <div class="pt-5 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @elseif($allBusesFull)
                    <div class="text-center">
                        <p>Semua bus telah terisi penuh untuk tanggal yang dipilih.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var checkboxes = document.querySelectorAll('input[name="bus_id[]"]');
            var totalBusInput = document.getElementById('total_bus');

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    var checkedCheckboxes = document.querySelectorAll(
                        'input[name="bus_id[]"]:checked');
                    totalBusInput.value = checkedCheckboxes.length;
                });
            });
        });
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
