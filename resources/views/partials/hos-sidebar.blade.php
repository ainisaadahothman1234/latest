<!--Sidebar left-->
<div class="container-fluid">
        <div class="row">
          <div class="col-sm3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
              <!--dropdown for training list-->
              <li>
                <a href="/" class="text-decoration-none text-black fw-medium">
                Training
                </a>
                <div class="text-decoration-none text-black mx-3">

                <form action="{{ route('filter') }}" method="GET" class="mt-4">
                <div class="mb-3">
                    <label class="form-label fw-medium">Type:</label>
                          <div class="form-check my-2">
                              <input class="form-check-input" type="checkbox" name="filterType[]" value="In-House" id="filterInHouse">
                              <label class="form-check-label" for="filterInHouse">In-house</label>
                          </div>
                          <div class="form-check my-2">
                              <input class="form-check-input" type="checkbox" name="filterType[]" value="Local Public" id="filterLocalPublic">
                              <label class="form-check-label" for="filterLocalPublic">Local Public / Seminar / Conference</label>
                          </div>
                          <div class="form-check my-2">
                              <input class="form-check-input" type="checkbox" name="filterType[]" value="Local Public" id="filterOverseas">
                              <label class="form-check-label" for="filterOverseas">Overseas / Seminar / Conference</label>
                          </div>
                          <div class="form-check my-2">
                              <input class="form-check-input" type="checkbox" name="filterType[]" value="External" id="filterOnlineTraining">
                              <label class="form-check-label" for="filterOnlineTraining">Online Training</label>
                          </div>
                          <div class="form-check my-2">
                              <input class="form-check-input" type="checkbox" name="filterType[]" value="External" id="filterELearning">
                              <label class="form-check-label" for="filterELearning">E-Learning</label>
                          </div>
                  </div>
              <div class="mb-3">
                <label class="form-label fw-medium">Category:</label>
                  <!-- Add more checkbox options as needed -->
                  <div class="form-check my-2">
                    <input class="form-check-input" type="checkbox" name="filterCategory[]" value="Leadership" id="filterCategory1" {{ in_array('Leadership', request('filterCategory', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="filterCategory1">Leadership & Managerial skills</label>
                  </div>
                  <div class="form-check my-2">
                    <input class="form-check-input" type="checkbox" name="filterCategory[]" value="Employee Engagement" id="filterCategory1" {{ in_array('Employee Engagement', request('filterCategory', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="filterCategory1">Employee Engagement</label>
                  </div>
                  <div class="form-check my-2">
                    <input class="form-check-input" type="checkbox" name="filterCategory[]" value="Communication Skills" id="filterCategory1" {{ in_array('Communication Skills', request('filterCategory', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="filterCategory1">Communication Skills</label>
                  </div>
                  <div class="form-check my-2">
                    <input class="form-check-input" type="checkbox" name="filterCategory[]" value="Team Building" id="filterCategory1" {{ in_array('Team Building', request('filterCategory', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="filterCategory1">Team Building</label>
                  </div>
                  <div class="form-check my-2">
                    <input class="form-check-input" type="checkbox" name="filterCategory[]" value="Change Management" id="filterCategory1" {{ in_array('Change Management', request('filterCategory', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="filterCategory1">Change Management</label>
                  </div>
                  <div class="form-check my-2">
                    <input class="form-check-input" type="checkbox" name="filterCategory[]" value="Conflict Resolution" id="filterCategory1" {{ in_array('Conflict Resolution', request('filterCategory', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="filterCategory1">Conflict Resolution</label>
                  </div>
                  <div class="form-check my-2">
                    <input class="form-check-input" type="checkbox" name="filterCategory[]" value="Time Management" id="filterCategory1" {{ in_array('Time Management', request('filterCategory', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="filterCategory1">Time Management</label>
                  </div>
                  <div class="form-check my-2">
                    <input class="form-check-input" type="checkbox" name="filterCategory[]" value="Cross-cultural" id="filterCategory1" {{ in_array('Cross-cultural', request('filterCategory', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="filterCategory1">Cross-cultural</label>
                  </div>
                  <div class="form-check my-2">
                    <input class="form-check-input" type="checkbox" name="filterCategory[]" value="Creativity & Innovation" id="filterCategory1" {{ in_array('Creativity & Innovation', request('filterCategory', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="filterCategory1">Creativity & Innovation</label>
                  </div>
                  <div class="form-check my-2">
                    <input class="form-check-input" type="checkbox" name="filterCategory[]" value="Project Management" id="filterCategory1" {{ in_array('Project Management', request('filterCategory', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="filterCategory1">Project Management</label>
                  </div>
                  <div class="form-check my-2">
                    <input class="form-check-input" type="checkbox" name="filterCategory[]" value="Presentation Skills" id="filterCategory1" {{ in_array('Presentation Skills', request('filterCategory', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="filterCategory1">Presentation Skills</label>
                  </div>

                  <!-- Repeat for other categories -->
              </div>
            </div>
            
            <!--button-->
            <div class="d-flex justify-content-between my-3 mx-3">
              <button type="submit" class="btn btn-primary">APPLY</button>
            </div>
          </form>
              </li>
            </ul>
          </div>
        </div>
      </div>