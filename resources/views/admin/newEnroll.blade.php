<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>New Enrollment</title>
        <!-- Add Bootstrap CSS CDN link here -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    </head>
    <body>

    <div class="container">
        
        <!--title-->
        <h1 class="mt-5">Course Enrollment</h1>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover mt-3">
                <thead>
                    <tr>
                        <th>Staff Id</th>
                        <th>Course Title</th>
                    </tr>
                </thead>
                <!--notification to admin when staff application got approved by hos-->
                <tbody>
                    @foreach ($staffApplications as $notification)
                        @if($notification->apply_status == 'Approved')
                        <tr>
                            <td>{{ $notification->staff_id }}</td>
                            <td>
                                @php
                                    $titleArray = App\Http\Controllers\NotificationController::showTitle($notification->training_code);
                                @endphp
                                {{ $titleArray[0] }}
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    </body>
</html>
