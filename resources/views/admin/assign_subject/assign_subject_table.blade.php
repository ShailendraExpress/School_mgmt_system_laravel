@extends('admin.layout')
@section('content')
    <main class="app-main">

        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Assign Subjects</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Assign Subject</li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">


                    <div class="col-md-12">
                        <div class="card mb-4">

                            @if (Session::has('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                </div>
                            @endif

                            <div class="card-header">
                                <h3 class="card-title">Assign Subject List</h3>
                            </div>
                            <!-- Here Filter Data with Class -->

                            <div class="d-flex justify-content-center align-items-center mt-3 mb-3">
                                <form action="">
                                    <div class="row justify-content-center">
                                        <div class="d-flex col-md-12 justify-content-center gap-2">
                                            <!-- Select Class -->
                                            <div class="form-group" style="width: 250px;">
                                                <label for="">Select Class</label>
                                                <select name="class_id" class="form-control">
                                                    <option value="">Select Class</option>
                                                    @foreach ($classes as $class)
                                                        <option value="{{ $class->id }}"
                                                            {{ $class->id == request('class_id') ? 'selected' : '' }}>
                                                            {{ $class->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>



                                            <!-- Filter Button -->
                                            <div class="form-group d-flex align-items-end">
                                                <button type="submit" class="btn btn-success">Filter Data</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">ID</th>
                                            <th>Class Name</th>
                                            <th>Subject Name</th>
                                            <th>Created Time</th>
                                            <th colspan="2" style="width: 40px">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($assign_subjects as $assign_subject)
                                            <tr class="align-middle">
                                                <td>{{ $assign_subject->id }}</td>
                                                <td>{{ $assign_subject->class->name }}</td>
                                                <td>{{ $assign_subject->subject->name }}</td>
                                                <td>{{ $assign_subject->created_at }}</td>
                                                <td><a href="{{ route('assign-subject.edit', $assign_subject->id) }}"
                                                        class="btn btn-primary">Edit</a> &nbsp;<a
                                                        href="{{ route('assign-subject.delete', $assign_subject->id) }}"
                                                        class="btn btn-danger "onclick="return confirm('Are you sure want to delete?')">Delete</a>
                                                </td>

                                            </tr>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-danger">No data found!</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <ul class="pagination pagination-sm m-0 float-end">
                                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->

                    <!-- /.col -->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection
