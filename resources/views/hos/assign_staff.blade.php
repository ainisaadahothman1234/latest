@include('partials.head')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 fw-bold fs-3 my-2">
            Assign Training
        </div>

        <div class="container-fluid d-flex justify-content-center">
            <div class="card my-3" id="card" style="width: 80rem;">
            @if (session('error'))
                <div class="alert alert-danger m-2">
                    <ul>
                        {{ session('error') }}
                    </ul>
                </div>
                @endif
                    <div class="card-body">
                        <form
                            action="<?php echo isset($ETraining['req_id']) ? '/external/assign/' . $ETraining['req_id'] : '/' . auth()->user()->position . '/assign/' . $ETraining; ?>"
                            method="post" class="p-3" id="assignTrainingForm">
                
                            @csrf
                
                            <input type="hidden" name="Etraining" id="Etraining" value="{{ json_encode($ETraining) }}">
                
                            <div class="col-md-12 my-2 fw-semibold">
                                <!--Assign To:
                                <div class="form-check my-2 form-check-inline">
                                    <input class="form-check-input staffCheckbox" type="checkbox" id="selectAll" name="selectAll" value="All-Staff">
                                    <label class="fw-semibold form-check-label" for="selectAll">All</label>
                                </div>-->
                
                                <div class="table">
                                    <table class="table">
                                        <thead class="text-sm fw-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Staff ID</th>
                                                <th>Staff Name</th>
                                                <th>Total Hours</th>
                                                <th>Select</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($staffInService as $id => $staff)
                                            <tr>
                                                <td>{{ $id + 1 }}</td>
                                                <td>{{ $staff->staff_id }}</td>
                                                <td>{{ $staff->name }}</td>
                                                <td>{{ App\Http\Controllers\StaffController::getHour($staff->staff_id) }}</td>
                                                <td><input class="form-check-input" type="checkbox" name="selectedStaff[]" id="selectedStaff[]" value="{{ $staff->staff_id }}"></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary my-4" onclick="validateForm()">Assign</button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>

<script>

    function validateForm() {
        // Get all the checkboxes with name "selectedStaff"
        const checkboxes = document.querySelectorAll('input[name="selectedStaff[]"]');
        
        // Check if at least one checkbox is checked
        const atLeastOneChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

        if (!atLeastOneChecked) {
            // If no checkbox is checked, show an alert or message
            alert('Please select at least one user.');
        } else {
            // If at least one checkbox is checked, submit the form
            document.getElementById('assignTrainingForm').submit();
        }
    }

    // Add event listener to the "Select All" checkbox
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="selectedStaff[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

</script>

<x-flash />

@include('partials.footer')