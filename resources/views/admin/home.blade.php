@include('partials.head')

    <div class="container-fluid">
        <div class="row">

            <!--Dashboard-->
            <div class="col-md-12 fw-bold fs-3 my-2">
                Admin Dashboard
            </div>

            <!--message-->
                @if(session('success'))
                    <div class="alert alert-success m-2">
                        {{ session('success') }}
                    </div>
                @endif

                <!--select year and month-->
                <form method="GET" action="/admin/home">
                    @csrf
                    <label for="filter_month">Select Month:</label>
                    <select name="filter_month" id="filter_month">
                        @php
                        $currentMonth = date('m');
                        $months = [
                            '01' => 'January',
                            '02' => 'February',
                            '03' => 'March',
                            '04' => 'April',
                            '05' => 'May',
                            '06' => 'June',
                            '07' => 'July',
                            '08' => 'August',
                            '09' => 'September',
                            '10' => 'October',
                            '11' => 'November',
                            '12' => 'December',
                        ];
                        @endphp
                        @foreach ($months as $monthValue => $monthName)
                        <option value="{{ $monthValue }}" {{ $filterMonth == $monthValue ? 'selected' : '' }}>
                            {{ $monthName }}
                        </option>
                        @endforeach
                    </select>

                    <label for="filter_year">Select Year:</label>
                    <select name="filter_year" id="filter_year">
                        @php
                        $currentYear = date('Y');
                        for ($year = $currentYear; $year >= ($currentYear - 15); $year--) {
                            echo "<option value=\"$year\" {{ $filterYear == $year ? 'selected' : '' }}>$year</option>";
                        }
                        @endphp
                    </select>

                    <!--<button type="submit">Apply Filter</button>-->
                    <button type="submit" name="reset_filter" class="btn btn-secondary">Reset</button>
                </form>
      
                <!--card to display data that related to the training system-->
                <div class="row" id="dashboardContainer">
                    <div class="col-md-4">
                        <div class="card my-4 text-center" id="totalTrainingCard">
                            <div class="card-body">
                                <h5 class="card-title" id="totalTraining">{{ $countTraining }}</h5>
                                <p>Total Training</p>
                                <a href="/training/lists" class="btn btn-primary">Training List</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card my-4 text-center" id="totalStaffCard">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title" id="totalStaff">{{ $userCount }}</h5>
                                        <p>Staffs</p>
                                        <a href="/staff/lists" class="btn btn-primary">Staff</a>
                                    </div>
                                    <div class="col">
                                        <h5 class="card-title" id="percentage">
                                            {{ $percentage }}
                                        </h5>
                                        <p>Percentage Achieved 30 Hours Training</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card my-4 text-center" id="reqTrainingCard">
                            <div class="card-body">
                                <h5 class="card-title" id="reqTraining">{{$reqTraining}}</h5>
                                <p>Requested Training</p>
                                <a href="/training/req" class="btn btn-primary">Requested Training</a>
                            </div>
                        </div>
                    </div>
                </div>

            <!--chart-->
            <!--performance of overall services in chart-->
            <div class="container-fluid" id="chartContainer">
                <div class="card text-bg-light mb-3">
                    <div class="card-header text-center" id="card">
                        Total Training Hours by Department
                        <div class="card-body">
                            @include('chart')
                        </div>
                    </div>
                </div>
            </div>

            <!--table-->
            <!--performance of overall services in table-->
            <div class="container-fluid">
                <div class="card text-bg-light mb-3">
                    <div class="card-header" id="card">
                        <div class="card-body">
                            @include('tableChart')
                        </div>
                    </div>
                </div>
            </div>
       
            <x-flash />

    <!-- JavaScript -->

    <script>
        function updateCardData(totalTraining, totalStaff, percentage, reqTraining) {
                    // Update the card elements with new data
                    document.getElementById('totalTraining').textContent = totalTraining;
                    document.getElementById('totalStaff').textContent = totalStaff;
                    document.getElementById('percentage').textContent = percentage;
                    document.getElementById('reqTraining').textContent = reqTraining;
                    }

        document.addEventListener('DOMContentLoaded', function() {
            
            const filterMonthSelect = document.getElementById('filter_month');
            const filterYearSelect = document.getElementById('filter_year');
            const applyFilterButton = document.getElementById('apply_filter_button');

            // Function to update the chart with new data
            function updateChartWithNewData(labels, data) {
                myChart.data.labels = labels;
                myChart.data.datasets[0].data = data;
                myChart.update();
            }

            // Function to handle select changes and update the chart
            // Inside the 'handleSelectChange' function
        function handleSelectChange() {
            const filterMonth = filterMonthSelect.value;
            const filterYear = filterYearSelect.value;

            // Make an AJAX request to get the updated chart data
            $.ajax({
                url: '{{ route('admin.getChartData') }}',
                type: 'GET',
                data: {
                    filter_month: filterMonth,
                    filter_year: filterYear
                },
                success: function(chartData) {
                    console.log('Chart data received:', chartData); // Log the chart data received

                    // Update the chart with new data
                    updateChartWithNewData(chartData.labels, chartData.data);
                },
                error: function() {
                    alert('Failed to fetch updated chart data.');
                }
            });

            // Make another AJAX request to get the updated card data
            $.ajax({
                url: '/admin/getCardData', // Adjust the URL to match the card data route
                type: 'GET',
                data: {
                    filter_month: filterMonth,
                    filter_year: filterYear
                },
                success: function(cardData) {
                    console.log('Card data received:', cardData); // Log the card data received

                    // Update the card elements with new data
                    updateCardData(cardData.totalTraining, cardData.totalStaff, cardData.percentage, cardData.reqTraining);
                },
                error: function() {
                    alert('Failed to fetch updated card data.');
                }
            });
        }

            // Add event listeners to the select elements
            filterMonthSelect.addEventListener('change', handleSelectChange);
            filterYearSelect.addEventListener('change', handleSelectChange);

            // Add event listener for the "Apply Filter" button
            applyFilterButton.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the form submission
                handleSelectChange(); // Call the select change handler to update the chart
            });

        });
    </script>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterMonthSelect = document.getElementById('filter_month');
            const filterYearSelect = document.getElementById('filter_year');
            
            function handleSelectChange() {
                const filterMonth = filterMonthSelect.value;
                const filterYear = filterYearSelect.value;

                // Make an AJAX request to get the updated chart data
                $.ajax({
                    url: '{{ route('admin.getChartData') }}',
                    type: 'GET',
                    data: {
                        filter_month: filterMonth,
                        filter_year: filterYear
                    },
                    success: function(chartData) {
                        console.log('Chart data received:', chartData); // Log the chart data received

                        // Update the chart with new data
                        updateChartWithNewData(chartData.labels, chartData.data);
                    },
                    error: function() {
                        alert('Failed to fetch updated chart data.');
                    }
                });
            }

            // Add event listeners to the select elements
            filterMonthSelect.addEventListener('change', handleSelectChange);
            filterYearSelect.addEventListener('change', handleSelectChange);
        });
    </script>

    <!-- Footer -->
    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="copyright-text text-center text-light">
                        <p>© KPJ Rawang Specialist Hospital IT Services. All Rights Reserved.</p>
                        <p>Crafted by KPJ Rawang Specialist Hospital IT Services</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

@include('partials.footer')