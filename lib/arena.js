// функция для фоновой проверки состояния игры вне боя
function fon_js() {
	$.ajax({
		url: "js_fon.php",
		cache: "folse",
		type: "POST",
		data: ({ fon_js: 1}),
		dataType: "html",
		success: function (data) {
			// console.log(data);
			data = JSON.parse(data);
			$("#t_body").empty();
			$("#t_body").append(data["arena"]);
			$("#panel_in2_box").empty();
			$("#panel_in2_box").append(data['vrag'])
			console.log(data["vrag"]);

		}
	})
}
setInterval('fon_js()', 1000);

function prinyal(n) {
	$.ajax({
		url: "js_fon.php",
		cache: "folse",
		type: "POST",
		data: ({prinyal: n}),
		dataType: "html",
		success: 
		function (data) {
			// data = JSON.parse(data);
			// if (data["t"] == 1) {
			// 	$(location).attr('href',"http://new/index.php?site=tr_js");
			// }
			// else{
			// 	console.log(data["r"]);
			// }
			console.log(data);
		}
		 
	})
}
// -----------------------