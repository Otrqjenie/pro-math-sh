$(document).ready(function () {
	$("select[name='type']").bind("change", function () {
		$.get("js.php", 
			{type: $("select[name='type']").val()},
			function (data) {
				// data
				$("#list").html(data);
			}
		)

	})
});
$(document).ready(function () {
	$("select[name='type2']").bind("change", function () {
		$.get("js.php", 
			{type2: $("select[name='type2']").val()},
			function (data) {
				// data
				$("#list2").html(data);
			}
		)

	})
});
//функция для вывода условия задачи щита
function show_z(a) {
	$.ajax({
		url: "js.php",
		type: "GET",
		data: ({ show_z: a}),
		dataType: "html",
		success: function (data) {
			$("#text_z").empty();
			$("#text_z").append(data);
		}
	});

};
function del_z(a) {
	$.ajax({
		url: "js.php",
		type: "GET",
		data: ({ del_z: a, del_z2: $("select[name='type2']").val()}),
		dataType: "html",
		success: function (data) {
			// console.log(data);
			data = JSON.parse(data);
			// console.log(data["razdel"]);
			if (data["razdel"] == "oge") {
				$("#sh1").empty();
				$("#sh1").append(data["shield"]);

				$("#list2").empty();
				$("#list2").append(data["arsenal"]);
			}
			else if (data["razdel"] == "ege") {
				$("#sh2").empty();
				$("#sh2").append(data["shield"]);

				$("#list2").empty();
				$("#list2").append(data["arsenal"]);
			}
			else if (data["razdel"] == "sh_f") {
				$("#sh3").empty();
				$("#sh3").append(data["shield"]);

				$("#list2").empty();
				$("#list2").append(data["arsenal"]);
			}
			else if (data["razdel"] == "U_f") {
				$("#sh4").empty();
				$("#sh4").append(data["shield"]);

				$("#list2").empty();
				$("#list2").append(data["arsenal"]);
			}
			else{

			};


			// $("#shield").empty();
			// $("#shield").append(data);
		}
	})
}
// ------------------------------------
// функция для добавления задачи в щит
function add(a) {
	$.ajax({
		url: "js.php",
		type: "GET",
		data: ({ add: a, add2: $("select[name='type2']").val()}),
		dataType: "html",
		success: function (data) {
			// console.log(data);
			data = JSON.parse(data);
			if (data["razdel"] == "oge") {
				$("#sh1").empty();
				$("#sh1").append(data["shield"]);

				$("#list2").empty();
				$("#list2").append(data["arsenal"]);
			}
			else if (data["razdel"] == "ege") {
				$("#sh2").empty();
				$("#sh2").append(data["shield"]);

				$("#list2").empty();
				$("#list2").append(data["arsenal"]);
			}
			else if (data["razdel"] == "sh_f") {
				$("#sh3").empty();
				$("#sh3").append(data["shield"]);

				$("#list2").empty();
				$("#list2").append(data["arsenal"]);
			}
			else if (data["razdel"] == "U_f") {
				$("#sh4").empty();
				$("#sh4").append(data["shield"]);

				$("#list2").empty();
				$("#list2").append(data["arsenal"]);
			}
			else{

			};
			// $("#shield").empty();
			// $("#shield").append(data);

		}
	})
	
};
// -----------------------------------
// функция для включения и выключения готовности
// function ready_f (a) {
// 	$.ajax({
// 		url: "js.php",
// 		type: "GET",
// 		data: ({ ready_f: a}),
// 		dataType: "html",
// 		success: function (data) {
// 			$("#ready").empty();
// 			$("#ready").append(data);
// 		}
// 	})
// };


$(document).ready(
	function () {
		$('#panel_in1').bind( 'click', 
			function(){
				$('#create').show('slow');
			}
			)
	}
	);

$(document).ready(
	function () {
		$('#backward, #new_f').bind( 'click', 
			function(){
				$('#create').hide('slow');
			}
			)
	}
	);


// $('#panel_in1').click(function () {
// 	// $('#create').show('slow');
// 	console.log('Hello');
// })

// ----------------------------------------------
// функция для показа нерешённых задач
function show_nz(a) {
	$.ajax({
		url: "js.php",
		type: "GET",
		data: ({ show_nz: a}),
		dataType: "html",
		success: function (data) {
			$("#text_z").empty();
			$("#text_z").append(data);
		}
	})
}
// ----------------------------------------
// функция для проверки решения нерешённой задачи
function check_nr() {
	$.ajax({
	url: "js.php",
	type: "POST",
	data: ({nomer_z: $("#nomer_z").val(), check_nr: $("#check_nr").val()}),
	dataType: "html",
	success: function (data) {
		
		// console.log($("#check_nr").val())
		$("#text_z").empty();
		$("#text_z").append(data);
	}
	})
	
}
// -------------------------------------------
//ползунок с минутами на арене
$(document).ready(
	function () {
		var t = $("#minuti").val() + "мин";
		$("#minuti_val").empty();
		$("#minuti_val").append(t);
		$("#minuti").bind("change mousemove",
			function () {
				t = $("#minuti").val() + "мин";
				$("#minuti_val").empty();
				$("#minuti_val").append(t);
			}
			)
	}
	);
