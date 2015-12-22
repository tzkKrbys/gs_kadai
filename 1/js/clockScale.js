$(function () {
	var index = document.getElementById('index');
	var today = new Date();
	var h = today.getHours();
	var m = today.getMinutes();
	var s = today.getSeconds();
	var picArr = [
		'url(images/hoshizora08.jpg)',
		'url(images/hoshizora09.jpg)',
		'url(images/hoshizora10.jpg)',
		'url(images/asayake00.jpg)',
		'url(images/asayake01.jpg)',
		'url(images/asayake02.jpg)',
		'url(images/asayake03.jpg)',
		'url(images/asayake04.jpg)',
		'url(images/montmartre.jpg)',
		'url(images/SacreCoeur.jpg)',
		'url(images/Louvre.jpg)',
		'url(images/Versailles00.jpg)',
		'url(images/Versailles01.jpg)',
		'url(images/Versailles02.jpg)',
		'url(images/Versailles03.jpg)',
		'url(images/ChampsElysees.jpg)',
		'url(images/hoshizora00.jpg)',
		'url(images/hoshizora01.jpg)',
		'url(images/hoshizora02.jpg)',
		'url(images/hoshizora03.jpg)',
		'url(images/hoshizora04.jpg)',
		'url(images/hoshizora05.jpg)',
		'url(images/hoshizora06.jpg)',
		'url(images/hoshizora07.jpg)',
		'url(images/popula.jpg)',
		'url(images/sunrise.jpg)',
		'url(images/yuuyake.jpg)',
		'url(images/cheese.jpg)'];
	var yajirushi = document.getElementById('yajirushi');
	yajirushi.style.top = h * 20 + 'px';
	backgroundColorChange(h);
	$("#clockScale").draggable({
		containment: "parent",
		snap: "body",
		axis: "x",
		opacity: 0.3
	});
	$("#yajirushi").draggable({
		containment: "parent",
		grid: [20, 20],
		drag: function (event, ui) {
			console.log(ui.position.top);
		}
	});
	$("#clockScale").droppable({
		accept: "#yajirushi",
		drop: function (event, ui) {
			console.log(ui.position.top);
			console.log(ui.position.top / 20);
			var hh = ui.position.top / 20;
			backgroundColorChange(hh);
		}
	});
	$("#clock").draggable({
		opacity: 0.4
	});
	var timerID;
	var prev;


	function randomPict() {
		var i = Math.floor(Math.random() * picArr.length);

		if (i == prev) {
			console.log("同じ画像だよ");
			randomPict();
		} else {
			index.style.backgroundImage = picArr[i];
			prev = i;
			timerID = setTimeout(randomPict, 6000);
		}

	}

	function backgroundColorChange(x) {
		index.style.backgroundImage = 'none';
		index.style.backgroundColor = '#000';
/*		index.style.backgroundSize = 'cover';
		index.style.backgroundAttachment = 'fixed';
		index.style.backgroundPosition = 'center center';*/
		clearTimeout(timerID);
		switch (x) {
		case 0:
			index.style.backgroundImage = picArr[0];
			break;
		case 1:
			index.style.backgroundImage = picArr[1];
			break;
		case 2:
			index.style.backgroundImage = picArr[2];
			break;
		case 3:
			index.style.backgroundImage = picArr[3];
			break;
		case 4:
			index.style.backgroundImage = picArr[4];
			break;
		case 5:
			index.style.backgroundImage = picArr[5];
			break;
		case 6:
			index.style.backgroundImage = picArr[6];
			break;
		case 7:
			index.style.backgroundImage = picArr[7];
			break;
		case 8:
			index.style.backgroundImage = picArr[8];
			break;
		case 9:
			index.style.backgroundImage = picArr[9];
			break;
		case 10:
			index.style.backgroundImage = picArr[10];
			break;
		case 11:
			index.style.backgroundImage = picArr[11];
			break;
		case 12:
			index.style.backgroundImage = picArr[12];
			break;
		case 13:
			index.style.backgroundImage = picArr[13];
			break;
		case 14:
			index.style.backgroundImage = picArr[14];
			break;
		case 15:
			index.style.backgroundImage = picArr[15];
			break;
		case 16:
			index.style.backgroundImage = picArr[16];
			break;
		case 17:
			index.style.backgroundImage = picArr[17];
			break;
		case 18:
			index.style.backgroundImage = picArr[18];
			break;
		case 19:
			index.style.backgroundImage = picArr[19];
			break;
		case 20:
			index.style.backgroundImage = picArr[20];
			break;
		case 21:
			index.style.backgroundImage = picArr[21];
			break;
		case 22:
			index.style.backgroundImage = picArr[22];
			break;
		case 23:
			index.style.backgroundImage = picArr[23];
			break;
		case 24:
			index.style.backgroundImage = picArr[24];
			break;
		case 25:
			index.style.backgroundImage = picArr[25];
			break;
		case 26:
			index.style.backgroundImage = picArr[26];
			break;
		case 27:
			index.style.backgroundImage = picArr[27];
			break;
		case 28:
			index.style.backgroundColor = 'none';
			randomPict();
			break;
		}
	}
});