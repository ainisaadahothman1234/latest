@include('partials.head')

<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
  <div class="col-md-12 fw-bold fs-3 my-2">
  </div>
  <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
      <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6 col-xl-3"> <!-- Increase the column size to col-xl-6 -->
          <div class="card mb-0">
            <div class="card-body">
              <img src="{{ asset('images/logo.PNG') }}" alt="Logo" width="100" class="text-nowrap logo-img text-center d-block py-3 w-100">
              
              @if(Auth()->user()->admin)
        <h5 class="card-title my-3 mx-3 text-center">Report</h5>
    @else
        <h5 class="card-title my-3 mx-3 text-center">Your Report</h5>
    @endif
              

              <form action="{{ route('generateReport') }}" method="post">
                @csrf
                <div class="mb-3 my-3 d-flex justify-content-between"> <!-- Wrap the label and select in a div with justify-content-between -->
                  <div>
                    <label for="start_month">Select Start Month:</label>
                    <select name="start_month" id="start_month">
                      @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                      @endfor
                    </select>
                  </div>

                  <div>
                    <label for="end_month">Select End Month:</label>
                    <select name="end_month" id="end_month">
                      @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                      @endfor
                    </select>
                  </div>

                  <div>
                    <label for="year">Select Year:</label>
                    <select name="year" id="year">
                      @for ($i = date('Y'); $i >= 2000; $i--)
                        <option value="{{ $i }}">{{ $i }}</option>
                      @endfor
                    </select>
                  </div>
                </div>

                <div class="d-flex justify-content-end">
                  <button type="submit" class="btn btn-primary">Download</button> <!-- Add Bootstrap button class -->
                </div>

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
