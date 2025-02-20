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
                        <h3 class="mb-0">Academic Year</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="nav-item">
                                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                                    <i class="bi bi-list"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Academic Year</li>
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
                    <div class="col-10">

                        @if (Session::has('success'))
                            <div id="success-message" class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        <script>
                            // Automatically hide the success message after 3 seconds
                            setTimeout(function() {
                                const successMessage = document.getElementById('success-message');
                                if (successMessage) {
                                    successMessage.style.display = 'none';
                                }
                            }, 3000);
                        </script>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-10">
                        <!--begin::Quick Example-->
                        <div class="card mb-4 ">
                            <!--begin::Header-->
                            <div class="card-header">
                                <h3 class="card-title">Update Academic Year</h3>
                            </div>
                            <!--end::Header-->
                            <!--begin::Form-->
                            <form action="{{ route('academic-year.update') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $academic_year->id }}">
                                <!--begin::Body-->
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label"> Academic Year</label>
                                        <input type="text" name="name" value="{{ old('name', $academic_year->name) }}"
                                            class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                            placeholder="Enter Academic Year" />
                                        <div id="emailHelp" class="form-text">
                                        </div>
                                        @error('name')
                                            <p class="text-danger"> {{ $message }}</p>
                                        @enderror
                                    </div>

                                </div>

                                <!--end::Body-->
                                <!--begin::Footer-->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update Academic Year</button>
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
