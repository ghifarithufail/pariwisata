<table class="table table-hover">
    <thead>
        <tr>
            <th>No SPJ</th>
            <th>No Booking</th>
            <th>Customer</th>
            <th>Jam Jemput</th>
            <th>Tujuan</th>
            <th>KM Keluar</th>
            <th>KM Masuk</th>
            <th>Uang Jalan</th>
            <th>Uang Makan</th>
            <th>Uang Parkir</th>
            <th>Uang Tol</th>
            <th>BBM</th>
            <th>Biaya Lain</th>
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @php
            $totalUangJalan = 0;
            $totalUangMakan = 0;
            $totalUangParkir = 0;
            $totalUangTol = 0;
            $totalUangBbm = 0;
            $totalBiayaLain = 0;
        @endphp
        @foreach ($booking as $item)
            @foreach ($item->details as $data)
                @php
                    $totalUangJalan += $data->spjs->uang_jalan;
                    $totalUangMakan += $data->spjs->uang_makan;
                    $totalUangParkir += $data->spjs->parkir;
                    $totalUangTol += $data->spjs->tol;
                    $totalUangBbm += $data->spjs->bbm;
                    $totalBiayaLain += $data->spjs->biaya_lain;
                @endphp
                <tr>
                    <td>{{ $data->spjs->no_spj }}</td>
                    <td>{{ $item->no_booking }}</td>
                    <td>{{ $item->customer }}</td>
                    <td>{{ $data->spjs->jam_jemput }}</td>
                    <td>{{ $item->tujuan->nama_tujuan }}</td>
                    <td>{{ $data->spjs->km_keluar }}</td>
                    <td>{{ $data->spjs->km_masuk }}</td>
                    <td style="text-align: right;">{{ number_format($data->spjs->uang_jalan) }}</td>
                    <td style="text-align: right;">{{ number_format($data->spjs->uang_makan) }}</td>
                    <td style="text-align: right;">{{ number_format($data->spjs->parkir) }}</td>
                    <td style="text-align: right;">{{ number_format($data->spjs->tol) }}</td>
                    <td style="text-align: right;">{{ number_format($data->spjs->bbm) }}</td>
                    <td style="text-align: right;">{{ number_format($data->spjs->biaya_lain) }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7" style="text-align: right;"><b>TOTAL :</b></td>
            <td style="text-align: right;"><b>{{ number_format($totalUangJalan) }}</b></td>
            <td style="text-align: right;"><b>{{ number_format($totalUangMakan) }}</b></td>
            <td style="text-align: right;"><b>{{ number_format($totalUangParkir) }}</b></td>
            <td style="text-align: right;"><b>{{ number_format($totalUangTol) }}</b></td>
            <td style="text-align: right;"><b>{{ number_format($totalUangBbm) }}</b></td>
            <td style="text-align: right;"><b>{{ number_format($totalBiayaLain) }}</b></td>
        </tr>
    </tfoot>
</table>
