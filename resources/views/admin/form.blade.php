@include('partials.head')

    <div class="container-fluid d-flex justify-content-center">
        <div class="card my-3" id="card" style="width: 80rem;">
            <div class="card-body">

                <form action="/training/add" method="POST">
                    @csrf
                    <!--details-->
                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="title" class="text-black fw-medium my-2 form-label">Training Name</label>
                            <input type="text" class="form-control" name="title" value="{{old('title')}}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="code" class="text-black fw-medium my-2 form-label">Training Code</label>
                            <input type="text" class="form-control" name="code" value="{{old('code')}}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="type" class="text-black fw-medium my-2 form-label">Training Type</label>
                            <select class="form-control" id="type" name='type' required>
                                <option>Select</option>
                                <option value="In-house">In-House</option>
                                <option value="Local Public">Local Public</option>
                                <option value="Overseas">Overseas</option>
                                <option value="Online Training">Online Training</option>
                                <option value="E-Learning">E-Learning</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="category" class="text-black fw-medium my-2 form-label">Training category</label>
                            <select class="form-control" id="category" name='category' required>
                                <option>Select</option>
                                <option value="Leadership">Leadership</option>
                                <option value="Soft skill">Soft skill</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Health">Health</option>
                                <option value="Safety">Safety</option>
                                <option value="Conference">Conference</option>
                                <option value="Workshop">Workshop</option>
                                <option value="CNE">Continues Nursing Education (CNE)</option>
                                <option value="CME">Continues Medical Education (CME)</option>
                                <option value="Technical">Technical</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="speaker" class="text-black fw-medium my-2 form-label">Speaker</label>
                            <input type="text" class="form-control" id="speaker" name='speaker'
                                value="{{old('speaker')}}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="date" class="text-black fw-medium my-2 form-label">Start Date</label>
                            <input type="date" class="form-control" id="date_start" name='date_start' value="{{old('date_start')}}"
                                required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="date" class="text-black fw-medium my-2 form-label">End Date</label>
                            <input type="date" class="form-control" id="date_end" name='date_end' value="{{old('date_end')}}"
                                required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="time_start" class="text-black fw-medium my-2 form-label">Time Start</label>
                            <input type="time" class="form-control" id="time_start" value="{{old('time_start')}}"
                                name='time_start' required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="time_end" class="text-black fw-medium my-2 form-label">Time End</label>
                            <input type="time" class="form-control" id="time_end" value="{{old('time_end')}}"
                                name='time_end' required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="duration" class="text-black fw-medium my-2 form-label">Duration</label>
                            <input type="text" class="form-control" id="duration" value="{{old('duration')}}"
                                name='duration' required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="location" class="text-black fw-medium my-2 form-label">Location</label>
                            <input type="text" class="form-control" id="location" value="{{old('location')}}"
                                name='location' required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="quantity" class="text-black fw-medium my-2 form-label">Quantity</label>
                            <input type="text" class="form-control" id="quantity" value="{{old('quantity')}}"
                                name='quantity' required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="price" class="text-black fw-medium my-2 form-label">Price</label>
                            <input type="text" class="form-control" id="price" value="{{old('price')}}" name='price'
                                required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="detail" class="text-black fw-medium my-2 form-label">Details</label>
                            <input class="form-control" id="detail" name='detail' value="{{old('detail')}}" required
                                rows="3" required></input>
                        </div>
                    </div>

                    <!--remarks-->
                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="remark" class="text-black fw-medium my-2 form-label">Remarks</label>
                            <input class="form-control" id="remark" rows="3" value="{{old('remark')}}" name='remark'
                                required></input>
                        </div>
                    </div>

                    @foreach ($errors-> all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                    
                    <button type="Submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <x-flash />

@include('partials.footer')