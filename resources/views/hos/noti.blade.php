@include('partials.head')

<br>
<!-- table, history of request training -->
<div class="container-fluid my-3">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">Notification</h2>
            <div class="table-responsive my-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Details</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- table end -->

<x-flash />

@include('partials.footer')