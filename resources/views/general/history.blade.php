@include('partials.head')

<!-- Add the year filter dropdown -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 fw-bold fs-3 my-2">
            History
        </div>
    </div>

    <div class="container-fluid" style="width: 95rem;">
        <div class="d-flex justify-content-end my-3">
            <label for="year">Select Year:</label>
            <select name="year" id="yearFilter">
                <option value="All">All</option> <!-- Add this line for "All" option -->
                @for ($i = date('Y'); $i >= 2000; $i--)
                    <option value="{{ $i }}" @if ($i == $selectedYear) selected @endif>{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="card mb-4" id="card">
            <div class="table-responsive my-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">Title</th>
                            <th>Details</th>
                            <th class="text-center">Action</th>
                            <th class="text-center">Updated Date</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        @foreach ($history as $record)
                            <tr id="tr">
                                <td class="text-center">{{ $record->title }}</td>
                                <td>{!! $record->details !!}</td>
                                <td class="text-center">{{ $record->action }}</td>
                                <td class="text-center">{{ $record->date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Get a reference to the year select element
    const yearFilter = document.getElementById('yearFilter');

    // Get a reference to the table body where the data is displayed
    const tableBody = document.querySelector('tbody');

    // Listen for changes to the year select element
    yearFilter.addEventListener('change', function() {
        // Get the selected year
        const selectedYear = yearFilter.value;

        // Loop through each row in the table and hide/show based on the selected year
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach(row => {
            const yearCell = row.querySelector('.text-center:last-child');
            // Extract the year from the date (assuming date is in "YYYY-MM-DD" format)
            const rowYear = yearCell.textContent.split('-')[0];
            if (selectedYear === 'All' || rowYear === selectedYear) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

<x-flash />

@include('partials.footer')