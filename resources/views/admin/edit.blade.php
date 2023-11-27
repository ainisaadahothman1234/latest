@include('partials.head')

<div class="container-fluid d-flex justify-content-center">
    <div class="card my-3" id="card" style="width: 80rem;">
        <div class="card-body">

            <!--<form action="/training/update">-->
            <form action="/training/update" method="get" id="update-form">
                @csrf

                @if(Auth()->user()->position == 'admin')
                    <div class="d-flex justify-content-end">
                        <button class="no-print btn btn-primary" onClick="window.print()"><i class="bi bi-printer"></i></button>
                    </div>
                @endif

                <!-- Details -->
                <div class="form-group row">
                    <div class="mb-3">
                        <label for="title" class="text-black fw-medium my-2 form-label">Training Name</label>
                        <div class="editable-placeholder" contenteditable="true" required>
                            <input type="text" class="form-control" name='title' value="{{$training->title}}" required>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="mb-3">
                        <label for="type" class="text-black fw-medium my-2 form-label">Training Type</label>
                        <select class="form-control" id="type" name='type' value="{{old('type')}}" placeholder="{{$training->type}}" required>
                            <option value="{{$training->type}}">{{$training->type}}</option>
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
                                <select class="form-control" id="category" name='category'
                                    placeholder="{{$training->category}}" required>
                                    <option value="{{$training->category}}">{{$training->category}}</option>
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
                                    value="{{$training->speaker}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="mb-3">
                                <label for="date" class="text-black fw-medium my-2 form-label">Start Date</label>
                                <input type="date" class="form-control" id="date_start" name='date_start'
                                    value="{{$training->date_start}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="mb-3">
                                <label for="date" class="text-black fw-medium my-2 form-label">End Date</label>
                                <input type="date" class="form-control" id="date_end" name='date_end'
                                    value="{{$training->date_end}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="mb-3">
                                <label for="time_start" class="text-black fw-medium my-2 form-label">Time Start</label>
                                <input type="time" class="form-control" id="time_start" name='time_start'
                                    value="{{$training->time_start}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="mb-3">
                                <label for="time_end" class="text-black fw-medium my-2 form-label">Time End</label>
                                <input type="time" class="form-control" id="time_end" name='time_end'
                                    value="{{$training->time_end}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="mb-3">
                                <label for="duration" class="text-black fw-medium my-2 form-label">Duration</label>
                                <input type="text" class="form-control" id="duration" name='duration'
                                    value="{{$training->duration}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="mb-3">
                                <label for="location" class="text-black fw-medium my-2 form-label">Location</label>
                                <input type="text" class="form-control" id="location" name='location'
                                    value="{{$training->location}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="mb-3">
                                <label for="quantity" class="text-black fw-medium my-2 form-label">Quantity</label>
                                <input type="text" class="form-control" id="quantity" name='quantity'
                                    value="{{$training->quantity}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="mb-3">
                                <label for="price" class="text-black fw-medium my-2 form-label">Price</label>
                                <input type="text" class="form-control" id="price" name='price'
                                    value="{{$training->price}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="mb-3">
                                <label for="detail" class="text-black fw-medium my-2 form-label">Details</label>
                                <input type="text" class="form-control" id="detail" name='detail'
                                    value="{{$training->detail}}" required>
                            </div>
                        </div>

                <!-- Remarks -->
                <div class="form-group row">
                    <div class="mb-3">
                        <label for="remark" class="text-black fw-medium my-2 form-label">Remarks</label>
                        <input type="text" class="form-control" id="remark" name='remark' value="{{$training->remark}}" required>
                    </div>
                </div>

                <input type="hidden" name="code" id="code" value="{{$training->code}}">
                <?php $training->code ?>
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach

                @if(Auth()->user()->position == 'admin')
                    <div class="d-flex justify-content-between my-3">
                        <button id='option' class="btn btn-danger" onclick="confirmDelete()">Delete</button>
                        <div class="d-flex justify-content-end">
                            <a href="/attendance/{{ $training->code }}" class="btn btn-primary mx-2">Attendance</a>
                            <button id='option' name='option' class="btn btn-primary" type="submit" value='update'>Update</button>
                        </div>
                    </div>
                    
                @endif

            </form>

        </div>
    </div>
</div>

<!-- JavaScript for confirmation dialog -->
<script>
    function confirmDelete() {
        if (confirm("Are you sure you want to delete this training?")) {
            // If the user confirms, submit the form to delete the training
            document.getElementById('update-form').action = "/training/delete"; 
            document.getElementById('update-form').submit();
        }
    }
</script>

<x-flash />

@include('partials.footer')