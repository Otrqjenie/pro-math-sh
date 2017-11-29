function funcSuccess (data) {
	$("#conteiner").empty();
	$("#conteiner").append(data);
}

function start () {
	$.ajax({
		url: "statistika_js.php",
		type: "GET",
		data: ({ start: 1}),
		dataType: "html",
		success: funcSuccess
	});
}

function show () {
		$.ajax({
			url: "statistika_js.php",
			cache: "folse",
			type: "GET",
			data: ({ time: 1 }),
			success: function (html) {
				$('#timer').html(html);
			}
		})
	}
	setInterval('show()', 2000);
function lo () {
	$.ajax({
		url: "statistika_js.php",
			cache: "folse",
			type: "GET",
			data: ({ gr: 1 }),
			success: function (data) {
				$("#graph").empty();
				$("#graph").append(data);
			}
	})
}
// Окончание сессии
function stoP () {
	$.ajax({
		url: "statistika_js.php",
			cache: "folse",
			type: "GET",
			data: ({ stop: 1 })			
	})
}
// Изменение 
function but1 (a, b) {
	$.ajax({
		url: "statistika_js.php",
			cache: "folse",
			type: "GET",
			data: ({ x: a, y: b }),	
			success: function (html) {
				$('#conteiner').html(html);
			}		
	})
}