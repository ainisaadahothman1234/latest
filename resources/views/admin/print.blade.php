@include('partials.header')

<div class="container mt-5 bg-white rounded-2">
    <!--title-->
    <h4><a href="/training/req"><i class="bi bi-arrow-left-circle"></i></a></h4>
    <h4 class="text-center">COURSE / SEMINAR / TRAINING REQUEST FORM</h4>

    <!--form of requested training-->
    <form>
        <!-- Course Details Section -->
        <h5 class="mt-4">COURSE DETAILS</h5>
        <div class="form-group">
            <label for="courseTitle">COURSE TITLE</label>
            <input type="text" class="form-control" value="{{$training->title}}" id="courseTitle" name="courseTitle" disabled>
        </div>
        <div class="form-group">
            <label for="organizer">NAME OF ORGANIZER</label>
            <input type="text" class="form-control" value="{{$training->organizer}}" id="organizer" name="organizer" disabled>
        </div>
        <div class="form-group">
            <label for="sponsor">SPONSORED</label>
            <input type="text" class="form-control" id="sponsor" name="sponsor" value="{{$training->sponsor}}" disabled>
        </div>
        <div class="form-group">
            <label for="courseFee">COURSE FEE RM</label>
            <div class="input-group">
                <input type="text" class="form-control" value="{{$training->price}}" id="courseFee" name="courseFee" disabled>
                <div class="input-group-append">
                    <span class="input-group-text">/ PAX</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="duration">START DATE</label>
            <input type="text" class="form-control" value="{{$training->date_start}} / {{$training->duration}}" id="date_start" name="date_start" disabled>
        </div>
        <div class="form-group">
            <label for="duration">END DATE</label>
            <input type="text" class="form-control" value="{{$training->date_end}} / {{$training->duration}}" id="date_end" name="date_end" disabled>
        </div>
        <div class="form-group">
            <label for="duration">DURATION</label>
            <input type="text" class="form-control" value="{{$training->duration}} / {{$training->duration}}" id="duration" name="duration" disabled>
        </div>
        <div class="form-group">
            <label for="venue">VENUE</label>
            <input type="text" class="form-control" value="{{$training->location}}" id="location" name="location" disabled>
        </div>

        <!-- Personnel Details Section -->
        <h5 class="mt-4">PERSONNEL DETAILS</h5>
        <div class="form-group">
            <label for="numParticipants">NUMBER OF PARTICIPANTS:</label>
            <input class="form-control" value="{{$training->quantity}} pax" id="numParticipants" name="numParticipants" disabled>
        </div>

        <!---->
        <?php $allstaff = App\Models\Apply::select('staff_apply.*', 'users.*')
            ->join('users', 'staff_apply.staff_id', '=', 'users.staff_id')
            ->where('staff_apply.training_code', $training->code)
            ->get();
        ?>

        <!--Display staff that join the training-->
        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>STAFF NAME</th>
                    <th>POSITION</th>
                    <th>SERVICES</th>
                    <th>E-MAIL</th>
                    <th>CONTACT NO</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allstaff as $key => $staff)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$staff->staff_id}}</td>
                    <td>{{$staff->position}}</td>
                    <td>{{$staff->service}}</td>
                    <td>{{$staff->email}}</td>
                    <td>{{$staff->no}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Reason for Attending Section -->
        <h5 class="mt-4">REASON FOR ATTENDING THIS COURSE / SEMINAR / TRAINING</h5>
        <div class="form-group">
            <textarea class="form-control" id="detail" name="detail" rows="3" disabled>{{$training->detail}}</textarea>
        </div>

        <!-- Recommended/Not Recommended Section -->
        <h5 class="mt-4">RECOMMENDED/NOT RECOMMENDED BY:</h5>
        <div class="form-group">
            <label for="remarksCNO">CHIEF NURSING OFFICER / HEAD OF SERVICES</label>
            <input type="text" class="form-control" value="{{$training->approve_cno}}" id="remarksCNO" name="remarksCNO" disabled>
        </div>
        <div class="form-group">
            <label for="signatureCNO">Signature:</label>
            <input type="text" class="form-control" id="signatureCNO" name="signatureCNO" disabled>
        </div>
        <div class="form-group">
            <label for="dateCNO">Date:</label>
            <input type="text" class="form-control" id="dateCNO" name="dateCNO" disabled>
        </div>

        <!-- Approved Section -->
        <h5 class="mt-4">APPROVED BY:</h5>
        <div class="form-group">
            <label for="remarksCEO">CHIEF EXECUTIVE OFFICER</label>
            <input type="text" class="form-control" value="{{$training->approve_ceo}}" id="remarksCEO" name="remarksCEO" disabled>
        </div>
        <div class="form-group">
            <label for="signatureCEO">Signature:</label>
            <input type="text" class="form-control" id="signatureCEO" name="signatureCEO" disabled>
        </div>
        <div class="form-group">
            <label for="dateCEO">Date:</label>
            <input type="text" class="form-control" id="dateCEO" name="dateCEO" disabled>
        </div>

        <!-- HR Remarks Section -->
        <h5 class="mt-4">FOR HUMAN RESOURCES MANAGEMENT</h5>
        <div class="form-group">
            <label for="remarksHR">REMARKS:</label>
            <textarea class="form-control" id="remarksHR" name="remarksHR" rows="4" disabled>{{'Approve'}}</textarea>
        </div>
        <div class="form-group">
            <label for="actionBy">ACTION BY:</label>
            <input type="text" class="form-control" id="actionBy" name="actionBy" disabled>
        </div>
        <div class="form-group">
            <label for="signatureHR">Signature:</label>
            <input type="text" class="form-control" id="signatureHR" name="signatureHR" disabled>
        </div>
        <div class="form-group">
            <label for="dateHR">Date:</label>
            <input type="text" class="form-control" id="dateHR" name="dateHR" disabled>
        </div>
        <div class="form-group">
            <label for="hrdCorpGrantID">HRD Corp Grant ID:</label>
            <input type="text" class="form-control" id="hrdCorpGrantID" name="hrdCorpGrantID" disabled>
        </div>

        <button type="submit" class="btn btn-primary my-2" onClick="window.print()"><i class="bi bi-printer"></i> Print</button>
    </form>
</div>

<x-flash />

@include('partials.footer')
