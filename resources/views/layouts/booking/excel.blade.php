<table class="table table-hover" style="zoom: 0.75">
    <thead>
        <tr>
            <th>No Booking</th>
            <th>Pesan</th>
            <th>Tanggal Operasi</th>
            <th>Jumlah Bus</th>
            <th>Lama Hari</th>
            <th>Total Hari Operasi</th>
            <th>Nama Pemesan</th>
            <th>Tujuan</th>
            <th>Harga Standar</th>
            <th>Diskon</th>
            <th>Biaya Jemput</th>
            <th>Total Biaya Booking</th>
            <th>Total Pengeluaran</th>
            <th>Total Pendapatan</th>
            {{-- <th class="text-center">Actions</th> --}}
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @foreach ($booking as $data)
            <tr>
                <td>{{ $data->no_booking }}</td>
                <td>{{ $data->created_at }}</td>
                <td>{{ $data->date_start }}</td>
                <td>{{ $data->total_bus }}</td>
                <td>-</td>
                <td>-</td>
                <td>{{ $data->customer }}</td>
                <td>{{ $data->tujuan->nama_tujuan }}</td>
                <td>{{ number_format($data->harga_std) }}</td>
                <td>{{ number_format($data->diskon) }}</td>
                <td>{{ number_format($data->biaya_jemput) }}</td>
                <td>{{ number_format($data->grand_total) }}</td>
                <td>{{ number_format($data->total_pengeluaran) }}</td>
                <td>{{ number_format($data->total_pendapatan) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
