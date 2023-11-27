$(document).ready(function () {
  $(".data-table").each(function (_, table) {
    $(table).DataTable();
  });
});

//search//

function myFunction() {
  var input, filter, table, tr, tdName, tdID, i, txtValueName, txtValueID;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    tdName = tr[i].getElementsByTagName("td")[1]; // Name column
    tdID = tr[i].getElementsByTagName("td")[0]; // ID column
    if (tdName && tdID) {
      txtValueName = tdName.textContent || tdName.innerText;
      txtValueID = tdID.textContent || tdID.innerText;
      if (
        txtValueName.toUpperCase().indexOf(filter) > -1 ||
        txtValueID.toUpperCase().indexOf(filter) > -1
      ) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

//$(document).ready(function () {
  // Initialize Bootstrap components
  //$('[data-toggle="dropdown"]').dropdown();
//});

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