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
                        <h3 class="mb-0"> Teacher</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="nav-item">
                                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                                    <i class="bi bi-list"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Teacher</li>
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

                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-12">
                        <!--begin::Quick Example-->
                        <div class="card mb-4 ">
                            <!--begin::Header-->
                            <div class="card-header">
                                <h3 class="card-title">Update Teacher</h3>
                            </div>
                            <!--end::Header-->
                            <!--begin::Form-->
                            <form action="{{ route('teacher.update', $teacher->id) }}" method="post">
                                @csrf
                                <!--begin::Body-->
                                <div class="card-body">


                                    <div class="row">
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Teacher Name</label>
                                            <input type="text" name="name" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                value="{{ old('name', $teacher->name) }}"
                                                placeholder="Enter Teacher Name" />
                                            @error('name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Teacher's Father
                                                Name</label>
                                            <input type="text" name="father_name" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                value="{{ old('father_name', $teacher->father_name) }}"
                                                placeholder="Enter Teacher's Father Name" />
                                            @error('father_name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Teacher's Mother
                                                Name</label>
                                            <input type="text" name="mother_name" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                value="{{ old('mother_name', $teacher->mother_name) }}"
                                                placeholder="Enter Teacher's Mother Name" />
                                            @error('mother_name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">DOB</label>
                                            <input type="date" name="dob" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                value="{{ old('dob', $teacher->dob) }}" placeholder="Enter DOB" />
                                            @error('dob')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Mobile</label>
                                            <input type="text" name="mobno" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                value="{{ old('mobno', $teacher->mobno) }}" placeholder="Enter Mobile" />
                                            @error('mobno')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="exampleInputEmail1" class="form-label"> Email Address </label>
                                            <input type="text" name="email" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                value="{{ old('email', $teacher->email) }}"
                                                placeholder="Enter Email Address" />
                                            @error('email')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                                <!--end::Body-->
                                <!--begin::Footer-->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update Teacher</button>
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
