function filSearch() {
	if ($('#filSales').val() != '') {
		window.location.replace('visitation/'+$('#filSales').val());
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

function add() {
	document.getElementById('update-label').innerHTML = 'Tambah Kunjungan';
	$('#visitId').val('');
	document.getElementById('sel_store').value = 0;
	document.getElementById('chSenin').checked = false;
    document.getElementById('chSelasa').checked = false;
    document.getElementById('chRabu').checked = false;
    document.getElementById('chKamis').checked = false;
    document.getElementById('chJumat').checked = false;
	$('#stock').val('');
	document.getElementById("load").style.visibility = "hidden";
	var url = document.URL;
	var idSales = url.substring(url.lastIndexOf('/') + 1);
	$('#salesId').val(idSales);
	document.getElementById("load").style.visibility = "hidden";
}

function delConfirm(id, name) {
	var url = document.URL;
	var idSales = url.substring(url.lastIndexOf('/') + 1);
	document.getElementById('md-body-confi').innerHTML = 'Apakah anda yakin menghapus kunjungan ' + name + '?';
	$('#delVisitId').val(id);
	$('#delSalesId').val(idSales);
}

$(document).ready(function(){  
	$("#filSales").select2();
	$("#sel_store").select2();
	var url = document.URL;
	var id = url.substring(url.lastIndexOf('/') + 1);
	console.log(id);
	if (id > 0) {
		$('#filSales').select2("val", String(id));
	}
});