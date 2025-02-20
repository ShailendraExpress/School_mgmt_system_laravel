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
                        <h3 class="mb-0">Student List</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Students</li>
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
                                <h3 class="card-title">Student List</h3>
                            </div>
                            <!-- Filter data -->

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

                                            <!-- Select Academic Year -->
                                            <div class="form-group" style="width: 250px;">
                                                <label for="">Select Academic Year</label>
                                                <select name="academic_year_id" class="form-control">
                                                    <option value="">Select Academic Year</option>
                                                    @foreach ($academic_years as $academic_year)
                                                        <option value="{{ $academic_year->id }}"
                                                            {{ $academic_year->id == request('academic_year_id') ? 'selected' : '' }}>
                                                            {{ $academic_year->name }}
                                                        </option>
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
                                            <th>Name</th>
                                            <th>Academic Year</th>
                                            <th>Class</th>
                                            <th>Father's Name</th>
                                            <th>Mother's Name</th>
                                            <th>Mobile Number</th>
                                            <th>Date of Birth</th>
                                            <th>Email</th>
                                            <th>Created Time</th>
                                            <th colspan="2" style="width: 40px">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $item)
                                            <tr class="align-middle">
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->studentAcademicYear->name ?? 'N/A' }}</td>
                                                <td>{{ $item->studentClass->name ?? 'N/A' }}</td>
                                                <td>{{ $item->father_name }}</td>
                                                <td>{{ $item->mother_name }}</td>
                                                <td>{{ $item->mobno }}</td>
                                                <td>{{ $item->dob }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td><a href="{{ route('student.edit', $item->id) }}"
                                                        class="btn btn-primary btn-sm">Edit</a> &nbsp;<a
                                                        href="{{ route('student.delete', $item->id) }}"
                                                        class="btn btn-danger btn-sm "onclick="return confirm('Are you sure want to delete?')">Delete</a>
                                                </td>

                                            </tr>
                                            </tr>
                                        @endforeach

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
