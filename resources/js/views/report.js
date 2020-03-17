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