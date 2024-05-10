@extends('main')
@section('content')
    <div class="card text-center">
        <h5 class="card-header">Payments Bookings</h5>
    </div>

    <div class="row mt-4">

        <div class="col-sm-6 col-lg-6 mb-4">
            <div class="card card-border-shadow-warning h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-warning"><i class='bx bx-dollar-circle' ></i></span>
                        </div>
                        <h4 class="ms-1 mb-0"></h4>
                    </div>
                    <p class="mb-1"><b>Yang Harus Dibayar</b></p>
                    <p class="mb-0">
                        <span class="fw-medium me-1"></span>
                    </p>
                </div>
            </div>
        </div>
        
        @if ($booking->booking_price == $booking->total_payment)
            <div class="col-sm-6 col-lg-6 mb-4">
                <div class="card card-border-shadow-success h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-success"><i class='bx bx-dollar'></i></span>
                            </div>
                            <h4 class="ms-1 mb-0"></h4>
                        </div>
                        <p class="mb-1"><b>Yang sudah Dibayar</b></p>
                        <p class="mb-0">
                            <span class="fw-medium me-1">{{ number_format($booking->payments->sum('price')) }}</span>
                        </p>
                    </div>
                </div>
            </div>
        @else
        <div class="col-sm-6 col-lg-6 mb-4">
            <div class="card card-border-shadow-danger h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-danger"><i class='bx bx-dollar'></i></span>
                        </div>
                        <h4 class="ms-1 mb-0"></h4>
                    </div>
                    <p class="mb-1"><b>Yang sudah Dibayar</b></p>
                    <p class="mb-0">
                        <span class="fw-medium me-1">{{ number_format($booking->payments->sum('price')) }}</span>
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <div class="card-header" style="zoom: 0.8">
                <h4>
                    Booking Detail
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
                                    value="{{ Carbon\Carbon::parse($booking->start_date)->format('Y-m-d') }}" disabled
                                    class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">End Date</label>
                            <div class="col-sm-9">
                                <input type="date"
                                    value="{{ Carbon\Carbon::parse($booking->end_date)->format('Y-m-d') }}" disabled
                                    class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class="control-label col-sm-3">NIK :</label>
                            <div class="col-sm-9">
                                <input type="text" disabled class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Name :</label>
                            <div class="col-sm-9">
                                <input type="text" disabled class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Team :</label>
                            <div class="col-sm-9">
                                <input type="text" disabled class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 mt-4">
                        <h4>
                            Payments
                        </h4>
                        <hr>
                        <form action="{{ route('payment/store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="control-label col-sm-3">Payment Type :</label>
                                <div class="col-sm-12 mt-3">
                                    <select class="form-control input-goldbrand" name="type_payment_id" required>
                                        <option value="">- Choose Payment type -</option>
                                        @foreach ($type as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <input type="number" value="{{ $booking->id }}" name="booking_id"
                                class="form-control input-quantity" hidden required>

                            <div class="form-group mt-3">
                                <label class="control-label col-sm-3">Price :</label>
                                <div class="col-sm-12 mt-2">
                                    <input type="number" class="form-control input-quantity" name="price" required>
                                </div>
                            </div>
                            <div class="pt-5 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
