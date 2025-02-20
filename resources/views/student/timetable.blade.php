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
                        <h3 class="mb-0">Timetable </h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Home</a></li>
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
                        <div class="card  mb-1">
                            <div class="card-header">
                                <h3 class="card-title">Timetable</h3>
                            </div>

                            <div class="card-body">
                                @foreach ($timetable as $day => $details)
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header ">
                                            <h5 class="mb-0">{{ $day }}</h5>
                                        </div>

                                        <div class="card-body">
                                            <table class="table table-hover table-bordered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Subject Name</th>
                                                        <th>Start Time</th>
                                                        <th>End Time</th>
                                                        <th>Room No</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($details as $slot)
                                                        <tr>
                                                            <td>{{ $slot['subject'] }}</td>
                                                            <td>{{ $slot['start_time'] }}</td>
                                                            <td>{{ $slot['end_time'] }}</td>
                                                            <td>{{ $slot['room_no'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>


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
        $(document).ready(function() {
            // Jab class select hoti hai tab button enable hoga
            $("#class_id").on("change", function() {
                let class_id = $(this).val();
                if (class_id !== "") {
                    $("#filterBtn").prop("disabled", false);
                } else {
                    $("#filterBtn").prop("disabled", true);
                }
            });
        });
    </script>
@endsection
