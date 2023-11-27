@include('partials.head')

<div class="d-flex align-items-center justify-content-center" style="height: 90vh;">
  <form action="/profile" method="POST">
    @csrf
    <div class="card my-3" id="card_front" style="width: 35rem;">
      <div class="card-body">
        <h5 class="card-title my-3 mx-3 text-center">Profile</h5>
        <input class="form-control align-content-center my-2" type="text" name="name" value="{{ $staffUpdate->name }}" readonly>
        <input class="form-control align-content-center my-2" type="text" name="staff_id" value="{{ $staffUpdate->staff_id }}" readonly>
        <input class="form-control align-content-center my-2" type="text" name="category" value="{{ $staffUpdate->category }}" readonly>
        <input class="form-control align-content-center my-2" type="text" name="service" value="{{ $staffUpdate->service }}" readonly>
        <input class="form-control align-content-center my-2" type="email" name="email" value="{{ $staffUpdate->email }}">
        <input class="form-control align-content-center my-2" type="tel" name="no" value="{{ $staffUpdate->no }}">

        @foreach ($errors-> all() as $error)
        <li>{{$error}}</li>
        @endforeach

        <div class="d-grid gap-2">
          <button id="option" name="option" class="btn btn-primary" type="submit" value="update">Update</button>
        </div>
      </div>
    </div>
  </form>
</div>

<x-flash />

@include('partials.footer')