@include('partials.head')

<div class="container-fluid">
    <div class="row">

        <div class="col-md-12 my-4 fw-bold fs-3">
            Staff Joined Training
        </div>

                <div>
                    @if ($completedTrainings->isNotEmpty())
                        @php
                            $totalHours = App\Http\Controllers\StaffController::getHour($completedTrainings[0]->staff_id);
                        @endphp
                        Total Training Hours: {{ $totalHours }}
                    @endif
                </div>

            <div class="container-fluid d-flex justify-content-center my-2">
                <div class="card" id="card_shadow" style="width: 110rem;">
                
                    <div class="table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Staff ID</th>
                                    <th>Staff Name</th>
                                    <th>Training Code</th>
                                    <th>Training Name</th>
                                    <th>Training Hours</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($completedTrainings as $staffTraining)
                                <tr>
                                    <td>{{ $staffTraining->staff_id }}</td>
                                    <td>{{ $staffTraining->staff_name }}</td>
                                    <td>{{ $staffTraining->training_code }}</td>
                                    <td>{{ $staffTraining->training_name }}</td>
                                    <td>{{ $staffTraining->training_hour }}</td>
                                    <td>{{ $staffTraining->date_start }}</td>
                                    <td>{{ $staffTraining->date_end }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        
    </div>
</div>

<x-flash />

@include('partials.footer')