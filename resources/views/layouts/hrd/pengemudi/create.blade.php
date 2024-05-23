@extends('main')
@section('content')

    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h5 class="card-header">Pengemudi</h5>
        <hr class="my-0" />
        <div class="card-body">
            <form action="{{ route('pengemudi/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="user_id" class="form-label">User</label>
                        <select id="user_id" name="user_id" class="select2 form-select" data-allow-clear="false">
                        <option value="">Pilih User</option>
                        @foreach ($users->filter->hasRole('pengemudi') as $data)
                            <option value="{{ $data->id }}" {{ old('user_id') == $data->id ? 'selected' : '' }}>
                                {{ $data->id }} - {{ $data->name }}</option>
                        @endforeach
                        </select>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="nopengemudi" class="form-label">Nomor Pengemudi</label>
                        <input id="nopengemudi" name="nopengemudi" type="text" value="{{ \App\Models\Hrd\Pengemudi::generateNopengemudi() }}" class="form-control">
                        @if ($errors->has('nopengemudi'))
                        <div class="text-danger">
                            {{ $errors->first('nopengemudi') }}
                        </div>
                    @endif
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="rute_id" class="form-label">Rute</label>
                        <select class="select2 form-select" id="rute_id" name="rute_id[]" required>
                          <option value="">Pilih Rute</option>
                          @if(isset($rutes) && count($rutes) > 0)
                            @foreach($rutes as $rute)
                              @php
                                $pool = $rute->poolS; // Asumsi relasi "pool" ada di model Rute
                              @endphp
                              <option value="{{ $rute->id }}"
                                data-rute="{{ $rute->kode_route }}"
                                data-pool="{{ $pool ? $pool->id : '' }}"
                                {{ old('rute_id') == $rute->id ? 'selected' : '' }}>
                                {{ $rute->nama_rute }} - {{ $pool ? $pool->nama_pool : 'Pool Tidak Tersedia' }}
                              </option>
                            @endforeach
                          @endif
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label" for="pool_id">Pool</label>
                        <select id="pool_id" name="pool_id" class="select2 form-select" data-allow-clear="true">
                            <option value="">{{ __('Select Pool') }}</option>
                            @foreach($pools as $pool)
                                <option value="{{ $pool->id }}" {{old('pengemudi->pool_id') == $pool->id ? 'selected' : '' }}>
                                    {{ $pool->nama_pool }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="tgl_masuk" class="form-label">Tanggal Masuk</label>
                        <input type="date" class="form-control" id="tgl_masuk" name="tgl_masuk" value="{{ old('tgl_masuk') }}" />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="tanggal_kp" class="form-label">Tanggal KP</label>
                        <input type="date" class="form-control" id="tanggal_kp" name="tanggal_kp" value="{{ old('tanggal_kp') }}" />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="nosim" class="form-label">Nomor SIM</label>
                        <input type="text" class="form-control" id="nosim" name="nosim" value="{{ old('nosim') }}"/>
                        @if ($errors->has('nosim'))
                            <div class="text-danger">
                                {{ $errors->first('nosim') }}
                            </div>
                        @endif
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="jenis_sim">Jenis SIM</label>
                        <select id="jenis_sim" name="jenis_sim" class="select2 form-select" required>
                            <option value="">Select Status</option>
                            <option value="BI" {{ old('jenis_sim') == 'BI' ? 'selected' : '' }}>BI</option>
                            <option value="BI-Umum" {{ old('jenis_sim') == 'BI-Umum' ? 'selected' : '' }}>BI-Umum</option>
                            <option value="BII" {{ old('jenis_sim') == 'BII' ? 'selected' : '' }}>BII</option>
                            <option value="BII-Umum" {{ old('jenis_sim') == 'BII-Umum' ? 'selected' : '' }}>BII-Umum</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="tgl_sim" class="form-label">Tanggal SIM</label>
                        <input type="date" class="form-control" id="tgl_sim" name="tgl_sim" value="{{ old('tgl_sim') }}"/>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="nojamsostek" class="form-label">Nomor Jamsostek</label>
                        <input type="text" class="form-control" id="nojamsostek" name="nojamsostek" value="{{ old('nojamsostek') }}"/>
                        @if ($errors->has('nojamsostek'))
                            <div class="text-danger">
                                {{ $errors->first('nojamsostek') }}
                            </div>
                        @endif
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="ket_pengemudi" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="ket_pengemudi" name="ket_pengemudi" value="{{ old('ket_pengemudi') }}"/>
                    </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary" name="action">Submit</button>
                    <a href="{{ route('pengemudi') }}" class="btn btn-warning">Kembali</a>
                </div>
            </form>
        </div>
        <!-- /Account -->
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#rute_id').select2(); // Initialize Select2 on the dropdown

            $('#rute_id').change(function () {
                var selectedOption = $(this).children("option:selected");
                var id = selectedOption.data('pool'); // Access pool ID

                if (id) {
                    // Use AJAX to retrieve pool name based on pool ID
                    $.ajax({
                        url: '/get-pool-name/' + id, // Adjust URL according to your route
                        type: 'GET',
                        success: function (response) {
                            $('#nama_pool').val(response.nama_pool); // Fill the pool name into the input field
                        },
                        error: function (xhr, status, error) {
                            console.error(error);
                        }
                    });
                } else {
                    // If no pool ID is available, clear the input field
                    $('#nama_pool').val('');
                }
            });

            // Trigger event 'change' for autofill on page load
            $('#rute_id').trigger('input');
        });
    </script>

@endsection
