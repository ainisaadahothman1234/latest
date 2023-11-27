@include('partials.head')

<div class="container mt-5 bg-white rounded-2">
    <div class="card" id="card">
        <h2 class="text-center">COURSE / SEMINAR / TRAINING REQUEST FORM</h2>
            <form>
                <!-- Course Details Section -->
                <h4 class="mt-4">COURSE DETAILS</h4>
                <div class="form-group">
                    <label for="courseTitle">COURSE TITLE</label>
                    <input type="text" class="form-control" id="courseTitle" name="courseTitle">
                </div>
                <div class="form-group">
                    <label for="organizer">NAME OF ORGANIZER</label>
                    <input type="text" class="form-control" id="organizer" name="organizer">
                </div>
                <div class="form-group">
                    <label for="sponsor">SPONSORED BY</label>
                    <input type="text" class="form-control" id="sponsor" name="sponsor">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="courseFee">COURSE FEE RM</label>
                        <input type="text" class="form-control" id="courseFee" name="courseFee">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="duration">DATE / DURATION</label>
                        <input type="text" class="form-control" id="duration" name="duration">
                    </div>
                </div>
                <div class="form-group">
                    <label for="venue">VENUE</label>
                    <input type="text" class="form-control" id="venue" name="venue">
                </div>

                <hr class="hr" />

                <!-- Personnel Details Section -->
                <h4 class="mt-4">PERSONNEL DETAILS</h4>
                <div class="form-group">
                    <label for="numParticipants">NUMBER OF PARTICIPANTS</label>
                    <select class="form-control" id="numParticipants" name="numParticipants">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                    </select>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="name1">NAME</label>
                        <input type="text" class="form-control" id="name1" name="name1">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="position1">POSITION</label>
                        <input type="text" class="form-control" id="position1" name="position1">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="services1">SERVICES</label>
                        <input type="text" class="form-control" id="services1" name="services1">
                    </div>
                </div>
                <!-- Repeat the above personnel details fields for more participants -->

                <hr class="hr" />

                <!-- Reason for Attending Section -->
                <h4 class="mt-4">REASON FOR ATTENDING THIS COURSE / SEMINAR / TRAINING</h4>
                <div class="form-group">
                    <textarea class="form-control" id="reason" name="reason" rows="4"></textarea>
                </div>

                <hr class="hr" />

                <div class="container d-flex justify-content-between">
                    <div class="column">
                        <!-- Recommended/Not Recommended Section -->
                        <h4 class="mt-4">RECOMMENDED/NOT RECOMMENDED BY:</h4>
                        <div class="form-group">
                            <label for="remarksCNO">CHIEF NURSING OFFICER / HEAD OF SERVICES</label>
                            <input type="text" class="form-control" id="remarksCNO" name="remarksCNO">
                        </div>
                        <div class="form-group">
                            <label for="signatureCNO">Signature</label>
                            <input type="text" class="form-control" id="signatureCNO" name="signatureCNO">
                        </div>
                        <div class="form-group">
                            <label for="dateCNO">Date</label>
                            <input type="text" class="form-control" id="dateCNO" name="dateCNO">
                        </div>
                    </div>

                    <div class="d-flex" style="height: 350px;">
                        <div class="vr"></div>
                    </div>

                    <div class="column">
                        <!-- Approved Section -->
                        <h4 class="mt-4">APPROVED BY:</h4>
                        <div class="form-group">
                            <label for="remarksCEO">CHIEF EXECUTIVE OFFICER</label>
                            <input type="text" class="form-control" id="remarksCEO" name="remarksCEO">
                        </div>
                        <div class="form-group">
                            <label for="signatureCEO">Signature</label>
                            <input type="text" class="form-control" id="signatureCEO" name="signatureCEO">
                        </div>
                        <div class="form-group">
                            <label for="dateCEO">Date</label>
                            <input type="text" class="form-control" id="dateCEO" name="dateCEO">
                        </div>
                    </div>
                </div>


                <hr class="hr" />

                <!-- HR Remarks Section -->
                <h4 class="mt-4">FOR HUMAN RESOURCES MANAGEMENT</h4>
                <div class="form-group">
                    <label for="remarksHR">REMARKS</label>
                    <textarea class="form-control" id="remarksHR" name="remarksHR" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label for="actionBy">ACTION BY</label>
                    <input type="text" class="form-control" id="actionBy" name="actionBy">
                </div>
                <div class="form-group">
                    <label for="signatureHR">Signature</label>
                    <input type="text" class="form-control" id="signatureHR" name="signatureHR">
                </div>
                <div class="form-group">
                    <label for="dateHR">Date</label>
                    <input type="text" class="form-control" id="dateHR" name="dateHR">
                </div>

                <button type="submit" class="btn btn-primary" onClick="window.print()">Print</button>
            </form>
    </div>        
</div>

<x-flash />

@include('partials.footer')