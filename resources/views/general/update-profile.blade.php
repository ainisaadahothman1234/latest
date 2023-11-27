@include('partials.head')

<div class="d-flex align-items-center justify-content-center" style="height: 550px;">
  <div class="card my-3" style="width: 35rem;">
    <div class="card-body">
      <h5 class="card-title my-3 mx-3 text-center">Update Profile</h5>

      <input class="form-control align-content-center my-2" type="text" placeholder="Name as per IC">
      <input class="form-control align-content-center my-2" type="text" placeholder="Staff ID">
      <input class="form-control align-content-center my-2" type="email" placeholder="E-mail address">

      <select class="form-select my-2">
        <option selected>Employee Category</option>
        <option value="1">Management</option>
        <option value="2">Executive</option>
        <option value="3">Non-Executive</option>
      </select>

      <select class="form-select my-2">
        <option selected>Staff Division</option>
        <option value="1">Allied Health</option>
        <option value="2">Medical Officer</option>
        <option value="3">Nursing</option>
        <option value="4">Support Service</option>
        <option value="5">Specialist Consultant</option>
      </select>

      <input class="form-control align-content-center my-2" type="tel" placeholder="Phone Number">

      <div class="d-grid gap-2">
        <button class="btn btn-primary my-4" type="Submit">Submit</button>
      </div>
      <!--Back to homepage-->
      <div class="text-end">
        <a href="/" class="text-decoration-none text-dark fw-medium">
          <i class="bi bi-arrow-left"></i>
          Back to homepage
        </a>
      </div>
    </div>
  </div>
</div>

@include('partials.index-footer')