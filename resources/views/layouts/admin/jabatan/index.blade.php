@extends('main')
@section('content')
    <div class="card text-center">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="search-field">
                <form action="{{ route('jabatans') }}" method="GET">
                    <input type="text" name="search" class="form-control" placeholder="Search...">
                </form>
            </div>
            <div>
                <a href="{{ route('jabatans') }}"  class="m-0"><h5> DaftarPemakai</h5></a>
                <p class="m-0">Total : {{ App\Models\Admin\Jabatan::count() }} </p>
            </div>
            <div class="add-new-role">
                <!-- Tombol "Add New Role" -->
                <button data-bs-target="#addUserModal" data-bs-toggle="modal" class="btn btn-primary mb-2 text-nowrap">
                    + Jabatan
                </button>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover" style="zoom: 0.85">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Nama Jabatab</th>
                        <th>Kode Jabayan</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($users as $data)
                        <tr>
                            <td>{{ $data->nama_jabatan }}</td>
                            <td>{{ $data->kodejab }}</td>
                            <td>
                                <div class="dropdown text-center">
                                    <a href="{{ route('jabatans/edit', $data->id) }}">
                                        <button type="button" class="btn rounded-pill btn-warning"
                                            fdprocessedid="c80zr4">Edit</button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="intro-y col-span-12">
            <div class="card-footer">
                {{ $jabatans->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Add Role Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple modal-edit-user">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Tambah Pemakai</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users/store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Input untuk user -->
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" minlength="3" required>
                                    @error('name')
                                        <div class="sm:ml-auto mt-1 sm:mt-0 text-sm text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="username" class="form-label">User Name</label>
                                    <input id="username" type="text" name="username" class="form-control" value="{{ old('username') }}" minlength="3" required>
                                    @error('username')
                                        <span class="text-red-400 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary" name="action">Submit</button>
                                    <a href="{{ route('jabatans') }}" class="btn btn-warning">Cancel</a>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
