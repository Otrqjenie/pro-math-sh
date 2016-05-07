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
})
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
})