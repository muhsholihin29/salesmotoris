function tgl(a, b) {
  // document.body.innerHTML += '<form id="btn-number-action" action="pendaftaran" method="post">{{csrf_field()}}<input type="hidden" id="jtgl_start" name="tgl_start" value=""><input type="hidden" id="jtgl_end" name="tgl_end" value=""></form>';
  $('#jtgl_start').val(a); 
  $('#jtgl_end').val(b);     
  // document.getElementById("btn-number-action").submit(); 
}

function funTglStart(){
  var start = $('#tgl_start').val();
  if (start == 0) {
    return 0;
  }
  var datearrayA = start.split("-");
  // console.log("aaaaaaaa" + datearrayA[1] + '/' + datearrayA[0] + '/' + datearrayA[2]);
  return datearrayA[1] + '/' + datearrayA[0] + '/' + datearrayA[2];
}

function funTglEnd(){    
  var end = $('#tgl_start').val();
  if (end == 0) {
    return 0;
  }
  var datearrayB = end.split("-");    
  return datearrayB[1] + '/' + datearrayB[0] + '/' + datearrayB[2];
}

$(function() {
  $('.pop').on('click', function() {
    $('.imagepreview').attr('src', $(this).find('img').attr('src'));
    $('#imagemodal').modal('show');   
  });     
});

$(document).ready(function(){ 
  if (true) {}
  $('.btn-expExcel').attr('disabled','disabled');
  $('.btn-expExcel').attr('title','Jangka waktu harus 1 hari');
});

$(document).ready(function() {
 $("#btnExpExcel").click(function(e) {
 e.preventDefault();
console.log('tesexcel');

var params = {};
  var parser = document.createElement('a');
  parser.href = window.location.href;
  var query = parser.search.substring(1);
  var vars = query.split('&');
  for (var i = 0; i < vars.length; i++) {
    var pair = vars[i].split('=');
    params[pair[0]] = decodeURIComponent(pair[1]);
  }



//getting data from our table
 var data_type = 'data:application/vnd.ms-excel';
 var table_div = document.getElementById('tableExcel');
 var table_html = table_div.outerHTML.replace(/ /g, '%20');

var a = document.createElement('a');
 a.href = data_type + ', ' + table_html;
 a.download = 'salesmotoris_report_'+params.date_start + '.xls';
 a.click();
 });
});