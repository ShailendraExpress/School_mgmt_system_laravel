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
                        <h3 class="mb-0"> Assign Subject</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="nav-item">
                                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                                    <i class="bi bi-list"></i>
                                </a>
                            </li>
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
                                <h3 class="card-title">Add Subject </h3>
                            </div>
                            <!--end::Header-->
                            <!--begin::Form-->
                            <form action="{{ route('assign-subject.store') }}" method="post">
                                @csrf
                                <!--begin::Body-->

                                <div class="card-body">
                                    <div class="mb-3">
                                        <select name="class_id" class="form-control" id="">
                                            <option value="" selected disabled> Select Class </option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}"> {{ $class->name }} </option>
                                            @endforeach
                                        </select>
                                        @error('class_id')
                                            <p class="text-danger"> {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <label for="" class="form-label"> Select Subjects </label>

                                    @foreach ($subjects as $subject)
                                        <div class="form-check">
                                            <input type="checkbox" id="subject-{{ $subject->id }}" name="subject_id[]"
                                                value="{{ $subject->id }}">
                                            <label for="subject-{{ $subject->id }}">{{ $subject->name }}</label>
                                        </div>
                                    @endforeach
                                    @error('subject_id')
                                        <p class="text-danger"> {{ $message }}</p>
                                    @enderror

                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
