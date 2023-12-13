@include('partials.header')

<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                    <div class="card mb-0" id="card">
                        <img src="{{ asset('images/logo.PNG') }}" alt="Logo" width="100" class="text-nowrap logo-img text-center d-block py-3 w-100">

                        <!--title-->
                        <h5 class="card-title my-3 mx-3 text-center">Staff Registration</h5>

                        <div class="card-body">

                            <form action="/register" method="post">
                                @csrf

                                <!--error message-->
                                <div>
                                    <input id="name" name="name" class="form-control align-content-center my-2" type="text"
                                        placeholder="Name as per IC" required>
                                    @error('name')
                                    <p class="text-danger text-xs mt-1">{{$message}}</p>
                                    @enderror
                                </div>

                                <!--error message if wrong staff id or repeated staff id-->
                                <div>
                                    <input id="staff_id" name="staff_id" class="form-control align-content-center my-2"
                                        type="text" placeholder="Staff ID" required>
                                    @error('staff_id')
                                    <p class="text-danger text-xs mt-1">{{$message}}</p>
                                    @enderror
                                </div>

                                <!--employee category-->
                                <div>
                                    <select id="category" name="category" class="form-select my-2" required>
                                        <option selected>Employee Category</option>
                                        <option value="Senior Management">Senior Management</option>
                                        <option value="Management">Management</option>
                                        <option value="Executive">Executive</option>
                                        <option value="Non-Executive">Non-Executive</option>
                                        <option value="General Clerical">General Clerical</option>
                                        <option value="Contract">Contract</option>
                                    </select>
                                    @error('category')
                                    <p class="text-danger text-xs mt-1">{{$message}}</p>
                                    @enderror
                                </div>

                                <!--employee services-->
                                <div>
                                    <select id="service" name="service" class="form-select my-2" required>
                                        <option selected>Service</option>
                                        <option value="Information Technology">Information Technology</option>
                                        <option value="Nurse">Nurse</option>
                                        <option value="Human Resource">Human Resource</option>
                                        <option value="Consultant">Consultant</option>
                                        <option value="Administrator">Administrator</option>
                                    </select>
                                    @error('service')
                                    <p class="text-danger text-xs mt-1">{{$message}}</p>
                                    @enderror
                                </div>

                                <!--employee division-->
                                <div>
                                    <select id="position" name="position" class="form-select my-2" required>
                                        <option selected>Position</option>
                                        <option value="hos">HOS</option>
                                        <option value="staff">Staff</option>
                                        <option value="CEO">CEO</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                    @error('position')
                                    <p class="text-danger text-xs mt-1">{{$message}}</p>
                                    @enderror
                                </div>

                                <!--employee phone number-->
                                <div>
                                    <input id="no" name="no" class="form-control align-content-center my-2" type="tel" placeholder="Phone Number" required>
                                    @error('no')
                                    <p class="text-danger text-xs mt-1">{{$message}}</p>
                                    @enderror
                                </div>

                                <!--the password is password (in small capital). the type in hidden-->
                                <input id="password" name="password" class="form-control align-content-center my-2" type="hidden" value="password" required>

                                <!--button-->
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary" type="submit">Add</button>
                                </div>

                                <!--success message-->
                                @if(session('success'))
                                    <div class="alert alert-success my-2">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <!--error message-->
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-flash />

@include('partials.footer')

