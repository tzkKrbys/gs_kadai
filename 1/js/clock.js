$(function () {
	var sr;
	var mr;
	var hr;
	var clock = document.getElementById('clock');
	var timerIdClock;
	var clockColorChanging = true;
	function kaiten(){
		var todayClock = new Date();
		var hC = todayClock.getHours();
		var mC = todayClock.getMinutes();
		var sC = todayClock.getSeconds();
		srDeg = sC * 6;
		mrDeg = ( mC * 6 ) + ( 360 / 60 / 60 * sC );
		hrDeg = ( hC * 30 ) + ( 360 / 12 / 60 * mC);
		$('#byousin').css('transform', 'rotate(' + srDeg + 'deg)');
		$('#byousin').css('-webkit-transform', 'rotate('+srDeg+'deg)');
		$('#tyoushin').css('transform', 'rotate(' + mrDeg + 'deg)');
		$('#tyoushin').css('-webkit-transform', 'rotate(' + mrDeg + 'deg)');
		$('#tannshin').css('transform', 'rotate(' + hrDeg + 'deg)');
		$('#tannshin').css('-webkit-transform', 'rotate(' + hrDeg + 'deg)');
		setTimeout(kaiten,1000);
	}
	kaiten();
	function changeClockColor(){
		var nowTime = new Date();
		var s = nowTime.getSeconds();
		if(s % 2 == 0){
			clock.className = 'blue';
		}else{
			clock.className = '';
		}
		timerIdClock = setTimeout(changeClockColor,1000);
	}
	changeClockColor();
	
	function clearTimerIdClock(){
		console.log("ダブルクリック");
		console.log(clockColorChanging);
		if(clockColorChanging){
			clearTimeout(timerIdClock);
			clockColorChanging = false;
		}else{
			changeClockColor();
			clockColorChanging = true;
		}
	}
	clock.addEventListener('dblclick', clearTimerIdClock,false);

	console.log(clock);
});