@include('partials.head')
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0" id="card_front">
              <div class="card-body">
                  <img src="{{ asset('images/logo.PNG') }}" alt="Logo" width="180" class="text-nowrap logo-img text-center d-block py-3 w-100">
                <p class="text-center fw-2">Training System</p>
                @if(Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('error') }}
                </div>
                @endif
                
                <form action="{{route('login')}}" method="POST" class="form-signin">
                    
                @csrf
                  <div class="mb-3">
                  <label for="staff_id" class="form-label">Staff ID</label>
                    <input type="text" id="staff_id" name="staff_id" class="form-control my-2" placeholder="Staff ID" required>
                        @error('staff_id')
                        <p class="text-danger text-xs mt-1">{{$message}}</p>
                        @enderror
                  </div>
                  <div class="mb-4">
                  <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control my-2" placeholder="Password" autocomplete="off" required>
                        @error('password')
                        <p class="text-danger text-xs mt-1">{{$message}}</p>
                        @enderror
                  </div>
                    @foreach ($errors-> all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                  
                    <div class="mb-4">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

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

@include('partials.index-footer')