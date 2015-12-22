(function () {

	window.onload = setInterval(function () {
		//曜日配列
		var youbi = ["日", "月", "火", "水", "木", "金", "土"];
		//日時取得
		var now = new Date();
		var year = now.getFullYear();
		var month = now.getMonth() + 1; //+１を入れる。
		var date = now.getDate();
		var day = now.getDay();
		var h = now.getHours();
		var m = now.getMinutes();
		var s = now.getSeconds();
		var ms = now.getMilliseconds();
		//日時表示文字列の作成
		var str = year + "-" + month + "-" + date + "(" + youbi[day] + ") " + h + ":" + m + ":" + s;
		//div要素id属性mainを指定
		var index = document.getElementById('index');

		if (s > 50) {
			index.style.backgroundColor = "#ff0000";
		} else if (s > 40) {
			index.style.backgroundColor = "#d72dff";
		} else if (s > 30) {
			index.style.backgroundColor = "#3d44ff";
		} else if (s > 20) {
			index.style.backgroundColor = "#49eaff";
		} else if (s > 10) {
			index.style.backgroundColor = "#42ff75";
		} else {
			index.style.backgroundColor = "#e4ff52";
		}
	}, 1000);

/*	window.onload = function(){
		var byousin = document.getElementById('byousin');
		byousin.style.webkitTransform = "rotate('120deg')";
		byousin.style.transform = "rotate('120deg')";
		console.dir(byousin);
	};*/
})();


