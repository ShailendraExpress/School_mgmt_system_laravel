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
                        <h3 class="mb-0">Fee Structure</h3>
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
                                                <td>{{ $fee->macrh }}</td>
                                                <td>{{ $fee->created_at }}</td>
                                                <td><a href="{{ route('fee-structure.edit', $fee->id) }}"
                                                        class="btn btn-primary">Edit</a> &nbsp;<a
                                                        href="{{ route('fee-structure.delete', $fee->id) }}"
                                                        class="btn btn-danger "onclick="return confirm('Are you sure want to delete?')">Delete</a>
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
