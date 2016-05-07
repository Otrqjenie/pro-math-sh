
var i = 0;
var r = document.getElementById('rrr');


f = function fire () {
	var delay = 50,
	i = 0,
	j = 4;
	startTimer = function () {
		// console.log('функция startTimer  сработала');
		var elem = document.getElementById('circle');
		

		bottom = elem.offsetLeft;
		 bottom2 = elem.offsetTop;
		if(i<40){
			setTimeout(startTimer, delay);
			elem.style.left = bottom + 15 +'px';
			j = j - 1/5;
			bottom2 = bottom2 - j;
			elem.style.top = bottom2 +'px';
		}
		else{

			elem.style.left = 420 + 'px';
			elem.style.top = 330 + 'px'
		}
		i++;
	}
	var timer = setTimeout(startTimer, delay);
}

count = function countt () {
	r.innerHTML = "нажали";
}
r.addEventListener("click", f, false);