//var cx = document.querySelector("canvas").getContext("2d");
//var img = document.createElement("img");
//img.src = "img/child.png";
//img.style = "position:absolute; left:100px; top:100px;";
//img.onmousedown = "drag(this, event);"
//img.addEventListener("load", function(){
	//for(var x = 10; x < 200; x += 30)
//		cx.drawImage(img, 10, 10);
//});
var input = document.querySelector("button");
input.addEventListener("click", function()
{
	var output = document.getElementById("sp");
	output.innerHTML = "Hello!";
});