@include('partials.head')

<div class="container-fluid">
    <!-- Header -->
    <div class="col-md-12 my-4 fw-bold fs-3 text-center">
        Attendance
    </div>

    <!-- Search Input -->
    <div class="container d-flex justify-content-center mb-4">
        <div class="input-group">
            <input type="text" class="form-control" id="footerCourse" onkeyup="myFunction(event)" placeholder="Search for staff names...">
            <button class="btn btn-primary" type="button">Search</button>
        </div>
    </div>

    <!-- Table of enrolled training -->
    <div class="container d-flex justify-content-center">
        <div class="card" style="width: 100%">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr class="text-center">
                                <th>Staff ID</th>
                                <th>Staff Name</th>
                                <th>Total Hours</th>
                                <th>Service</th>
                                <th>Training Hours</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                            @endif
                            @foreach ($attendanceList as $list)
                            <form action="/attendance/attend/{{$list->staff_id}}" method="POST">
                                @csrf
                                <tr id="tr">
                                    <td>{{ $list->staff_id }}</td>
                                    <td>{{ $list->name }}</td>
                                    <td>{{ App\Http\Controllers\StaffController::getHour($list->staff_id) }}</td>
                                    <td>{{ $list->service }}</td>
                                    <td>
                                        <input type="text" class="form-control" id="training_hrs"
                                            name="training_hrs_{{$list->staff_id}}"
                                            value="{{ number_format(App\Models\Training::where('code', $Tcode)->first()->duration, 1) }}"
                                            required>
                                        @error("training_hrs_{$list->staff_id}")
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <input type="hidden" class="form-control" id="training_code_{{$list->staff_id}}"
                                            name="training_code_{{$list->staff_id}}" value="{{ $Tcode }}" required>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">

                                            <select class="form-control" id="attend_type"
                                                name="attend_type_{{ $list->staff_id }}">
                                                <option value='null'>- Attendance type -</option>
                                                <option value="partials">Partials</option>
                                                <option value="full">Full</option>
                                            </select>

                                            <button type="submit" name="action" value="attend"
                                                class="btn btn-success">Attend</button>
                                            <button type="submit" name="action" value="incompleted"
                                                class="btn btn-danger">Incompleted</button>
                                        </div>
                                    </td>
                                </tr>
                            </form>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Attended Staff title -->
    <div class="col-md-12 my-4 fw-bold fs-3 text-center">
        Attended Staff
    </div>

    <!-- Attended Staff -->
    <div class="container d-flex justify-content-center">
        <div class="card" style="width: 100%">
            <div class="card-body">
                <table class="table table-striped" id="myTable">
                    <thead>
                        <tr class="text-center">
                            <th>Staff ID</th>
                            <th>Staff Name</th>
                            <th>Total Hours</th>
                            <th>Service</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-center" id="tbody">
                        @foreach ($attendStaff as $list)
                        <tr id="tr">
                            <td>{{ $list->staff_id }}</td>
                            <td>{{ $list->name }}</td>
                            <td>{{ App\Http\Controllers\StaffController::getHour($list->staff_id) }}</td>
                            <td>{{ $list->service }}</td>
                            <td>{{$list->apply_status}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<x-flash />

<!--footer box-->
<script>
    function myFunction(event) {
    if (event.key === "Enter") {
        event.preventDefault();
    }

    // Declare variables
    var input, filter, table, tbody, tr, td, i, j, txtValue;
    input = document.getElementById("footerCourse");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tbody = table.getElementsByTagName("tbody");
    tr = tbody[0].getElementsByTagName("tr");

    // Loop through all table rows, and hide those that don't match the footer query
    for (i = 0; i < tr.length; i++) {
        tr[i].style.display = "none"; // Hide the row by default
        td = tr[i].getElementsByTagName("td");
        for (j = 0; j < td.length; j++) {
        if (td[j]) {
            txtValue = td[j].textContent || td[j].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = ""; // Display the row if it matches the footer
            break; // No need to check other cells in this row
            }
        }
        }
    }
    }
</script>

