function pnotify(title, text, type) {
	new PNotify({
		title: title,
		text: text,
		type: type,
		styling: 'bootstrap3'
	});
}

function filSearch() {
	// console.log($('#filSales').val());

	if ($('#filSales').val() != '') {
		var pageUrl = window.location.href;
		if (pageUrl.substr(pageUrl.lastIndexOf('/') + 1) > 0) {
			var newUrl = pageUrl.split('/').slice(0,-1).join('/')+'/'+$('#filSales').val();
			// url.replace(/\/[^\/]*$/, '/175')
			console.log(newUrl);
			window.location.replace(newUrl);	
		} else{
			window.location.replace('stock/'+$('#filSales').val());
		}
		
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
	$("#filSales").select2(); 
	var url = document.URL;
	var id = url.substring(url.lastIndexOf('/') + 1);
	console.log(id);
	if (id > 0) {
		$('#filSales').select2("val", String(id));
	}
});
