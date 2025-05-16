@extends('template.temp')
@section('content')
    <div class="container-fluid">
        <div class="datatables">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between align-content-between">
                        <h4 class="card-title mb-0">Job Management</h4>
                        <button class="btn rounded-3 waves-effect waves-light btn-primary" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            Add Job
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($job as $jobs)
                                    <tr>
                                        <td>{{ $jobs->nama }}</td>
                                        <td>
                                            <!-- Tombol trigger modal edit -->
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#edit-modal-{{ $jobs->id }}">
                                                Edit
                                            </button>

                                            <form action="{{ route('jobs.destroy', $jobs->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                            </form>
                                        </td>
                                    </tr>


                                    <!-- Modal Edit User -->
                                    <div id="edit-modal-{{ $jobs->id }}" class="modal fade" tabindex="-1"
                                        aria-labelledby="editModalLabel-{{ $jobs->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit User - {{ $jobs->nama }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <form action="{{ route('jobs.update', $jobs->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="mb-3">
                                                            <label for="nama-{{ $jobs->id }}"
                                                                class="form-label">Name</label>
                                                            <input type="text" class="form-control"
                                                                id="nama-{{ $jobs->id }}" name="nama"
                                                                value="{{ old('nama', $jobs->nama) }}" required>
                                                        </div>

                                                        <div class="text-end">
                                                            <button type="submit" class="btn btn-primary">Update
                                                                job</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add User Offcanvas -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">Add User</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Name</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>

    </div>
@endsection
