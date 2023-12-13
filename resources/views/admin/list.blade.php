@include('partials.head')

<div class="container-fluid">

    <!--title/header-->
    <div class="col-md-12 my-4 fw-bold fs-3">
        Training List
    </div>

    <div class="container-fluid d-flex justify-content-center mb-3">
         <!--success message-->
        <div class="card" id="card" style="width:100rem;">
            @if(session('success'))
                  <div class="alert alert-success m-2">
                    {{ session('success') }}
                </div>
            @endif

         <!--Add training button-->
        <div class="d-flex justify-content-between">
            <div class="mb-3 mx-3 my-3">
                <a href="/training/add" class="btn btn-primary"><i class="bi bi-plus"></i>Add Training</a>
            </div>
            <!--search box-->
            <div class="mb-3 mx-3 my-3">
                <input type="text" id="searchCourse" onkeyup="myFunction(event)" placeholder="Search">
            </div>
        </div>

        <!--list of training-->
            <div class="card-body">
                <table class="table table-striped" id="courseTable">
                    <!--column name-->
                    <thead>
                        <tr>
                            <th scope="col" class="sortable">Training Code <i class="bi bi-arrow-up-short"></i></th>
                            <th scope="col" class="sortable">Title <i class="bi bi-arrow-up-short"></i></th>
                            <th scope="col" class="sortable">Training Type <i class="bi bi-arrow-up-short"></i></th>
                            <th scope="col" class="text-center">Seat open</th>
                            <th scope="col" class="text-center">Seat enrolled</th>
                            <th scope="col" class="sortable text-center">Status <i class="bi bi-arrow-up-short"></i></th>
                        </tr>
                    </thead>

                    <!--data for each column-->
                    <tbody id="tbody">
                        @foreach ($Tadd as $add)
                           
                                <tr class="table-row-striped" id="tr">
                                    <!--training code-->
                                    <td>
                                        <h6 class="fw-semibold mb-1">{{$add->code}}</h6>
                                    </td>

                                    <!--training title-->
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="/training/{{ $add->code }}">{{ $add->title }}</a>
                                        </div>
                                    </td>

                                    <!--training type-->
                                    <td>
                                        <p class="mb-0 fw-normal">{{$add->type}}</p>
                                    </td>

                                    <!--quantity/seat opened-->
                                    <td>
                                        <h6 class="fw-semibold mb-0 text-center">{{$add->quantity}}</h6>
                                    </td>
                                    
                                    <!--number of enrolled-->
                                    <td class="text-center">{{ \App\Http\Controllers\StaffController::getEnrolled($add->code) }}</td>

                                    <!--training status-->
                                    <td class="text-center">
                                        @if ($add->status == 'Upcoming')
                                            <button class="btn btn-warning">{{ $add->status }}</button>
                                        @elseif ($add->status == 'Pending')
                                            <button class="btn btn-secondary">{{ $add->status }}</button>
                                        @elseif ($add->status === 'Approved')
                                        <h6 class="fw-semibold mb-0">
                                            <button class="btn btn-warning">{{ $add->status === 'Approved' ? 'Upcoming' : $add->status }}</button>
                                        </h6>
                                        @elseif ($add->status == 'Completed')
                                            <button class="btn btn-success">{{ $add->status }}</button>
                                        @elseif ($add->status == 'Rejected')
                                            <button class="btn btn-danger">{{ $add->status }}</button>
                                        @endif
                                    </td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<x-flash />

@include('partials.footer')

<!--arrow up and down-->

<!-- Add jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- JavaScript for sorting -->
<script>
    $(document).ready(function () {
        // Function to toggle the sorting arrows
        function toggleSortArrow(header) {
            const arrowUp = '<i class="bi bi-arrow-up-short"></i>';
            const arrowDown = '<i class="bi bi-arrow-down-short"></i>';

            // Remove any existing sorting arrows
            header.find('.bi-arrow-up-short, .bi-arrow-down-short').remove();

            // Add the appropriate sorting arrow
            if (header.hasClass('asc')) {
                header.append(arrowUp);
            } else if (header.hasClass('desc')) {
                header.append(arrowDown);
            }
        }

        // Function to handle table header clicks
        function handleHeaderClick(event) {
            const header = $(event.currentTarget);
            const table = header.closest('table');
            const columnIndex = header.index();
            const rows = table.find('tbody tr');

            // Toggle sorting classes
            if (header.hasClass('asc')) {
                header.removeClass('asc').addClass('desc');
            } else if (header.hasClass('desc')) {
                header.removeClass('desc').addClass('asc');
            } else {
                // Default to ascending order
                header.addClass('asc');
            }

            // Sort the table rows based on the column index and sorting order
            rows.sort(function (a, b) {
                const aValue = $(a).find('td').eq(columnIndex).text().trim();
                const bValue = $(b).find('td').eq(columnIndex).text().trim();

                if (header.hasClass('asc')) {
                    return aValue.localeCompare(bValue);
                } else {
                    return bValue.localeCompare(aValue);
                }
            });

            // Append the sorted rows back to the table
            table.find('tbody').empty().append(rows);

            // Toggle the sorting arrow for the clicked header
            toggleSortArrow(header);
        }

        // Attach click event handlers to sortable table headers for sorting
        $('.sortable').on('click', handleHeaderClick);
    });
</script>

<!--search box-->
<script>
    function myFunction(event) {
    if (event.key === "Enter") {
        event.preventDefault();
    }

    // Declare variables
    var input, filter, table, tbody, tr, td, i, j, txtValue;
    input = document.getElementById("searchCourse");
    filter = input.value.toUpperCase();
    table = document.getElementById("courseTable");
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

