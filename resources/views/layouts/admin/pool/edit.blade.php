@extends('main')
@section('content')

    <div class="container-xxl">
        <div class="card mb-4">
            <h5 class="card-header">Edit pool</h5>
            <!-- Account -->
            <div class="card-body">
                <form action="{{ route('pool.update', $pool->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- Input untuk pool -->
                        <div class="mb-3 col-md-6">
                            <label for="nama_pool" class="form-label">Nama pool</label>
                            <input id="nama_pool" type="text" name="nama_pool" class="form-control"
                                    value="{{ $pool->nama_pool }}" minlength="3" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="kodejab" class="form-label">Kode pool</label>
                            <input id="kodejab" type="text" name="kodejab" class="form-control"
                                    value="{{ $pool->kodejab }}" minlength="3" required>
                        </div>

                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary" name="action">Update</button>
                            <a href="{{ route('pool') }}" class="btn btn-warning">Back</a>
                        </div>
                    </div>
                </form>
            </div>
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
