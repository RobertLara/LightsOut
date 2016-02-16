var width = 5;
var height = 5;

var curCell = -1;
var celltds = new Array(width*height);
var backColors = new Array(width*height);
var moveArr = new Array();
var prevClick = -1;
var curMoves = 0;

var req;
function recordScore() {
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	if (req) {
		var poststr = moveArr[0];
		for (var i = 1; i < curMoves; i++)
			poststr += '-' + moveArr[i];
		req.onreadystatechange = processReqChange;
		req.open("POST", "/lightsout/submit.php", true);
		req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		req.send('s='+curMoves + '&h='+poststr + '&t='+token);
	}
}

function processReqChange() {
}

function createTd(idx) {
	celltds[idx] = document.createElement('td');
	celltds[idx].id = "c" + idx;
	celltds[idx].style.fontSize = "24pt";
	celltds[idx].style.height = "1.5em";
	celltds[idx].style.width = "1.5em";
	celltds[idx].style.border = "1px solid black";
	celltds[idx].style.textAlign = "center";
	celltds[idx].onmouseover = mouseOver;
	celltds[idx].onmouseout = mouseOut;
	celltds[idx].onmousedown = mouseClick;
	celltds[idx].onselectstart = function(){return false};
	celltds[idx].onmouseup = function(){return false};
	celltds[idx].innerHTML = "&nbsp;";

	if (puzzle.charAt(idx) == '#') {
		celltds[idx].style.backgroundColor = "#999";
		backColors[idx] = "#999";
	} else {
		celltds[idx].style.backgroundColor = "#FFF";
		backColors[idx] = "#FFF";
	}
}

// create the table with all the cells
function initLightsOutGrid() {
	var mydiv = document.getElementById('contain');
	var tbl = document.createElement('table');
	var tbody = document.createElement('tbody');

	for (var i = 0; i < height; i++) {
		var newtr = document.createElement('tr');
		for (var j = 0; j < width; j++) {
			createTd(i*width+j);
			newtr.appendChild(celltds[i*width+j]);
		}
		tbody.appendChild(newtr);
	}
	tbl.appendChild(tbody);
	mydiv.appendChild(tbl);

	initAfterGrid();
}

function getEventId(e) {
	var targ;
	if (!e) var e = window.event;
	if (e.target) targ = e.target;
	else if (e.srcElement) targ = e.srcElement;
	if (targ.nodeType == 3) targ = targ.parentNode;
	return parseInt(targ.id.substring(1));
}

function mouseOver(e) {
	var idx = getEventId(e);
	curCell = idx;
}

function mouseOut(e) {
	var idx = getEventId(e);
	curCell = -1;
}



var timerID = 0;
var tstart = null;
var killTimer = false;

function updateTimer() {
	if (timerID) clearTimeout(timerID);
	if (!tstart) tstart = new Date();
	if (killTimer) return;

	var tdate = new Date();
	var tdiff = tdate.getTime() - tstart.getTime();

	var min = Math.floor(tdiff/60000), sec = Math.floor(tdiff/1000-60*min);
	var frmt = min + (sec > 9 ? ":" : ":0") + sec;
	document.getElementById('timer').innerHTML = "Time " + frmt;

	timerID = setTimeout("updateTimer()", 1000);
}

function initAfterGrid() {
	tstart = new Date();
	timerID = setTimeout("updateTimer()", 1000);
}

function toggleState(idx) {
	var ch;
	if (idx < 0) return false;
	if (idx >= width*height) return false;
	if (curpuz.charAt(idx) == ' ') {
		backColors[idx] = "#999";
		ch = '#';
	} else {
		backColors[idx] = "#FFF";
		ch = ' ';
	}
	celltds[idx].style.backgroundColor = backColors[idx];
	curpuz = curpuz.substr(0, idx) + ch + curpuz.substr(idx+1);

	return curpuz.indexOf(' ') == -1;
}

function mouseClick(e) {
	var idx = getEventId(e);
	if (curCell != idx) return true;
	if (idx == prevClick) {
		curMoves--;
		prevClick = -1;
	} else {
		moveArr[curMoves++] = idx;
		prevClick = idx;
	}
	document.getElementById('moves').innerHTML = "Moves: " + curMoves;
	if (idx >= width) toggleState(idx-width);
	if (idx%width >= 1) toggleState(idx-1);
	if (idx%width <= width-2) toggleState(idx+1);
	if (idx+width < height*width) toggleState(idx+width);
	if (toggleState(idx)) {
		killTimer = true;
		puzzleDone();
		alert("Congratulations!");
	}
	return false;
}

