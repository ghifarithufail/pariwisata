@extends('main')
@section('content')
    <div class="card mt-4">
        <div class="card-body">
            <div class="card-header" style="zoom: 0.8">
                <h4>Booking Detail {{ $booking->no_booking }}</h4>
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
                        <div class="form-group">
                            <label class="control-label col-sm-3">Diskon</label>
                            <div class="col-sm-9">
                                <input type="text"
                                    value="{{ number_format($booking->diskon)}}" disabled
                                    class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 mt-4">
                        <h4>Detail Booking</h4>
                        <hr>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Bus</th>
                                    <th>Pengemudi</th>
                                    <th>Kondektur</th>
                                    <th>Jemput</th>
                                    <th>Biaya Jemput</th>
                                    <th>Harga Standar</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @php
                                    $TotalBiayaJemput = 0;
                                    $TotalHarga = 0;
                                @endphp
                                @foreach ($booking->details as $data)
                                @php
                                    $TotalBiayaJemput += $data->biaya_jemput;
                                    $TotalHarga += $data->harga_std;
                                @endphp
                                    <tr>
                                        <td>{{ $data->armadas->nobody }}</td>
                                        <td>{{ $data->pengemudis->users->name }}</td>
                                        <td>-</td>
                                        <td>{{ $data->jemput }}</td>
                                        <td style="text-align: right;">{{ number_format($data->biaya_jemput) }}</td>
                                        <td style="text-align: right;">{{ number_format($data->harga_std) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" style="text-align: right;"><b>TOTAL :</b></td>
                                    <td style="text-align: right;"><b>{{ number_format($TotalBiayaJemput) }}</b></td>
                                    <td style="text-align: right;"><b>{{ number_format($TotalHarga) }}</b></td>
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