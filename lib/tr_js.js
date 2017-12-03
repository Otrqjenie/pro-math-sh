$(function () {
	$.ajax({
		url: "js.php",
		type: "GET",
		data: ({ begin: 1}),
		dataType: "html",
		success: function (data) {
		console.log(data);
		data = JSON.parse(data);
		var quantity = data["quantity"]/10, quantity_enemy = data["quantity_enemy"]/10;

		$("#shar").fadeTo(0, quantity);
		$("#shar2").fadeTo(0, quantity_enemy);
		// $("#win").empty();
		// $("#win").append(data["quantity"]);
		}
	});
});

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
function check() {
	$.ajax({
		url: "js.php",
		type: "POST",
		data: ({otvet: $("#otvet").val()}),
		dataType: "html",

		success: function (data) {
	data = JSON.parse(data);
		console.log(data);
	if (data['$message'] !== "Много ответов") {

	var delay = 50,
	i = 0,
	j = 4;
	startTimer = function fire () {
		// console.log('функция startTimer  сработала');
		var elem = document.getElementById('circle');
		

		bottom = elem.offsetLeft;
		 bottom2 = elem.offsetTop;
		if(i<35){
			setTimeout(startTimer, delay);
			elem.style.left = bottom + 15 +'px';
			j = j - 1/5;
			bottom2 = bottom2 - j;
			elem.style.top = bottom2 +'px';
		}
		else{
			$("#experience").empty();
			$("#experience").append(data["count"]);
			$("#shield2").empty();
			$("#shield2").append(data["str"]);
			console.log(data["str"]);
			elem.style.left = 125 + 'px';
			elem.style.top = 330 + 'px';
			var quantity_enemy = data["quantity_enemy"]/10;
			
			
			$("#shar2").fadeTo(1000, quantity_enemy);
		}
		i++;
	}
	var timer = setTimeout(startTimer, delay);
}
}
	})
}
function check2 () {
	$.ajax({
		url: "js.php",
		cache: "folse",
		type: "GET",
		data: ({fire2 : 1}),
		success: function (data) {			
			console.log(data);
			data = JSON.parse(data);
			if (data["t"] < 0) {
				$("#conteiner").empty();
				$("#conteiner").append(data["str"]);
			}
			else{


			if (data["rez"] == 1) {

				var t = data["t"];
				// console.log(data);


// -----------------------------------------------
var delay = 50,
	i = 0,
	j = 4;
	startTimer = function fire () {
		// console.log('функция startTimer  сработала');
		var elem = document.getElementById('circle2');
		

		bottom = elem.offsetLeft;
		 bottom2 = elem.offsetTop;
		if(i<35){
			setTimeout(startTimer, delay);
			elem.style.left = bottom - 15 +'px';
			j = j - 1/5;
			bottom2 = bottom2 - j;
			elem.style.top = bottom2 +'px';
		}
		else{

			elem.style.left = 660 + 'px';
			elem.style.top = 330 + 'px'
			var quantity = data["quantity"]/10;			
			$("#shar").fadeTo(1000, quantity);
			$("#shield").empty();
			$("#shield").append(data["str"]);
			$("#experience_e").empty();
			$("#experience_e").append(data["enemy_count"]);
		}
		i++;
	}
	var timer = setTimeout(startTimer, delay);

// -----------------------------------------------

			};
			if (data["rez"] == 0) {
				var t = data["t"];
				// console.log(t);
				// console.log(data);
				var delay = 50,
					i = 0,
					j = 4;
					startTimer = function fire () {
						// console.log('функция startTimer  сработала');
						var elem = document.getElementById('circle2');
						

						bottom = elem.offsetLeft;
						 bottom2 = elem.offsetTop;
						if(i<35){
							setTimeout(startTimer, delay);
							elem.style.left = bottom - 15 +'px';
							j = j - 1/5;
							bottom2 = bottom2 - j;
							elem.style.top = bottom2 +'px';
						}
						else{

							elem.style.left = 660 + 'px';
							elem.style.top = 330 + 'px';
							var quantity = data["quantity"]/10;
							
							
							$("#shar").fadeTo(1000, quantity);
						}
						i++;
					}
					var timer = setTimeout(startTimer, delay);

			};
		};
		}
	})
	
}
// setInterval('check2()', 1000);