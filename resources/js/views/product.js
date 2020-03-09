function pnotify(title, text, type) {
  new PNotify({
    title: title,
    text: text,
    type: type,
    styling: 'bootstrap3'
  });
}

function add() {
  document.getElementById('update-label').innerHTML = 'Tambah Produk';
  $('#storeId').val('');
  $('#name').val('');
  $('#price').val('');
  $('#unit').val('');
  $('#stock').val('');
}

function delConfirm(id, name) {
    document.getElementById('md-body-confi').innerHTML = 'Apakah anda yakin menhapus ' + name + '?';
    $('#delProductId').val(id);
}