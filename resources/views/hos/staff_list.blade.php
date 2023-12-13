@include('partials.head')

<div class="container-fluid">
    <div class="row">

        <div class="col-md-12 my-4 fw-bold fs-3">
            Staff Dashboard
        </div>

            <div class="container-fluid d-flex justify-content-center my-2">
                <div class="card" id="card_shadow" style="width: 110rem;">
                    <div class="table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Staff ID</th>
                                    <th>Staff Name</th>
                                    <th class="text-center">Total Hours</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($staffMembers as $id => $staffMember)
                                <tr>
                                    <td class="text-center">{{ $id + 1 }}</td>
                                    <td class="text-center">{{ $staffMember->staff_id }}</td>
                                    <td>{{ $staffMember->name }}</td>
                                    <td class="text-center">
                                        <!-- Link to training details page -->
                                        <a href="{{ route('hos.staff_training', ['staff_id' => $staffMember->staff_id]) }}">
                                            {{ App\Http\Controllers\StaffController::getHour($staffMember->staff_id) }}
                                        </a>
                                    </td>
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
