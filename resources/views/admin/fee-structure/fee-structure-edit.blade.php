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
                        <h3 class="mb-0">Update Fee Structure</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="nav-item">
                                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                                    <i class="bi bi-list"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Fee Structure</li>
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
                                <h3 class="card-title">Update Fee Structure</h3>
                            </div>
                            <!--end::Header-->
                            <!--begin::Form-->
                            <form action="{{ route('fee-structure.update', $fee_structure->id) }}" method="post">
                                @csrf
                                <!--begin::Body-->
                                <div class="card-body">

                                    <div class="row">
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="">Select Class</label>
                                            <select name="class_id" class="form-control" id="">
                                                <option value="">Select Class</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->id }}"
                                                        @if ($class->id == $fee_structure->class_id) selected @endif>
                                                        {{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('class_id')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror

                                        </div>
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="">Select Academic Year</label>
                                            <select name="academic_year_id" class="form-control" id="">
                                                <option value="">Select Academic Year</option>
                                                @foreach ($academic_years as $academic_year)
                                                    <option value="{{ $academic_year->id }}"
                                                        @if ($academic_year->id == $fee_structure->academic_year_id) selected @endif>
                                                        {{ $academic_year->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('academic_year_id')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="">Select Fee Head</label>
                                            <select name="fee_head_id" class="form-control" id="">
                                                <option value="">Select Fee Head</option>
                                                @foreach ($fee_heads as $fee_head)
                                                    <option value="{{ $fee_head->id }}"
                                                        @if ($fee_head->id == $fee_structure->fee_head_id) selected @endif>
                                                        {{ $fee_head->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('fee_head_id')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">April Fee</label>
                                            <input type="text" name="april" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                placeholder="Enter April fee"
                                                value="{{ old('april', $fee_structure->april) }}" />
                                        </div>
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">May Fee</label>
                                            <input type="text" name="may" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                placeholder="Enter May fee"
                                                value="{{ old('may', $fee_structure->may) }}" />
                                        </div>
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">June Fee</label>
                                            <input type="text" name="june" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                placeholder="Enter June fee"
                                                value="{{ old('june', $fee_structure->june) }}" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">July Fee</label>
                                            <input type="text" name="july" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                placeholder="Enter July fee"
                                                value="{{ old('july', $fee_structure->july) }}" />
                                        </div>
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">August Fee</label>
                                            <input type="text" name="august" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                placeholder="Enter August fee"
                                                value="{{ old('august', $fee_structure->august) }}" />
                                        </div>
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">September Fee</label>
                                            <input type="text" name="september" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                placeholder="Enter September fee"
                                                value="{{ old('september', $fee_structure->september) }}" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">October Fee</label>
                                            <input type="text" name="october" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                placeholder="Enter October fee"
                                                value="{{ old('october', $fee_structure->october) }}" />
                                        </div>
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">November Fee</label>
                                            <input type="text" name="november" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                placeholder="Enter November fee"
                                                value="{{ old('november', $fee_structure->november) }}" />
                                        </div>
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">December Fee</label>
                                            <input type="text" name="december" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                placeholder="Enter December fee"
                                                value="{{ old('december', $fee_structure->december) }}" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">January Fee</label>
                                            <input type="text" name="january" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                placeholder="Enter January fee"
                                                value="{{ old('january', $fee_structure->january) }}" />
                                        </div>
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">February Fee</label>
                                            <input type="text" name="february" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                placeholder="Enter February fee"
                                                value="{{ old('february', $fee_structure->february) }}" />
                                        </div>
                                        <div class="form-group col-md-4 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">March Fee</label>
                                            <input type="text" name="march" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                placeholder="Enter March fee"
                                                value="{{ old('march', $fee_structure->march) }}" />
                                        </div>
                                    </div>

                                </div>

                                <!--end::Body-->
                                <!--begin::Footer-->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Add Fee Structure</button>
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
