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
// заменить
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
// ------------------

$(document).ready(function () {
	$("#ars_in").on("mousedown", ".accordeon_ars",
		function () {
			var n = this.id,
			// e = $(this).attr('class'),
			$this = $(this),
			list1 = $this.prevAll(),
			list2 = $this.nextAll();
			list1.removeClass('actif');
			list2.removeClass('actif');
			$this.addClass('actif');
			$.ajax({
				url: "js.php",
				type: "GET",
				data:({ type2: n}),
				dataType: "html",
				success: function (data) {
					$("#pole_zadanii").empty();
					$("#pole_zadanii").append(data);
					// console.log(data);
				}
			})
		}
		)
})
$(document).ready(function () {
	$("#accc").on("mousedown", ".accordeon_input",
		function () {
			var n = this.id,			// e = $(this).attr('class'),
			$this = $(this),
			list1 = $this.prevAll(),
			list2 = $this.nextAll();
			console.log(n);
			list1.removeClass('actif_b');
			list2.removeClass('actif_b');
			$this.addClass('actif_b');
			$.ajax({
				url: "js.php",
				type: "GET",
				data:({ type: n}),
				dataType: "html",
				success: function (data) {
					$("#pole_zadanii").empty();
					$("#pole_zadanii").append(data);
					console.log(data);
				}
			})
		}
		)
})
//функция для вывода условия задачи щита
function show_z(a) {
	$.ajax({
		url: "js.php",
		type: "GET",
		data: ({ show_z: a}),
		dataType: "html",
		success: function (data) {
			$("#pole_texta").empty();
			$("#pole_texta").append(data);
		}
	});

};
function del_z(a) {
	var v = $(".actif").attr('id');
	$.ajax({
		url: "js.php",
		type: "GET",
		data: ({ del_z: a, del_z2: v}),
		dataType: "html",
		success: function (data) {
			// console.log(data);
			data = JSON.parse(data);
			console.log(data);
			if (data["razdel"] == "oge") {
				$("#sh1").empty();
				$("#sh1").append(data["shield"]);

				$("#pole_zadanii").empty();
				$("#pole_zadanii").append(data["arsenal"]);
			}
			else if (data["razdel"] == "ege") {
				$("#sh2").empty();
				$("#sh2").append(data["shield"]);

				$("#pole_zadanii").empty();
				$("#pole_zadanii").append(data["arsenal"]);
			}
			else if (data["razdel"] == "sh_f") {
				$("#sh3").empty();
				$("#sh3").append(data["shield"]);

				$("#pole_zadanii").empty();
				$("#pole_zadanii").append(data["arsenal"]);
			}
			else if (data["razdel"] == "U_f") {
				$("#sh4").empty();
				$("#sh4").append(data["shield"]);

				$("#pole_zadanii").empty();
				$("#pole_zadanii").append(data["arsenal"]);
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
	var v = $(".actif").attr('id');
	$.ajax({
		url: "js.php",
		type: "GET",
		data: ({ add: a, add2: v}),
		dataType: "html",
		success: function (data) {
			data = JSON.parse(data);
			console.log(data["razdel"]);
			if (data["razdel"] == "oge") {
				$("#sh1").empty();
				$("#sh1").append(data["shield"]);

				$("#pole_zadanii").empty();
				$("#pole_zadanii").append(data["arsenal"]);
			}
			else if (data["razdel"] == "ege") {
				$("#sh2").empty();
				$("#sh2").append(data["shield"]);

				$("#pole_zadanii").empty();
				$("#pole_zadanii").append(data["arsenal"]);
			}
			else if (data["razdel"] == "sh_f") {
				$("#sh3").empty();
				$("#sh3").append(data["shield"]);

				$("#pole_zadanii").empty();
				$("#pole_zadanii").append(data["arsenal"]);
			}
			else if (data["razdel"] == "U_f") {
				$("#sh4").empty();
				$("#sh4").append(data["shield"]);

				$("#pole_zadanii").empty();
				$("#pole_zadanii").append(data["arsenal"]);
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
$(document).ready(
	function () {
		$("#message_close").bind('click',
			function () {
				$(".message").removeClass("message_sh");
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
			$("#pole_texta").empty();
			$("#pole_texta").append(data);
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
		console.log(data);
		// console.log($("#check_nr").val())
		data = JSON.parse(data);
		$("#message_box").empty();
		$(".message").addClass("message_sh");
		$("#message_box").append(data["message"]);
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
						console.log(data);
						data = JSON.parse(data);
						$("#oge").css({"background-color": data["color"] });
						$("#sh1").show();
						$("#ars1").show();
						$("#baza1").show();
						$("#ege").css({"background-color": "#B0C4DE"});
						$("#sh2").hide();
						$("#ars2").hide();
						$("#baza2").hide();
						$("#sh_f").css({"background-color": "#B0C4DE"});
						$("#sh3").hide();
						$("#ars3").hide();
						$("#baza3").hide();
						$("#U_f").css({"background-color": "#B0C4DE"});
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
						data = JSON.parse(data);
						$("#oge").css({"background-color": "#B0C4DE" });
						$("#sh1").hide();
						$("#ars1").hide();
						$("#baza1").hide();
						$("#ege").css({"background-color": data["color"]});
						$("#sh2").show();
						$("#ars2").show();
						$("#baza2").show();
						$("#sh_f").css({"background-color": "#B0C4DE"});
						$("#sh3").hide();
						$("#ars3").hide();
						$("#baza3").hide();
						$("#U_f").css({"background-color": "#B0C4DE"});
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
						data = JSON.parse(data);
						$("#oge").css({"background-color": "#B0C4DE" });
						$("#sh1").hide();
						$("#ars1").hide();
						$("#baza1").hide();
						$("#ege").css({"background-color": "#B0C4DE"});
						$("#sh2").hide();
						$("#ars2").hide();
						$("#baza2").hide();
						$("#sh_f").css({"background-color": data["color"]});
						$("#sh3").show();
						$("#ars3").show();
						$("#baza3").show();
						$("#U_f").css({"background-color": "#B0C4DE"});
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
						data = JSON.parse(data);
						$("#oge").css({"background-color": "#B0C4DE" });
						$("#sh1").hide();
						$("#ars1").hide();
						$("#baza1").hide();
						$("#ege").css({"background-color": "#B0C4DE"});
						$("#sh2").hide();
						$("#ars2").hide();
						$("#baza2").hide();
						$("#sh_f").css({"background-color": "#B0C4DE"});
						$("#sh3").hide();
						$("#ars3").hide();
						$("#baza3").hide();
						$("#U_f").css({"background-color": data["color"]});
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
// всплывающее окно
$(document).ready(function () {
	
	$("#go").click(function () {
		$(".popup_fast").addClass("activ");
		console.log("go");
	})
})
$(document).ready(function () {
	
	$("#cloze").click(function () {
		$(".popup_fast").removeClass("activ");
		console.log("go");
	})
})
// ---------------