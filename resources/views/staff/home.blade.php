@include('partials.head')

    <div class="container-fluid">
        <div class="row">

            <!--Dashboard-->
            <div class="col-md-12 fw-bold fs-3">
                Dashboard
            </div>

            <!--success message-->
            @if(session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session()->get('success')}}
            </div>
            @endif
            
            <!--Create card that will display the total of training hour-->
            <div class="col-md-4 mx-3">
                <div class="card my-4 text-center" id="card">
                    <div class="card-body">
                        <h5 class="card-title" id="totalHours">
                            {{App\Http\Controllers\StaffController::getHour(Auth()->user()->staff_id)}}
                        </h5>
                        <p class="card-text">Total hours of learning</p>
                        <a href="/{{ Auth()->user()->position }}/training/list" class="btn btn-primary">Train More!</a>
                    </div>
                </div>
            </div>
        </div>

        <!--chart-->
        <!--performance of overall services in chart-->
        <div class="container-fluid">
            <div class="card text-bg-light mb-3">
                <div class="card-header text-center" id="card">
                    Total Training Hours by Department
                    <div class="card-body">
                        @include('chart')
                    </div>
                </div>
            </div>
        </div>
        
       <!-- Table of enrolled training -->
        <div class="col-md-12">
            <h3 class="mb-1 col-md-12 fw-bold fs-3">Training</h3>
            <div class="card my-4" id="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">Training Code</th>
                                    <th class="text-center">Title</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Enrolled</th> <!-- Add this column -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Tlist as $request)
                                    @if($request->apply_status == 'Approved' || $request->apply_status == 'Pending' || $request->apply_status == 'Rejected')
                                        <tr>
                                            <td class="text-center">{{ $request->training_code }}</td>
                                            <td class="text-center">{{ $request->title }}</td>
                                            <td class="text-center">{{ $request->type }}</td>
                                            <td class="text-center">{{ $request->category }}</td>
                                            <td class="text-center">
                                                @if ($request->apply_status == 'Approved')
                                                    <button class="btn btn-success">{{ $request->apply_status }}</button>
                                                @elseif ($request->apply_status == 'Pending')
                                                    <button class="btn btn-warning">{{ $request->apply_status }}</button>
                                                @elseif ($request->apply_status == 'Rejected')
                                                    <button class="btn btn-danger">{{ $request->apply_status }}</button>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ App\Http\Controllers\StaffController::getEnrolled($request->training_code) }}
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