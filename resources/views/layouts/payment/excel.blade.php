<table class="table table-hover">
    <thead>
        <tr>
            <th>No Invoice</th>
            <th>Customer</th>
            <th>No Booking</th>
            <th>Tujuan</th>
            <th>tipe payment</th>
            <th>Tanggal pembayaran</th>
            <th>Status</th>
            <th style="text-align: right;">Nominal dibayarkan</th>
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @php
            $totalPembayaran = 0;
        @endphp
        @foreach ($booking as $data)
            @foreach ($data->payments as $detail)
                @php
                    $totalPembayaran += $detail->price;
                @endphp
                <tr>
                    <td>{{ $detail->no_payment }}</td>
                    <td>{{ $data->customer }}</td>
                    <td>{{ $data->no_booking }}</td>
                    <td>{{ $data->tujuan->nama_tujuan }}</td>
                    <td>{{ $detail->types->name }}</td>
                    <td>{{ $detail->created_at }}</td>
                    <td>
                        @if ($data->payment_status == '1')
                            Lunas
                        @else
                            Belum Lunas
                        @endif
                    
                    </td>
                    <td style="text-align: right;">{{ number_format($detail->price) }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7" style="text-align: right;"><b>TOTAL PEMBAYARAN :</b></td>
            <td style="text-align: right;"><b>{{ number_format($totalPembayaran) }}</b></td>
        </tr>
    </tfoot>
</table>
