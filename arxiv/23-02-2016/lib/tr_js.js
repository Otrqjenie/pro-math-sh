function funcBefore () {
	// $("#conteiner").text("Ожидание данных");
};
function funcSuccess (data) {
	$("#conteiner").empty();
	$("#conteiner").append(data);
}
function load1 (a) {
	$.ajax({
		url: "js.php",
		type: "GET",
		data: ({ enemy_shield: a}),
		dataType: "html",
		success: funcSuccess
	});
}