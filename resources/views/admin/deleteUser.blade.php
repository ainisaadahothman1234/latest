@include('partials.header')

<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                    <div class="card mb-0" id="card">
                        <img src="{{ asset('images/logo.PNG') }}" alt="Logo" width="100" class="text-nowrap logo-img text-center d-block py-3 w-100">
                        <h5 class="card-title my-3 mx-3 text-center">User Deactivation</h5>
                        <div class="card-body">

                        <form action="/staff/deactivate" method="post">
                            @csrf
                            <label for="/staff_id">Staff ID</label>
                            <input class="form-control align-content-center my-2" type="text" id="staff_id" name="staff_id"
                                required>

                            <!--button-->
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary my-4" type="submit">Submit</button>
                            </div>

                        </form>

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-flash />

@include('partials.footer')