@include('partials.head')

@if(!url()->current()=='http://127.0.0.1:8000/assign')<!--only use to test assign staff-->
    @include('partials.sidebar')
    <main>
@endif

    <div class="container-fluid my-4">
        <div class="row">

        <!--title-->
            <div class="mb-3 col-md-12 fw-bold fs-3">
                Training
            </div>
            
            <div class="container-fluid d-flex justify-content-center my-2">
                <div class="card" id="card_shadow" style="width: 110rem;">
                <!--error message-->
                @if (session('error'))
                    <div class="alert alert-danger m-2">
                        <ul>
                            {{ session('error') }}
                        </ul>
                    </div>
                    @endif
                    <div class="table p-3">
                        
                        <div class="container-fluid d-flex justify-content-end"><!--search box-->
                            <input type="text" id="searchCourse" onkeyup="myFunction(event)" placeholder="Search">
                        </div>

                        <table class="table my-2" id="courseTable">
                            <thead>
                                <tr>
                                    <th>Training Code</th>
                                    <th>Title</th>
                                    <th>Training Type</th>
                                    <th>Training Category</th>
                                    <th>Venue</th>
                                    <th>Date Start</th>
                                    <th>Date End</th>
                                    <th>Time Start</th>
                                    <th>Time End</th>
                                    <th class="text-center">Enrolled</th>
                                    <th class="text-center">Open</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Tlist as $list)
                                <!--show list of training when the quantity is not same with the enroll, when the training is not external and the status is upcoming-->
                                    @if ($list->quantity != \App\Http\Controllers\StaffController::getEnrolled($list->code) && $list->type != 'external' && $list->status == 'Upcoming')
                                        <tr>
                                            <td>{{ $list->code }}</td>
                                            <!--@if ($previousPage === Auth()->user()->position.'/training/list')
                                                <td><a href="/{{ Auth()->user()->position }}/apply/{{ $list->code }}">{{ $list->title }}</a></td>
                                            @else
                                                <td><a href="/assign/{{$list->code}}">{{ $list->title }}</a></td>
                                            @endif-->
                                            <!--pop up error (the function available in the script at line 126)-->
                                            @if ($previousPage === Auth()->user()->position.'/training/list')
                                                <td><a href="#" onclick="confirmApply('{{ $list->code }}', '{{ $list->title }}')">{{ $list->title }}</a></td>
                                            @else
                                                <td><a href="#" onclick="confirmAssign('{{ $list->code }}', '{{ $list->title }}')">{{ $list->title }}</a></td>
                                            @endif

                                            <td>{{ $list->type }}</td>
                                            <td>{{$list->category}}</td>
                                            <td>{{$list->location}}</td>
                                            <td>{{$list->date_start}}</td>
                                            <td>{{$list->date_end}}</td>
                                            <td>{{$list->time_start}}</td>
                                            <td>{{$list->time_end}}</td>
                                            <td class="text-center">{{ \App\Http\Controllers\StaffController::getEnrolled($list->code) }}</td>
                                            <td class="text-center">{{$list->quantity}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(!url()->current()=='http://127.0.0.1:8000/assign')
</main>
@endif

<x-flash />

@include('partials.footer')

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

<!--pop up error when user want to apply or want to assign staff-->
<script>
    function confirmApply(trainingCode, trainingTitle) {
        if (confirm(`Are you sure you want to apply for '${trainingTitle}' training?`)) {
            window.location.href = `/{{ Auth()->user()->position }}/apply/${trainingCode}`;
        }
    }

    function confirmAssign(trainingCode, trainingTitle) {
        if (confirm(`Are you sure you want to assign '${trainingTitle}' training?`)) {
            window.location.href = `/assign/${trainingCode}`;
        }
    }
</script>
