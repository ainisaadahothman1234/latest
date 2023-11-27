@include('partials.head')


<?php

use App\Models\Training;

$training_list = Training::where('code', $trainingID)->get();

?>

@foreach ($training_list as $training)

<!--main body-->

<main>

    <div class="container-fluid d-flex justify-content-center">
        <div class="card my-3 " style="width: 50rem;">
            <div class="card-body">

                <form action="/{{ Auth()->user()->position }}/training/list" method="post">
                    @csrf
                    <!--details-->
                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="id" class="text-black fw-medium my-2 form-label">Training Name</label>
                            <input type="text" class="form-control" placeholder="{{$training->title}}" disabled>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="type" class="text-black fw-medium my-2 form-label">Training Type</label>
                            <input type="text" class="form-control" placeholder="{{$training->type}}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="category" class="text-black fw-medium my-2 form-label">Training category</label>
                            <input type="text" class="form-control" placeholder="{{$training->category}}" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="speaker" class="text-black fw-medium my-2 form-label">Speaker</label>
                            <input type="text" class="form-control" placeholder="{{$training->speaker}}" id="speaker"
                                name='speaker' required disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="date" class="text-black fw-medium my-2 form-label">Date</label>
                            <input type="date" class="form-control" placeholder="{{$training->date}}" id="date"
                                name='date' required disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="timeStart" class="text-black fw-medium my-2 form-label">Time Start</label>
                            <input type="time" class="form-control" placeholder="{{$training->time_start}}"
                                id="timeStart" name='timeStart' required disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="timeEnd" class="text-black fw-medium my-2 form-label">Time End</label>
                            <input type="time" class="form-control" placeholder="{{$training->time_end}}" id="timeEnd"
                                name='timeEnd' required disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="duration" class="text-black fw-medium my-2 form-label">Duration</label>
                            <input type="text" class="form-control" placeholder="{{$training->duration}}" id="duration"
                                name='duration' required disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="location" class="text-black fw-medium my-2 form-label">Location</label>
                            <input type="text" class="form-control" placeholder="{{$training->location}}" id="location"
                                name='location' required disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="price" class="text-black fw-medium my-2 form-label">Price</label>
                            <input type="text" class="form-control" placeholder="{{$training->price}}" id="price"
                                name='price' required disabled>
                        </div>
                    </div>

                    <!--status either on hold or cancel-->
                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="status" class="text-black fw-medium my-2 form-label">Status</label>
                            <input class="form-control" id="status" name='status' placeholder="{{$training->status}}"
                                required disabled></input>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="detail" class="text-black fw-medium my-2 form-label">Details</label>
                            <textarea class="form-control" placeholder="{{$training->detail}}" id="detail" name='detail'
                                required rows="3" name='' required
                                disabled>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iste sapiente aut itaque veniam quo quia impedit saepe eum sint! Sit exercitationem culpa nulla libero ab laboriosam fuga maxime facilis aperiam!</textarea>
                        </div>
                    </div>

                    <!--remarks-->
                    <div class="form-group row">
                        <div class="mb-3">
                            <label for="remark" class="text-black fw-medium my-2 form-label">Remarks</label>
                            <textarea class="form-control" placeholder="{{$training->remark}}" id="remark" rows="3"
                                name='remark' required disabled> Lorem ipsum dolor, sit amet consectetur.</textarea>
                        </div>
                    </div>
                    @foreach ($errors-> all() as $error)
                    <li>{{$error}}</li>
                    @endforeach

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Apply</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</main>
@endforeach
<x-flash />

@include('partials.footer')