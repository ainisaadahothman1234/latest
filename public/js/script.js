//checkbox assign staff
document.addEventListener('DOMContentLoaded',function(){
  const toggleButton = document.getElementById('selectAll');
  const checkboxes = document.getElementById('.form-check-input');

  toggleButton.addEventListener('click',function(){
      checkboxes.forEach(checkbox=>{
          checkbox.checked=!checkbox.checked;
      });
  });
});


//test?
var $table = $('#table');
    $(function () {
        $('#toolbar').find('select').change(function () {
            $table.bootstrapTable('refreshOptions', {
                exportDataType: $(this).val()
            });
        });
    })

		var trBoldBlue = $("table");

	$(trBoldBlue).on("click", "tr", function (){
			$(this).toggleClass("bold-blue");
	});


//search//

function myFunction() {
  // Declare variables
  var input, filter, table, tbody, tr, td, i, j, txtValue;
  input = document.getElementById("searchCourse");
  filter = input.value.toUpperCase();
  table = document.getElementById("courseTable");
  tbody = table.getElementsByTagName("tbody");
  tr = tbody[0].getElementsByTagName("tr");

  // Loop through all table rows, and hide those that don't match the search query
  for (i = 0; i < tr.length; i++) {
    tr[i].style.display = "none"; // Hide the row by default
    td = tr[i].getElementsByTagName("td");
    for (j = 0; j < td.length; j++) {
      if (td[j]) {
        txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = ""; // Display the row if it matches the search
          break; // No need to check other cells in this row
        }
      }
    }
  }
}

