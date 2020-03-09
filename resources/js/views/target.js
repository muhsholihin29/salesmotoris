function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function pnotify(title, text, type) {
  new PNotify({
    title: title,
    text: text,
    type: type,
    styling: 'bootstrap3'
  });
}

function delPrFocus(id, name) {
  document.getElementById('md-body-confi').innerHTML = 'Apakah anda yakin menhapus ' + name + '?';
  $('#delPrFocusId').val(id);
}

$(document).ready(function() {
  $("#prFocus").select2();
});