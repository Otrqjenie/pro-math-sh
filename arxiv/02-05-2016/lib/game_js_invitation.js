function invitat () {
	$.ajax({
		url: "js.php",
		cache: "folse",
		type: "GET",
		data: ({invitat: 1}),
		success: function (data) {
			$('#conteiner').empty();
			$('#conteiner').append(data);
		}
	})
}
setInterval('invitat()', 5000);