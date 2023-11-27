<?php
    use App\Http\Controllers\ChartJSController;

    // Create an instance of the ChartJSController
    $chartController = new ChartJSController;

    // Get the chart data
    $chartData = $chartController->index();
    $labels = $chartData['labels'];
    $data = $chartData['data'];
    $staffData = $chartData['staffData'];
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<canvas id="myChart" height="100px"></canvas>

@if (Auth::user()->role === 'hos')
    <!-- Display staff names under services -->
    @foreach ($staffData as $service => $staffNames)
        <h3>{{ $service }}</h3>
        <ul>
            @foreach ($staffNames as $staff)
                <li>{{ $staff->name }}</li>
            @endforeach
        </ul>
    @endforeach
@endif

@if (Auth::user()->role === 'staff')
    <h2>Your Training Data for the Current Year</h2>
    <ul>
        @foreach($staffData as $item)
            <li>{{ $item->month }}: {{ $item->training_hours }} hours</li>
        @endforeach
    </ul>
@endif

<script type="text/javascript">
    var labels = <?= json_encode($labels) ?>;
    var data = <?= json_encode($data) ?>;

    const chartData = {
        labels: labels,
        datasets: [{
            barThickness: 100,
            barPercentage: 0.5,
            label: 'Training Performance',
            backgroundColor: 'rgb(176, 177, 214)',
            borderColor: 'rgb(176, 177, 214)',
            data: data,
        }]
    };

    const chartConfig = {
        type: 'bar',
        data: chartData,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        chartConfig
    );
</script>
</body>
</html>