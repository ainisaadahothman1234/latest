@include('partials.head')


<div class="container-fluid">

    <!--start total hours-->
    <div class="row">
        <!--Dashboard-->
        <div class="col-md-12 fw-bold fs-3 my-2">
            Dashboard
        </div>
        
        <!--success message-->
        @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('success')}}
        </div>
        @endif
        
        <!--Create card that will display the total of training hour-->
        <div class="row">


            <div class="col-md-4">
                <div class="card my-4 text-center" id="card">
                    <div class="card-body">
                        <h5 class="card-title" id="totalHours">
                            {{ App\Http\Controllers\StaffController::getHour(Auth()->user()->staff_id) }}
                        </h5>
                        <p class="card-text">Your total hours of learning</p>
                        <a href="/{{ Auth()->user()->position }}/training/list" class="btn btn-primary">Train More!</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card my-4 text-center" id="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            {{ App\Http\Controllers\StaffController::getPercentage(Auth()->user()->staff_id) }}
                        </h5>
                        <p class="card-text">Your completion of 30 hours training</p>
                        <a href="/reports" class="btn btn-primary">Report</a>
                    </div>
                </div>
            </div>    

            <div class="col-md-4">
                <div class="card my-4 text-center" id="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            {{ App\Http\Controllers\StaffController::getStaff(Auth()->user()->staff_id) }}
                        </h5>
                        <p class="card-text">Your number of Staff</p>
                        <a href="/lists" class="btn btn-primary">Staff</a>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!--end total hours-->

    <!-- Charts section -->
    <div class="row">
        <div class="col-md-12">
            <div class="card my-3" id="card">
                <h3 class="mb-1 col-md-12 fw-bold fs-3 my-3 mx-3">Charts</h3>
                <div class="card-body">
                    @include('chart')
                </div>
            </div>
        </div>
    </div>
    <!-- End Charts section -->

    <div class="card my-3" id="card">
            <h3 class="mb-1 col-md-12 fw-bold fs-3 my-3 mx-3">Current Training</h3>
        <div class="card-body">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 15%;">Training Code</th>
                            <th style="width: 25%;">Title</th>
                            <th style="width: 15%;">Type</th>
                            <th style="width: 20%;">Category</th>
                            <th style="width: 25%;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Tlist as $request)
                            @if($request->apply_status == 'Approved' || $request->apply_status == 'Pending')
                            <tr>
                                <td>{{ $request->training_code }}</td>
                                <td>{{ $request->title }}</td>
                                <td>{{ $request->type }}</td>
                                <td>{{ $request->category }}</td>
                                <td>
                                    @if ($request->apply_status == 'Approved')
                                        <button class="btn btn-success">{{ $request->apply_status }}</button>
                                    @elseif ($request->apply_status == 'Pending')
                                        <button class="btn btn-warning">{{ $request->apply_status }}</button>
                                    @elseif ($request->apply_status == 'Rejected')
                                        <button class="btn btn-danger">{{ $request->apply_status }}</button>
                                    @endif
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>

    <!--start card for requested training-->
    <div class="card my-3" id="card">
        <h3 class="mb-1 col-md-12 fw-bold fs-3 my-3 mx-3">Requested Training</h3>
        <div class="card-body">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 12%;">Title</th>
                            <th style="width: 10%;">Type</th>
                            <th style="width: 10%;">Category</th>
                            <th style="width: 12%;">Speaker</th>
                            <th style="width: 10%;">Date</th>
                            <th style="width: 8%;">Duration</th>
                            <th style="width: 12%;">Location</th>
                            <th style="width: 8%;">Price</th>
                            <th style="width: 10%;">Detail</th>
                            <th style="width: 8%;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $Elist = App\Models\Training::External(); ?>
                        @foreach ($Elist as $external)
                            @if (
                                    ($external->type == 'External' && $external->req_id == Auth()->user()->staff_id) ||
                                    in_array($external->approve_ceo, ['Pending', 'Approved', 'Rejected'])
                                )
                                <tr>
                                    <td>{{ $external->title }}</td>
                                    <td>{{ $external->type }}</td>
                                    <td>{{ $external->category }}</td>
                                    <td>{{ $external->speaker }}</td>
                                    <td>{{ $external->date_start }}</td>
                                    <td>{{ $external->duration }}</td>
                                    <td>{{ $external->location }}</td>
                                    <td>{{ $external->price }}</td>
                                    <td>{{ $external->detail }}</td>
                                    <td>
                                        @if ($external->approve_ceo == 'Approved')
                                            <button class="btn btn-success">{{ $external->approve_ceo }}</button>
                                        @elseif ($external->approve_ceo == 'Pending')
                                            <button class="btn btn-warning">{{ $external->approve_ceo }}</button>
                                        @elseif ($external->approve_ceo == 'Rejected')
                                            <button class="btn btn-danger">{{ $external->approve_ceo }}</button>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
    <!--end card for requested training-->
</div>

<x-flash />

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