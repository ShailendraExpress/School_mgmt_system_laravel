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
                        <h3 class="mb-0">Timetable List</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Timetable</li>
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
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        <div class="card mb-4">



                            <div class="card-header">
                                <h3 class="card-title">Timetable List</h3>
                            </div>
                            <!-- Filter data -->
                            <div class="d-flex justify-content-center align-items-center mt-3 mb-3">
                                <form action="">
                                    <div class="row justify-content-center">
                                        <div class="d-flex col-md-12 justify-content-center gap-2">
                                            <!-- Select Class -->
                                            <div class="form-group" style="width: 200px;">
                                                <select name="class_id" id="class_id" class="form-control">
                                                    <option value="">Select Class</option>
                                                    @foreach ($classes as $class)
                                                        <option value="{{ $class->id }}"
                                                            {{ $class->id == request('class_id') ? 'selected' : '' }}>
                                                            {{ $class->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group" style="width: 200px;">
                                                <select name="subject_id" id="subject_id" class="form-control">
                                                    <option value="" selected disabled>Select Subject</option>
                                                    @foreach ($subjects as $subject)
                                                        <option value="{{ $subject->subject->id }}"
                                                            {{ $subject->subject->id == request('subject_id') ? 'selected' : '' }}>
                                                            {{ $subject->subject->name }}
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
                                            <th>Class</th>
                                            <th>Subject</th>
                                            <th>Day</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Room Number</th>
                                            <th>Delete</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($timetables as $timetable)
                                            <tr class="align-middle">
                                                <td>{{ $timetable->id }}</td>
                                                <td>{{ $timetable->class ? $timetable->class->name : 'No Class Assigned' }}
                                                </td>
                                                <td>{{ $timetable->subject ? $timetable->subject->name : 'No Subject Assigned' }}
                                                </td>
                                                <td>{{ $timetable->day ? $timetable->day->name : 'No Day Assigned' }}</td>
                                                <td>{{ $timetable->start_time }}</td>
                                                <td>{{ $timetable->end_time }}</td>
                                                <td>{{ $timetable->room_no }}</td>
                                                <td>
                                                    <a href="{{ route('timetable.delete', $timetable->id) }}"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure want to delete?')">Delete</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-danger">No records found</td>
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
