@include('partials.head')
<!--main body-->

<div class="container-fluid">
    <div class="row">

        <!--Dashboard-->
        <div class="col-md-12 fw-bold fs-3 my-2">
            Requested Training
        </div>

        <!--list of requested training with checkbox indicate done-->
        <div class="container-fluid d-flex justify-content-center">
            <div class="card my-3" id="card" style="width:100rem;">
                <div class="card-body">

                    <!--success message-->
                @if(session('success'))
                    <div class="alert alert-success m-2">
                        {{ session('success') }}
                    </div>
                @endif

                    <!--Table to select staff for trainning assignation-->
                    <table class="table table-striped">
                        <!--Table header-->
                        <thead class="text-sm fw-light">
                            <tr>
                                <!--Header name-->
                                <th>No</th>
                                <th class="text-center">Request Form</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Update</th>
                            </tr>
                        </thead>

                        <!--Table body-->
                        <tbody>
                            <!--row name-->
                            @foreach($training as $id=>$external)
                            <tr>
                                <td>{{$id + 1}}</td>
                                <td class="text-center"><a href="/print/{{$external->code}}">{{ $external->title }}</a>
                                </td>
                                <td class="text-center">{{$external->status}}</td>
                                <td class="text-center">
                                    <a class="btn btn-primary" href="/training/approve/{{$external->code}}">Approve</a>
                                    <a class="btn btn-danger" href="/training/reject/{{$external->code}}">Reject</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-flash />

@include('partials.footer')
