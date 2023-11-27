<?php
    use App\Http\Controllers\AdminController;

    // Create an instance of the AdminController
    $AdminController = new AdminController;

    // Get the chart data
    $serviceData = $AdminController->displayTableChart($currentMonth,$currentYear);
?>

<div>
    <h5 class="mt-4">Chart Details</h5>
    <small class="text-muted">Based on the departments</small>
    
    <div class="table-responsive mt-4">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Service</th>
                    <th class="text-center">Total Staff</th>
                    <th class="text-center">Staff with 30+ Hours</th>
                </tr>
            </thead>
            <tbody>
                @foreach($serviceData['serviceData'] as $service => $hrs)
                    <tr>
                        <td>{{ $service }}</td>
                        <td class="text-center">{{ $hrs['total_staff'] }}</td>
                        <td class="text-center">{{ $hrs['total_hrs'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
