@extends('student.layout')
@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Chnage Password</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="nav-item">
                                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                                    <i class="bi bi-list"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Chnage Password</li>
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
                <div class="row g-4">
                    <!--begin::Col-->
                    <div class="col-12">


                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error') }}
                            </div>
                        @endif

                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-12">
                        <!--begin::Quick Example-->
                        <div class="card mb-4 ">
                            <!--begin::Header-->
                            <div class="card-header">
                                <h3 class="card-title">Chnage Password</h3>
                            </div>
                            <!--end::Header-->
                            <!--begin::Form-->
                            <form action="{{ route('student.updatePassword') }}" method="post">
                                @csrf
                                <!--begin::Body-->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Old Password</label>
                                            <input type="text" name="old_password" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                placeholder="Enter Old Password" />
                                            <div id="emailHelp" class="form-text">
                                            </div>
                                            @error('old_password')
                                                <p class="text-danger"> {{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">New Password</label>
                                            <input type="text" name="new_password" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                placeholder="Enter New Password" />
                                            <div id="emailHelp" class="form-text">
                                            </div>
                                            @error('new_password')
                                                <p class="text-danger"> {{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Confirm New Password</label>
                                            <input type="text" name="password_confirmation" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                placeholder="Enter Confirm New Password" />
                                            <div id="emailHelp" class="form-text">
                                            </div>
                                            @error('password_confirmation')
                                                <p class="text-danger"> {{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                <!--end::Body-->
                                <!--begin::Footer-->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                                <!--end::Footer-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Quick Example-->
                        <!--begin::Input Group-->

                        <!--end::Input Group-->
                        <!--begin::Horizontal Form-->

                        <!--end::Horizontal Form-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->

                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection
