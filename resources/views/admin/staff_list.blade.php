@include('partials.head')

<div class="container-fluid">

    <!--The header is Training List-->
    <div class="col-md-12 my-4 fw-bold fs-3">
        Staff Dashboard
    </div>
    
    <div class="container-fluid d-flex justify-content-center">
        <div class="card" id="card" style="width:100rem;">                       
            @if (session('success'))
                <div class="alert alert-success m-2">
                    <ul>
                        {{ session('success') }}
                    </ul>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger m-2">
                    <ul>
                        {{ session('error') }}
                    </ul>
                </div>
            @endif

            <div class="d-flex justify-content-between my-2 mx-2">
                <div>
                    @if(auth()->user()->position === 'admin')
                        <a href="{{ route('register') }}" class="btn btn-primary border-3">Add Staff</a>
                        <a href="/password/new" class="btn btn-danger border-3">Reset Password</a>
                    @endif
                    <a href="/staff/deactivate" class="btn btn-danger border-3">Deactivate</a>
                </div>

                <div>
                    <!-- Search input for staff -->
                    <input type="text" id="searchInput" onkeyup="myFunction()" placeholder="Search for name or ID">
                </div>
            </div>

            <div class="col-md-12">
                <div class="mt-3 mx-2">
                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <!-- Header name -->
                                <th class="text-center">Staff ID</th>
                                <th class="text-center">Staff Name</th>
                                <th class="text-center">Total Hours</th>
                            </tr>
                        </thead>
                        <tbody id="staffTable">
                            <!-- Row data -->
                            @foreach ($staffList as $list)
                                <tr>
                                    <td class="text-center">{{ $list->staff_id }}</td>
                                    <td class="text-center">{{ $list->name }}</td>
                                    <td class="text-center">{{ App\Http\Controllers\StaffController::getHour($list->staff_id) }}</td>
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

<script>
    function myFunction() {
        var input, filter, table, tbody, tr, td, i, j, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tbody = table.getElementsByTagName("tbody");
        tr = tbody[0].getElementsByTagName("tr");

        // Loop through all table rows, and hide those that don't match the search query
        for (i = 0; i < tr.length; i++) {
            tr[i].style.display = "none"; // Hide the row by default
            td = tr[i].getElementsByTagName("td");
            for (j = 0; j < td.length; j++) {
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = ""; // Display the row if it matches the search
                        break; // No need to check other cells in this row
                    }
                }
            }
        }
    }
</script>
