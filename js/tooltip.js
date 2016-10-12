var offsetfromcursorX = 12;
var offsetfromcursorY = 10;
var offsetdivfrompointerX = 10;
var offsetdivfrompointerY = 14;

document.write('<div id="dhtmltooltip"></div>');


var tooltip_ie = document.all;
var tooltip_ns6 = document.getElementById && ! document.all;
var enabletip = false;

if (tooltip_ie || tooltip_ns6)
	var tooltip_tipobj = document.all ? document.all["dhtmltooltip"] : document.getElementById ? document.getElementById("dhtmltooltip") : "";

var pointerobj = document.all ? document.all["dhtmlpointer"] : document.getElementById ? document.getElementById("dhtmlpointer") : "";

function ietruebody() {
	return (document.compatMode && document.compatMode != "BackCompat") ? document.documentElement : document.body;
}

function showtip(thetext, thewidth, thecolor) {
	if (tooltip_ns6 || tooltip_ie) {
		if (typeof thewidth != "undefined")
			tooltip_tipobj.style.width = thewidth + "px";
		if (typeof thecolor != "undefined" && thecolor != "")
			tooltip_tipobj.style.backgroundColor = thecolor;
		tooltip_tipobj.innerHTML = thetext;
		tooltip_tipobj.onmouseout = hidetip;
		enabletip = true;
		return false;
	}
}

function positiontip(e) {
	if (enabletip) {
		var nondefaultpos = false;
		var curX = (tooltip_ns6) ? e.pageX : event.clientX + ietruebody().scrollLeft;
		var curY = (tooltip_ns6) ? e.pageY : event.clientY + ietruebody().scrollTop;
		
		var winwidth = tooltip_ie && ! window.opera ? ietruebody().clientWidth : window.innerWidth - 20;
		var winheight = tooltip_ie && ! window.opera ? ietruebody().clientHeight : window.innerHeight - 20;

		var rightedge = tooltip_ie && ! window.opera ? winwidth - event.clientX - offsetfromcursorX : winwidth - e.clientX - offsetfromcursorX;
		var bottomedge = tooltip_ie && ! window.opera ? winheight - event.clientY - offsetfromcursorY : winheight - e.clientY - offsetfromcursorY;

		var leftedge = (offsetfromcursorX < 0) ? offsetfromcursorX * (- 1) : - 1000;

		if (rightedge < tooltip_tipobj.offsetWidth) {
			tooltip_tipobj.style.left = curX - tooltip_tipobj.offsetWidth + "px";
			nondefaultpos = true;
		}
		else if (curX < leftedge)
			tooltip_tipobj.style.left = "5px";
		else {
			tooltip_tipobj.style.left = curX + offsetfromcursorX - offsetdivfrompointerX + "px";
			pointerobj.style.left = curX + offsetfromcursorX + "px";
		}

		if (bottomedge < tooltip_tipobj.offsetHeight) {
			tooltip_tipobj.style.top = curY - tooltip_tipobj.offsetHeight - offsetfromcursorY + "px";
			nondefaultpos = true;
		}
		else {
			tooltip_tipobj.style.top = curY + offsetfromcursorY + offsetdivfrompointerY + "px";
			pointerobj.style.top = curY + offsetfromcursorY + "px";
		}

		tooltip_tipobj.style.visibility = "visible";

		if (! nondefaultpos)
			pointerobj.style.visibility = "visible";
		else
			pointerobj.style.visibility = "hidden";
	}
}

function hidetip() {
	if (tooltip_ns6 || tooltip_ie) {
		enabletip = false;
		tooltip_tipobj.style.visibility = "hidden";
		pointerobj.style.visibility = "hidden";
		tooltip_tipobj.style.left = "-1000px";
		tooltip_tipobj.style.backgroundColor = '';
		tooltip_tipobj.style.width = '';
	}
}

document.onmousemove = positiontip;