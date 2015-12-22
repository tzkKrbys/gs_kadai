$(function () {
	
	var remarkSound = $('#remarkSound')[0];
	var paper_round = $('#paper_round')[0];
	var latlonBtn = document.getElementById('latlonBtn');
	latlonBtn.disabled = true;
	
	function getNow() {
		//曜日配列
		var youbi = ["日", "月", "火", "水", "木", "金", "土"];
		//日時取得
		var now = new Date();
		var year = now.getFullYear();
		//var month = now.getMonth() + 1; //+１を入れる。
		var month = ("0"+(now.getMonth() + 1)).slice(-2);//+１を入れる。二桁目に0を入れる
		
		var date = ('0' + now.getDate()).slice(-2);//二桁目に0を入れる
		var day = now.getDay();var day = now.getDay();
		var h = ('0' + now.getHours()).slice(-2);//二桁目に0を入れる
		var m = ('0' + now.getMinutes()).slice(-2);//二桁目に0を入れる
		var s = ('0' + now.getSeconds()).slice(-2);//二桁目に0を入れる
		//日時表示文字列の作成
		var str = year + "-" + month + "-" + date + "(" + youbi[day] + ") " + h + ":" + m + ":" + s;
		return str;
	}



	//var milkcocoa = new MilkCocoa("yieldiakgatpz.mlkcca.com"); //idをコピペで上書き
	var milkcocoa = new MilkCocoa("maxiap2ru1r.mlkcca.com");
	/* your-app-id にアプリ作成時に発行されるapp-idを記入します */
	var chatDataStore = milkcocoa.dataStore('gsacChat');

	chatDataStore.stream().sort('desc').size(100).next(function (err, data) {//最新から100件のデータを取得するためsortをdescに指定
		$.each(data, function (i, v) {
			addText(v.value, v.id);
		});
	});


	var textArea, board;
	window.onload = function () {
		textArea = document.getElementById("msg");
		board = document.getElementById("board");
	}

	function clickEvent() {
		var text = textArea.value;
		text = text.replace(/\r?\n/g, '<br>');
		sendText(text);
	}
	$("#sendMessage").on("click", clickEvent);

	//送信用メソッド
	function sendText(text) {
		var name = $("#name").val();
		var facebookId = $("#facebookId").val();
		var twitterId = $("#twitterId").val();
		localStorage.setItem('name',name);
		if(!twitterId){
			localStorage.setItem('facebookId',facebookId);
			localStorage.setItem('twitterId','');
		}else{
			localStorage.setItem('facebookId','');
			localStorage.setItem('twitterId',twitterId);
		}
		if(!textArea.value){
			console.log("送信せず!");
			return;
		}
		chatDataStore.push({
			message: text,
			name: name,
			input_date: getNow(),
			facebookId: facebookId,
			twitterId:twitterId
		});
		console.log("送信完了!");
		textArea.value = "";

		
		/*var comment = text;
		if(comment){
			console.log(1);
			conn.send({type: 'comment', text: comment});
		}*/
	}

	//データ受信（milkcocoa受信メソッド）
	chatDataStore.on("push", function (data) { //pushをsendにするとデータベースに保存可能
		addText(data.value,data.id);
		console.log(data);
	});

	function addText(text,id) {
		var msgDom = document.createElement("li");
		if(text.name == localStorage.getItem("name")){
			msgDom.className = "testMe";
		}else{
			msgDom.className = "test";
		}

		text.twitterId = text.twitterId.replace(/\s+/g, "");
		if(text.twitterId.indexOf('@') != -1 ){
			text.twitterId = text.twitterId.substr(1);
		}

		if(text.lat && text.lon){
			if(!text.twitterId){
				msgDom.innerHTML = '<span class="text_name">' + text.name + '</span><div class="clearfix"><img src="https://graph.facebook.com/' + text.facebookId + '/picture?type=small"><span class="text_message"><a href="http://maps.google.co.jp/maps?q=loc:' + text.lat +',' + text.lon + '" target=”_blank”>http://maps.google.co.jp/maps?q=loc:' + text.lat +',' + text.lon + '</a>' + '</span></div><span class="text_Time">' + text.input_date + '</span><span class="id">' + id + '</span>';
			}else{
				msgDom.innerHTML = '<span class="text_name">' + text.name + '</span><div class="clearfix"><img src="http://www.paper-glasses.com/api/twipi/' + text.twitterId + '"><span class="text_message"><a href="http://maps.google.co.jp/maps?q=loc:' + text.lat +',' + text.lon + '" target=”_blank”>http://maps.google.co.jp/maps?q=loc:' + text.lat +',' + text.lon + '</a>' + '</span></div><span class="text_Time">' + text.input_date + '</span><span class="id">' + id + '</span>';
			}
		}else{
			if(!text.twitterId){
				msgDom.innerHTML = '<span class="text_name">' + text.name + '</span><div class="clearfix"><img src="https://graph.facebook.com/' + text.facebookId + '/picture?type=small"><span class="text_message">' + text.message + '</span></div><span class="text_Time">' + text.input_date + '</span><span class="id">' + id + '</span>';
			}else{
				msgDom.innerHTML = '<span class="text_name">' + text.name + '</span><div class="clearfix"><img src="http://www.paper-glasses.com/api/twipi/' + text.twitterId + '"><span class="text_message">' + text.message + '</span></div><span class="text_Time">' + text.input_date + '</span><span class="id">' + id + '</span>';
			}
		}
		

		
		/*if(!board.lastChild){
			board.insertBefore(msgDom, board.lastChild);
		}else{
			board.insertBefore(msgDom, board.lastChild.nextSibling);
		
		}*/
		$('#board').append(msgDom);
		scrollSet();
		remarkSound.play();
	}

	function scrollSet(){
		$("#board")[0].scrollTop = $("#board")[0].scrollHeight; //CSS:overflowで表示領域を固定が必須
	}
	
	var nameRireki = localStorage.getItem('name');
	$("#name").val(nameRireki);
	var facebookRireki = localStorage.getItem('facebookId');
	$("#facebookId").val(facebookRireki);
	var twitterRireki = localStorage.getItem('twitterId');
	$("#twitterId").val(twitterRireki);
	

	$("#board").on("dblclick",'li',function(){
		if($(this).find('.text_name').text() != localStorage.getItem("name")) return;
		// 「OK」時の処理開始 ＋ 確認ダイアログの表示
		if(window.confirm('発言を削除しますか？')){
			paper_round.pause();
			paper_round.currentTime = 0;
			paper_round.play();
			chatDataStore.remove($(this).find('span.id').text());
			$(this).remove();//削除処理
			
		}// 「OK」時の処理終了
		
		else{// 「キャンセル」時の処理開始
			window.alert('キャンセルされました'); // 警告ダイアログを表示
		}
	});
	
	$(document).on("keydown", "#msg", function(e) {
		if (e.keyCode == 13) { // Enterが押された
			$.noop();//何もしないことを明示的に記述
			if (e.shiftKey) { // Shiftキーも押された
				//$.noop();
				clickEvent();
				return false;
			}
		} else {
			$.noop();//何もしないことを明示的に記述
		}
	});
	
	console.log(milkcocoa);
	console.log(chatDataStore);
	milkcocoa.user(function(err, user) {
		if(err) {
			//error
			return;
		}
		if(user) {
			console.log("Logged in", user);
		}else{
			console.log("Not logged in");
		}
	});
	
	
	
	
	
	
	
	
	$('#mute').on('change',function(){
		if($('#mute').prop("checked")){
			audioOnOff = "off";
			localStorage.setItem("audioOnOff","off");
		}else{
			audioOnOff = "on";
			localStorage.setItem("audioOnOff","on");
		}
	});
	
	
	
	var audioOnOff;
	if(localStorage.getItem("audioOnOff")){
		//alert('あり');
		//alert(localStorage.getItem("audioOnOff"));
		if(localStorage.getItem("audioOnOff") === "off"){
			//alert('off');
			$('#mute').prop('checked',true);
			localStorage.setItem("audioOnOff", "off");
			audioOn = false;
		}else if(localStorage.getItem("audioOnOff") === "on"){
			//alert('on');
			$('#mute').prop('checked',false);
			localStorage.setItem("audioOnOff", "on");
			audioOn = true;
		}
	}else{
		//alert('なし');
		$('#mute').prop('checked',true);
		localStorage.setItem("audioOnOff", "off");
		audioOn = false;
	}

	
	/*
	audioOn = localStorage.getItem("audioOn");
	console.log(audioOn);
	if(audioOn == true){
		alert(true);
		alert(audioOn);
		$('#mute').prop('checked',true);
	}else{
		alert(false);
		alert(audioOn);
		$('#mute').prop('checked',false);
	}
	console.log(localStorage.getItem("audioOn"));

	*/
	
	
	
	navigator.getUserMedia = navigator.getUserMedia ||
		navigator.webkitGetUserMedia ||
		navigator.mozGetUserMedia ||
		navigator.msGetUserMedia;
	
	var waku =document.getElementById('waku');
	var audioOn;
	
	navigator.getUserMedia({
		audio: audioOn,//ハウリング防止のため
		video: true
	}, function (stream) {// 成功時の処理
		console.log(stream);
		var video = document.createElement('video');
		video.src = window.URL.createObjectURL(stream);
		video.autoplay = true;
		waku.appendChild(video);
		
		
		/*
		var context = window.AudioContext || window.webkitAudioContext;
		var ctx = new context();
		var source = ctx.createBufferSource();
		var micNode = ctx.createMediaStreamSource(stream);
		console.log(micNode);
		micNode.connect(ctx.destination);
		var micGain;
		micGain = ctx.createGain();
		micGain.gain.value = 0;
		micNode.connect(micGain);
		source.connect(micGain);
		var output = ctx.createMediaStreamDestination();
		micGain.connect(output);
		micGain.connect(ctx.destination);
		micNode.disconnect(ctx.distination);
		*/
		
		
		
		
		
		var conns = [];
		
		var peer = new Peer('tzkrVIDEOHAISHIN',{//他のpeerへ接続できるpeerです。また、他のpeerからのコネクションをlistenできます。'tzkrVIDEOHAISHIN'は他のピアがこのピアへ接続するときに使われるIDです。もしIDが指定されない場合、ブローカサーバがIDを生成します。
			key: 'n6uyfx9vrs1hsemi'//クラウド上のPeerServerを利用するためのAPIキーです。
		}); // PeerJSのサイトで取得したAPI keyを設定
		peer.on('connection',function(conn){//リモートピアと新しいdata connectionが確立すると発生します。connはdataConnection
			peer.call(conn.peer, stream);//var mediaConnection = peer.call(id, stream); idで指定されたリモートのpeer（conn.peer）へ発信し、media connectionを返します。conn.peerはコネクションの相手側のpeer IDです。

			conns.push(conn);//conns配列の最後にconn（受信したコメント）を追加
			conn.on('data',function (data){//リモートpeerのconn（はdataConnection）からコメントデータを受信した場合
				conns.forEach(function (conn){//conns配列内のデータを
					conn.send(data);//conn（はdataConnection）へデータを送信
				});
				
				//コメントデータを受け取った際に、自分の動画部分にコメントを流す
				if(data.type === 'comment'){//受け取ったデータのタイプがコメントだった場合
					function commentFlow(){
						var comment = document.createElement('div');
						comment.className = 'comment';
						var text = data.text;
						text = text.replace(/<br>/g,' ');//改行を半角スペースに変換
						comment.textContent = text;
						console.log(comment.textContent);
						waku.appendChild(comment);
						comment.style.top = Math.floor(Math.random() * (waku.offsetHeight - 80)) + 'px';
						console.log(waku.offsetHeight);
						comment.style.left = - comment.offsetWidth + 'px';
						setTimeout(function(){
							waku.removeChild(comment);
						},7000);
					}
					commentFlow();
				}
			});
			
			
			
		});
		
		
		
	}, function (err) { // 失敗時の処理(
		console.log(err);
		alert("エラーが発生しました。:" + err.name);
	});

	
	
	
	
	
	
	
	
	
	//位置情報共有部分-------------------------------------
	//この中に処理を記述 開始
	var lat, lon;
	if (navigator.geolocation) {
		// 現在の位置情報取得を実施
		navigator.geolocation.getCurrentPosition(
			// 位置情報取得成功時
			function (pos) {
				var location = "<li>" + "緯度：" + pos.coords.latitude + "</li>";
				location += "<li>" + "経度：" + pos.coords.longitude + "</li>";
				//document.getElementById("location").innerHTML = location;
				lat = pos.coords.latitude;
				lon = pos.coords.longitude;
				//setMarker(lat, lon);
				console.log(lat);
				console.log(lon);
				console.log('取得成功');
				latlonBtn.disabled = false;
			},
			// 位置情報取得失敗時
			function (error) {
				var message = "";
				switch (error.code) {
						// 位置情報取得できない場合
					case error.POSITION_UNAVAILABLE:
						message = "位置情報の取得ができませんでした。";
						break;
						// Geolocation使用許可されない場合
					case error.PERMISSION_DENIED:
						message = "位置情報取得の使用許可がされませんでした。";
						break;
						// タイムアウトした場合 
					case error.PERMISSION_DENIED_TIMEOUT:
						message = "位置情報取得中にタイムアウトしました。";
						break;
				}
				window.alert(message);
			});
	} else {
		window.alert("本ブラウザではGeolocationが使えません");
	}
//}
	
	

	latlonBtn.addEventListener('click',function(){
		var text = textArea.value;
		text = text.replace(/\r?\n/g, '<br>');
		sendMap(text,lat,lon);
	});
	
	
	//位置情報送信用メソッド
	function sendMap(text,lat,lon) {
		if(!lat || !lon){
			console.log("送信せず!");
			return;
		}
		var name = $("#name").val();
		var facebookId = $("#facebookId").val();
		var twitterId = $("#twitterId").val();
		console.log(name);
		chatDataStore.push({
			message: text,
			name: name,
			input_date: getNow(),
			facebookId: facebookId,
			twitterId:twitterId,
			lat:lat,
			lon:lon,
		});
		console.log("送信完了!");
		textArea.value = "";
		localStorage.setItem('name',name);
		if(!twitterId){
			localStorage.setItem('facebookId',facebookId);
			localStorage.setItem('twitterId','');
		}else{
			localStorage.setItem('facebookId','');
			localStorage.setItem('twitterId',twitterId);
		}
	}

	
});