//стереть--------------------------
function drag (elementTodrag, event){
	var startX = event.clientX;
	var startY = event.clientY;
	
	var origX = element.ToDrag.offsetLeft;
	var origY = element.ToDrag.offsetTop;
	
	var deltaX = startX - origX;
	var deltaY = startY - origY;
	
	if(document.addEventListener){
		document.addEventListener("mousemove", moveHandler, true);
		document.addEventListener("mouseup, upHandler", true);
	}
	else if (document.attachEvent){
	elementToDrag.setCapture();
	elementToDrag.attachEvent("onmousemove",moveHandler);
	elementToDrag.attachEvent("onmouseup", upHandler);
	elementToDrag.attachEvent("onlosecapture", upHendler);
	}
	if (event.stopPropagation) event.stopPropagation();
	else event.cancelBubble = true;
	
	if (eventpreventDefault) event.preventDefault();
	else event.returnValue = false;
	
	function moveHandler(e){
		if(!e) e = window.event;
		var scroll = getScrolloffsets();
		elementToDrag.style.left = (e.clientX + scroll.x - deltaX) + "px";
		elementToDrag.style.top = (e.clientY + scroll.y - deltaY) + "px";
		
		if(e.stopPropagation) e.stopPropagation();
		else e.cancelBubble = true;
	}
	function upHandler(e){
		if(!e) e = window.event;
		if(document.removeEventListener){
			document.removeEventListener("mouseup", upHendler, true);
			document.removeEventListener("mousemove", moveHandler, true)
		}
		else if(document.detachEvent){
			elementToDrag.detachEvent("onlosecapture", upHandler);
			elementToDrag.detachEvent("onmouseup", upHandler);
			elementToDrag.detachEvent("onmousemuve", moveHandler);
			elementToDrag.releaseCapture();
		}
		if(e.stopPropagation) e.stopPropagation();
		else e.cancelBubble = true;
	}
}
//стереть--------------------------