function pnotify(title, text, type) {
	new PNotify({
		title: title,
		text: text,
		type: type,
		styling: 'bootstrap3'
	});
}

function filSearch() {
	if ($('#filSales').val() != '') {
		window.location.replace('stock/'+$('#filSales').val());
	}
}

function add() {
	document.getElementById('update-label').innerHTML = 'Tambah Stok';
	$('#stockId').val('');
	$('#product').val('');
	$('#quantity').val('');
	document.getElementById('unit').innerHTML = '';
	$('#stock').val('');
	document.getElementById("load").style.visibility = "hidden";
	var url = document.URL;
	var idSales = url.substring(url.lastIndexOf('/') + 1);
	$('#salesId').val(idSales);
}

function delConfirm(id, name) {
	var url = document.URL;
	var idSales = url.substring(url.lastIndexOf('/') + 1);
	document.getElementById('md-body-confi').innerHTML = 'Apakah anda yakin menghapus ' + name + '?';
	$('#delStockId').val(id);
	$('#delSalesId').val(idSales);
}

$(document).ready(function(){  
	var url = document.URL;
	var id = url.substring(url.lastIndexOf('/') + 1);
	console.log(id);
	if (id > 0) {
		document.getElementById('filSales').value = id;
	}
});
