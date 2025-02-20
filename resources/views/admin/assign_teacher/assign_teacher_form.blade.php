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
                        <h3 class="mb-0"> Assign Teacher to Class</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="nav-item">
                                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                                    <i class="bi bi-list"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Assign Teacher to Class</li>
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
                <div class="row g-2">
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
                        <div class="card mb-3 ">
                            <!--begin::Header-->
                            <div class="card-header">
                                <h3 class="card-title">Add Teacher to Class</h3>
                            </div>
                            <!--end::Header-->
                            <!--begin::Form-->
                            <form action="{{ route('assign-teacher.store') }}" method="post">
                                @csrf
                                <!--begin::Body-->

                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="" class="form-label"> Select Class </label>
                                        <select name="class_id" id="class_id" class="form-control">
                                            <option> Select Class </option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}"> {{ $class->name }} </option>
                                            @endforeach
                                        </select>
                                        @error('class_id')
                                            <p class="text-danger"> {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <label for="" class="form-label"> Select Subject </label>

                                    <div class="mb-3">
                                        <select name="subject_id" id="subject_id" class="form-control" id="">
                                            <option selected disabled> Select Subject </option>

                                        </select>
                                        @error('subject_id')
                                            <p class="text-danger"> {{ $message }}</p>
                                        @enderror
                                    </div>


                                    <label for="" class="form-label"> Select Teacher </label>
                                    <div class="mb-3">
                                        <select name="teacher_id" id="teacher_id" class="form-control" id="">
                                            <option value="" selected disabled> Select Subject </option>
                                            @foreach ($teachers as $teacher)
                                                <option value="{{ $teacher->id }}"> {{ $teacher->name }} </option>
                                            @endforeach
                                        </select>
                                        @error('teacher_id')
                                            <p class="text-danger"> {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Assign Teacher to Class</button>
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

@section('customJs')
    <script>
        // $('#class_id').on('change', function() {
        //     var class_id = $(this).val();

        //     $.ajax({
        //         url: "{{ route('findSubject') }}",
        //         type: 'get',
        //         data: {
        //             class_id
        //         },
        //         dataType: 'json',
        //         success: function(response) {
        //             $.each(response.subjects, (key, item) => {
        //                 $('#subject_id').append(
        //                     `<option value='${item.subject_id}' >${item.subject.name} </option>`
        //                 )
        //             })

        //         }

        //     });
        // });

        //find the subject on change
        $('#class_id').on('change', function() {
            var class_id = $(this).val();

            $.ajax({
                url: "{{ route('findSubject') }}",
                type: 'get',
                data: {
                    class_id
                },
                dataType: 'json',
                success: function(response) {
                    // Clear existing options
                    $('#subject_id').empty();

                    // Add the default option
                    $('#subject_id').append('<option value="">Select Subject</option>');

                    // Append new options
                    if (response.subjects && response.subjects.length > 0) {
                        $.each(response.subjects, (key, item) => {
                            $('#subject_id').append(
                                `<option value='${item.subject_id}'>${item.subject.name}</option>`
                            );
                        });
                    } else {
                        $('#subject_id').append('<option value="">No subjects available</option>');
                    }
                }
            });
        });
    </script>
@endsection
