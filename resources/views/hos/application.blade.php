@include('partials.head')
<div class="container-fluid">
    <!--title-->
    <div class="col-md-12 fw-bold fs-3 my-2">
        Course Application
    </div>

    <div class="container-fluid" style="width: 95rem;">
        <div class="card my-3" id="card">
            <div class="card-body">
                <table class="table mx-3">
                    <thead>
                        <tr>
                            <th>Staff Name</th>
                            <th>Course Title</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staff as $notification)
                            @if ($notification->apply_status == 'Pending')<!--when the application status is pending, it display in the table-->
                                <tr>
                                    <td>{{ $notification->name }}</td><!--staff name-->
                                    <td>
                                        @php
                                            $titleArray = App\Http\Controllers\NotificationController::showTitle($notification->training_code);
                                        @endphp <!--the training title applied-->
                                        
                                        <a href="/hos/training/{{ $notification->training_code }}"> {{ $titleArray[0] }}</a> <!--training code-->
                                    </td>
                                    <td class="text-center">
                                        <!--hos can select either approve or reject-->
                                        <form class="d-inline" id="approveForm" action="{{ route('notification.approve') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="staff_id" value="{{ $notification->staff_id }}">
                                            <input type="hidden" name="training_code" value="{{ $notification->training_code }}">
                                            <button type="submit" class="btn btn-success">Approve</button>
                                        </form>

                                        <form class="d-inline" id="deleteForm" action="{{ route('notification.delete') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="staff_id" value="{{ $notification->staff_id }}">
                                            <input type="hidden" name="training_code" value="{{ $notification->training_code }}">
                                            <button type="submit" class="btn btn-danger">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<x-flash />

@include('partials.footer')
