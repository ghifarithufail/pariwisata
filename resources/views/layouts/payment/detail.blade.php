@extends('main')
@section('content')

    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Select2 CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
            integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Select2 JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
            integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <div class="card mt-4">
        <div class="card-body">
            <div class="card-header" style="zoom: 0.8">
                <h4>Booking Detail {{ $booking->no_booking }}
                    @if ($booking->payment_status == 1)
                        <span class="badge bg-success"> Lunas </span>
                    @else
                        <span class="badge bg-danger"> Belum Lunas </span>
                    @endif
                </h4>
                <hr>
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class="control-label col-sm-3">Name :</label>
                            <div class="col-sm-9">
                                <input type="text" value="{{ $booking->customer }}" disabled class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Start Date :</label>
                            <div class="col-sm-9">
                                <input type="date"
                                    value="{{ Carbon\Carbon::parse($booking->date_start)->format('Y-m-d') }}" disabled
                                    class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Biaya Booking :</label>
                            <div class="col-sm-9">
                                <input type="text" value="{{ number_format($booking->grand_total) }}" disabled
                                    class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class="control-label col-sm-3">Tujuan :</label>
                            <div class="col-sm-9">
                                <input type="text"
                                    value="@foreach ($booking->tujuans() as $key => $item){{ $item->nama_tujuan }}@if (!$loop->last), @endif @endforeach"
                                    disabled class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">End Date</label>
                            <div class="col-sm-9">
                                <input type="date"
                                    value="{{ Carbon\Carbon::parse($booking->date_end)->format('Y-m-d') }}" disabled
                                    class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 mt-4">
                        <h4>Detail Payment</h4>
                        <hr>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No Invoice</th>
                                    <th>tipe payment</th>
                                    <th>Bukti Bayar</th>
                                    <th>Tanggal pembayaran</th>
                                    <th style="text-align: right;">Nominal dibayarkan</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @php
                                    $totalPembayaran = 0;
                                @endphp
                                @foreach ($booking->payments as $detail)
                                    @php
                                        $totalPembayaran += $detail->price;
                                    @endphp
                                    <tr>
                                        <td>{{ $detail->no_payment }}</td>
                                        <td>{{ $detail->types->name }}</td>
                                        <td>
                                            <a href="{{ asset('uploads/' . $detail->image) }}" target="_blank">
                                                <img src="{{ asset('uploads/' . $detail->image) }}" width="80"
                                                    height="80" style="border-radius: 20%;">
                                            </a>
                                        </td>
                                        <td>{{ $detail->created_at }}</td>
                                        <td style="text-align: right;">{{ number_format($detail->price) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" style="text-align: right;"><b>TOTAL PEMBAYARAN :</b></td>
                                    <td style="text-align: right;"><b>{{ number_format($totalPembayaran) }}</b></td>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="mt-3">
                            <!-- Modal -->
                            <div class="modal fade" id="basicModal" tabindex="-1" style="display: none;"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form id="form">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel1">Penjemputan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col mb-3">
                                                        <label for="bus" class="form-label">Bus</label>
                                                        <input type="text" id="bus" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="row g-2">
                                                    <div class="col mb-0">
                                                        <label for="jemput" class="form-label">Lokasi Jemput</label>
                                                        <input type="text" name="jemput" id="jemput"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col mb-0">
                                                        <label for="biaya_jemput" class="form-label">Biaya Jemput</label>
                                                        <input type="number" name="biaya_jemput" id="biaya_jemput"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" id="saveChangesBtn">Save
                                                    changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