//---------------------------------------------
//Изменение раздела в боях
// ОГЭ
// работаю
$(document).ready(
	function () {
		$("#oge").bind('click', 
			function () {
				$.ajax({
					url: "js.php",
					type: "POST",
					data: ({ razdel: "oge" }),
					dataType: "html",
					success: function (data) {
						//можно улучшить 
						$("#oge").css({"background-color": data });
						$("#sh1").show();
						$("#ars1").show();
						$("#baza1").show();
						$("#ege").css({"background-color": "#DCDCDC"});
						$("#sh2").hide();
						$("#ars2").hide();
						$("#baza2").hide();
						$("#sh_f").css({"background-color": "#DCDCDC"});
						$("#sh3").hide();
						$("#ars3").hide();
						$("#baza3").hide();
						$("#U_f").css({"background-color": "#DCDCDC"});
						$("#sh4").hide();
						$("#ars4").hide();
						$("#baza4").hide();


					}
				})
			}
			)
	}
	)
//ЕГЭ
$(document).ready(
	function () {
		$("#ege").bind('click', 
			function () {
				$.ajax({
					url: "js.php",
					type: "POST",
					data: ({ razdel: "ege" }),
					dataType: "html",
					success: function (data) {
						//можно улучшить
						$("#oge").css({"background-color": "#DCDCDC" });
						$("#sh1").hide();
						$("#ars1").hide();
						$("#baza1").hide();
						$("#ege").css({"background-color": data});
						$("#sh2").show();
						$("#ars2").show();
						$("#baza2").show();
						$("#sh_f").css({"background-color": "#DCDCDC"});
						$("#sh3").hide();
						$("#ars3").hide();
						$("#baza3").hide();
						$("#U_f").css({"background-color": "#DCDCDC"});
						$("#sh4").hide();
						$("#ars4").hide();
						$("#baza4").hide();


					}
				})
			}
			)
	}
	)
//---------------------------
// //ШК_св
$(document).ready(
	function () {
		$("#sh_f").bind('click', 
			function () {
				$.ajax({
					url: "js.php",
					type: "POST",
					data: ({ razdel: "sh_f" }),
					dataType: "html",
					success: function (data) {
						//можно улучшить
						$("#oge").css({"background-color": "#DCDCDC" });
						$("#sh1").hide();
						$("#ars1").hide();
						$("#baza1").hide();
						$("#ege").css({"background-color": "#DCDCDC"});
						$("#sh2").hide();
						$("#ars2").hide();
						$("#baza2").hide();
						$("#sh_f").css({"background-color": data});
						$("#sh3").show();
						$("#ars3").show();
						$("#baza3").show();
						$("#U_f").css({"background-color": "#DCDCDC"});
						$("#sh4").hide();
						$("#ars4").hide();
						$("#baza4").hide();


					}
				})
			}
			)
	}
	)
// //ВУЗ
$(document).ready(
	function () {
		$("#U_f").bind('click', 
			function () {
				$.ajax({
					url: "js.php",
					type: "POST",
					data: ({ razdel: "U_f" }),
					dataType: "html",
					success: function (data) {
						//можно улучшить
						$("#oge").css({"background-color": "#DCDCDC" });
						$("#sh1").hide();
						$("#ars1").hide();
						$("#baza1").hide();
						$("#ege").css({"background-color": "#DCDCDC"});
						$("#sh2").hide();
						$("#ars2").hide();
						$("#baza2").hide();
						$("#sh_f").css({"background-color": "#DCDCDC"});
						$("#sh3").hide();
						$("#ars3").hide();
						$("#baza3").hide();
						$("#U_f").css({"background-color": data});
						$("#sh4").show();
						$("#ars4").show();
						$("#baza4").show();


					}
				})
			}
			)
	}
	)
//---------------------------------------------
// Обработчик создающий предложение игры
$(document).ready(
	function () {
		$("#new_f").bind('click', 
			function () {
				$.ajax({
					url: "js.php",
					type: "POST",
					data: ({new_f: $("#minuti").val()}),
					dataType: "html",
					success: function (data) {
						 console.log(data);
					}
				})
			}
			)
	}
	)
// ------------------------------
// Функция для принятия боя check_nr
function go_f(a) {
	// console.log(a);
	$.ajax({
		url: "js.php",
		type: "POST",
		data: ({go_f:a}),
		dataType: "html",
		success: function (data) {
			console.log(data);
			
		}
	})
}
// -----------------------
