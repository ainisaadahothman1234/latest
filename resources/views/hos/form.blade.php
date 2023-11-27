@include('partials.head')

<!--main body-->

<div class="container-fluid">
    <div class="row">

        <!--Dashboard-->
        <div class="col-md-12 fw-bold fs-3 my-3 text-center">
            Request Training
        </div>

        <!--upload file & submit-->
        <div class="container-fluid d-flex justify-content-center">
            
            <div class="card my-3" id= "card_front" style="width: 90rem;">

                @if (session('duplicate'))
                    <div class="alert alert-danger mt-2">
                        {{ session('duplicate') }}
                    </div>
                @endif
                    <div class= "mb-1 col-md-12 fw-semibold fs-2 my-3 mx-3">
                        Course Details
                    </div>
                    
                    <div class="card-body">

                        <form action="/external" method="POST">
                            @csrf

                            <!--details-->
                            <div class="form-group row">
                                <div class="mb-3">
                                    
                                    <input type="hidden" id="req_id" name="req_id" value="{{Auth()->user()->staff_id}}" required>
                                    <input type="hidden" id="submit_date" name="submit_date" value="{{now('Asia/Kuala_Lumpur')}}" required>
                                    <input type="hidden" class="form-control" id="type" name="type" value="external" required>
                                    <input type="hidden" class="form-control" id="category" name='category' value="external" required>

                                    <label for="id" class="text-black fw-medium my-2 form-label">COURSE TITLE</label>
                                    <input type="text" class="form-control" id="title" name='title' value="{{ old('title') }}" required>

                                    <label for="id" class="text-black fw-medium my-2 form-label">NAME OF ORGANISER</label>
                                    <input type="text" class="form-control" id="organizer" name='organizer' value="{{ old('organizer') }}" required>

                                    <label for="id" class="text-black fw-medium my-2 form-label">SPONSORED BY</label>
                                    <input type="text" class="form-control" id="sponsor" name='sponsor' value="{{ old('sponsor') }}" required>

                                    <label for="id" class="text-black fw-medium my-2 form-label">COURSE FEE PER PAX</label>
                                    <input type="text" class="form-control" id="price" name='price' value="{{ old('price') }}" required>


                                    <label for="id" class="text-black fw-medium my-2 form-label">START DATE</label>
                                    <input type="date" class="form-control" id="date_start" name='date_start' value="{{ old('date_start') }}" required>
                                    
                                    <label for="id" class="text-black fw-medium my-2 form-label">END DATE</label>
                                    <input type="date" class="form-control" id="date_end" name='date_end' value="{{ old('date_end') }}" required>
                                    <br>

                                    <label for="id" class="text-black fw-medium my-2 form-label">DURATION</label>
                                    <input type="hour" id="duration" name='duration' value="{{ old('duration') }}" required>

                                    <label for="id" class="text-black fw-medium my-2 form-label">TIME START</label>
                                    <input type="time" id="time_start" name='time_start' value="{{ old('time_start') }}" required>

                                    <label for="id" class="text-black fw-medium my-2 form-label">TIME END</label>
                                    <input type="time" id="time_end" name='time_end' value="{{ old('time_end') }}" required>
                                    <br>


                                    <label for="id" class="text-black fw-medium my-2 form-label">VENUE</label>
                                    <input type="text" class="form-control" id="location" name='location' value="{{ old('location') }}" required>
                                    <br>
                                    <label for="id" class="text-black fw-medium my-2 form-label">SPEAKER</label>
                                    <input type="text" class="form-control" id="speaker" name='speaker' value="{{ old('speaker') }}" required>

                                    <label for="id" class="text-black fw-medium my-2 form-label">NUMBER OF
                                        PARTICIPANT</label>
                                    <input type="text" class="form-control" id="quantity" name='quantity' value="{{ old('quantity') }}" required>
                                    <br>

                                    <label for="id" class="text-black fw-medium my-2 form-label">REASON FOR ATTENDING THIS
                                        COURSE / SEMINAR / TRAINING</label>
                                    <input type="text" class="form-control" id="detail" name='detail' value="{{ old('detail') }}" required>

                                    <label for="id" class="text-black fw-medium my-2 form-label">REMARK</label>
                                    <input type="text" class="form-control" id="remark" name='remark' value="{{ old('remark') }}" required>

                
                                    

                                    @foreach ($errors-> all() as $error)
                                    <li>{{$error}}</li>
                                    @endforeach

                                    <div class ="mb-1 col-md-12 my-3">
                                        <input type="checkbox" id="food" name="food" value="1">
                                        <input type="hidden" name="food" value="0">
                                        <label for="vehicle1">REQUEST FOR FOOD</label><br>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary my-4">Apply</button>
                                    </div>
                            </div>
                        </div>
                    </form>
                    <!--Form End-->

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                
                </div>
            </div>
        </div>

    </div>

</div>
</div>