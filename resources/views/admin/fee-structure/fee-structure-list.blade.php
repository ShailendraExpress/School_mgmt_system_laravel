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
                        <h3 class="mb-0">Fee Structure </h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Fee Structure List</li>
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
                                <h3 class="card-title">Fee Structure List</h3>
                            </div>
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
                                            <th>Academic Year</th>
                                            <th>Class</th>
                                            <th>Fee Head</th>
                                            <th>April</th>
                                            <th>May</th>
                                            <th>June</th>
                                            <th>July</th>
                                            <th>August</th>
                                            <th>September</th>
                                            <th>October</th>
                                            <th>November</th>
                                            <th>December</th>
                                            <th>January</th>
                                            <th>February</th>
                                            <th>Macrh</th>
                                            <th>Created Time</th>
                                            <th colspan="2" style="width: 40px">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($FeeStructure as $fee)
                                            <tr class="align-middle">
                                                <td>{{ $fee->id }}</td>
                                                <td>{{ $fee->AcademicYear->name }}</td>
                                                <td>{{ $fee->Classes->name }}</td>
                                                <td>{{ $fee->FeeHead->name }}</td>
                                                <td>{{ $fee->april }}</td>
                                                <td>{{ $fee->may }}</td>
                                                <td>{{ $fee->june }}</td>
                                                <td>{{ $fee->july }}</td>
                                                <td>{{ $fee->august }}</td>
                                                <td>{{ $fee->september }}</td>
                                                <td>{{ $fee->october }}</td>
                                                <td>{{ $fee->november }}</td>
                                                <td>{{ $fee->december }}</td>
                                                <td>{{ $fee->january }}</td>
                                                <td>{{ $fee->february }}</td>
                                                <td>{{ $fee->march }}</td>
                                                <td>{{ $fee->created_at }}</td>
                                                <td><a href="{{ route('fee-structure.edit', $fee->id) }}"
                                                        class="btn btn-primary btn-sm">Edit</a> &nbsp;<a
                                                        href="{{ route('fee-structure.delete', $fee->id) }}"
                                                        class="btn btn-danger btn-sm "onclick="return confirm('Are you sure want to delete?')">Delete</a>
                                                </td>

                                            </tr>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    {{-- <tfoot>
                                        <tr>
                                            <th style="width: 10px">ID</th>
                                            <th>Academic Year</th>
                                            <th>Class</th>
                                            <th>Fee Head</th>
                                            <th>April</th>
                                            <th>May</th>
                                            <th>June</th>
                                            <th>July</th>
                                            <th>August</th>
                                            <th>September</th>
                                            <th>October</th>
                                            <th>November</th>
                                            <th>December</th>
                                            <th>January</th>
                                            <th>February</th>
                                            <th>Macrh</th>
                                            <th>Created Time</th>
                                            <th colspan="2" style="width: 40px">Action</th>

                                        </tr>
                                    </tfoot> --}}
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
