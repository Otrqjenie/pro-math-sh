var  request;
if (window.XMLHttpRequest) {
	request =  new XMLHttpRequest();
} else{ 
	request = new ActiveXObject("Microsoft.XMLHTTP");
};
var d = document.getElementById('rrr')
request.open('GET', 'data.txt');
request.onreadystatechange = function () {
	if ((request.readyState === 4) && (request.status === 200)) {
		console.log(request);
		d.innerHTML = request.responseText;
	};
}
request.send();
