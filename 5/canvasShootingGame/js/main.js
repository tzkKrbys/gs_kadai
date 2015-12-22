	// - global -------------------------------------------------------------------
	var screenCanvas, info;
	var run = false /*true*/ ;
	var fps = 1000 / 30;
	var mouse = new Point();
	var ctx; // canvas2d コンテキスト格納用
	var fire = false;
	var counter = 0;
	var score = 0;
	var bestScore = 0;
	var message = '';
	var message2 = '';
	// - const --------------------------------------------------------------------
	var CHARA_COLOR = 'rgba(0, 0, 255, 0.75)';
	var CHARA_SHOT_COLOR = 'rgba(255, 255, 125, 1)';
	var CHARA_SHOT_MAX_COUNT = 40;
	var ENEMY_COLOR = 'rgba(255, 0, 0, 0.75)';
	var ENEMY_MAX_COUNT = 10;
	var ENEMY_SHOT_COLOR = 'rgba(255, 200, 230, 1)';
	var ENEMY_SHOT_MAX_COUNT = 100;
	var BOSS_COLOR = 'rgba(128, 128, 128, 0.75)';
	var BOSS_BIT_COLOR = 'rgba(64, 64, 64, 0.75)';
	var BOSS_BIT_COUNT = 5;


	var STAR_COLOR = 'rgba(255, 255, 255, 1)';
	var STAR_MAX_COUNT = 40;
	var starFire = false;


	var win = false;
	// - main ---------------------------------------------------------------------
	window.onload = function /*gameStart*/ () {
		var hareta = document.querySelector('#hareta');
		var explosion = document.querySelector('#explosion');
		var explosion2 = document.querySelector('#explosion2');
		var bomb = document.querySelector('#bomb');
		var shot_struck1 = document.querySelector('#shot_struck1');
		var shoot = document.querySelector('#shoot');
		shoot.volume = 0.2;
		var ff4_09_fanfare = document.querySelector('#ff4_09_fanfare');
		var pi00 = document.querySelector('#pi00');
		var pico00 = document.querySelector('#pico00');
		var buin00 = document.querySelector('#buin00');

		if(localStorage.getItem("bestScore")){
			bestScore = localStorage.getItem("bestScore");
		}

		var i, j;
		var p = new Point();

		// スクリーンの初期化
		screenCanvas = document.getElementById('screenCanvas');
		screenCanvas.width = 1366;
		screenCanvas.height = 600;




		// 自機の初期位置を修正
		mouse.x = 100;
		mouse.y = screenCanvas.height / 2;


		// 2dコンテキスト
		ctx = screenCanvas.getContext('2d');

		// イベントの登録
		screenCanvas.addEventListener('mousemove', mouseMove, true);
		screenCanvas.addEventListener('mousedown', mouseDown, true);
		window.addEventListener('keydown', keyDown, true);

		// その他のエレメント関連
		info = document.getElementById('info');

		
		// 自機初期化------------------------------------------
		var chara = new Character();
		chara.init(25,1);

		
		var charaShot = new Array(CHARA_SHOT_MAX_COUNT);
		for (i = 0; i < CHARA_SHOT_MAX_COUNT; i++) {
			charaShot[i] = new CharacterShot();
		}


		var enemy = new Array(ENEMY_MAX_COUNT);
		for (i = 0; i < ENEMY_MAX_COUNT; i++) {
			enemy[i] = new Enemy();
		}

		var enemyShot = new Array(ENEMY_SHOT_MAX_COUNT);
		for (i = 0; i < ENEMY_SHOT_MAX_COUNT; i++) {
			enemyShot[i] = new EnemyShot();
		}


		// ボス初期化
		var boss = new Boss();

		// ボスのビットを初期化
		var bit = new Array(BOSS_BIT_COUNT);
		for (i = 0; i < BOSS_BIT_COUNT; i++) {
			bit[i] = new Bit();
		}




		var stars = new Array(STAR_MAX_COUNT);
		for (i = 0; i < STAR_MAX_COUNT; i++) {
			stars[i] = new Star();
		}


		function gameStart() {
			ff4_09_fanfare.pause();
			ff4_09_fanfare.currentTime = 0;
			hareta.pause();
			hareta.currentTime = 0;
			hareta.play();
			win = false;
			run = true;
			var bgx = 1400; //土星画像の配置x座標
			// レンダリング処理を呼び出す
			(function () {
				counter++; //フレーム数をカウント
				// screenクリア
				ctx.clearRect(0, 0, screenCanvas.width, screenCanvas.height);

				//----------------------土星の画像-------------------------
				bgx -= 1;
				ctx.beginPath();
				var saturnImg = new Image(); //イメージオブジェクトの作成
				saturnImg.src = "images/saturn600.jpg"; //URLの設定
				ctx.drawImage(saturnImg, bgx, 300);
				ctx.fill();

				//----------------------スター-------------------------------
				// fireフラグの値により分岐
				/*if (starFire) {*/
				if (counter % 15 === 0) {
					// すべての自機ショットを調査する
					for (i = 0; i < STAR_MAX_COUNT; i++) {
						// 自機ショットが既に発射されているかチェック
						if (!stars[i].alive) {
							// 自機ショットを新規にセット
							stars[i].set(Star.position, 1, 3, Math.floor(Math.random() * 3)); //自機ショットのスピード設定

							// ループを抜ける
							break;
						}
					}
					// フラグを降ろしておく
					/*starFire = false;*/
				}
				/*if(counter % 500){
							starFire = true;
						}*/
				// パスの設定を開始
				ctx.beginPath();
				// すべてのスターを調査する
				for (i = 0; i < STAR_MAX_COUNT; i++) {
					// スターの生存フラグをチェック
					if (stars[i].alive) {
						// スターを動かす
						stars[i].move();

						// スターを描くパスを設定
						ctx.arc(
							stars[i].position.x,
							stars[i].position.y,
							stars[i].size,
							0, Math.PI * 2, false
						);
						// パスをいったん閉じる
						ctx.closePath();
					}
				}
				ctx.fillStyle = STAR_COLOR;
				//スターを書く
				ctx.fill();





				//自機------------------------------------------------------------------
				// パスの設定を開始
				ctx.beginPath();
				// 自機の位置を設定
				chara.position.x = mouse.x;
				chara.position.y = mouse.y;
				// 自機を描くパスを設定
				//ctx.arc(chara.position.x, chara.position.y, chara.size, 0, Math.PI * 2, false);
				// 自機の色を設定する
				//ctx.fillStyle = CHARA_COLOR;

				var CharacterImg = new Image(); //イメージオブジェクトの作成
				if(chara.life > 0){
					CharacterImg.src = "images/gsacLogoBlue50x50.png"; //URLの設定
				}else{
					CharacterImg.src = "images/gsacLogo50x50.png"; //URLの設定
				}
				
				//画像の読み込み完了
				/*dataImg.onload = function(){*/
				//座標の指定、普通に貼っつけ
				ctx.drawImage(CharacterImg, chara.position.x - 25, chara.position.y - 25);
				//座標の指定、サイズの指定して貼っつけ
				//ctx.drawImage(dataImg, 20, 20, 100, 50);
				//切り抜く元の座標とサイズの指定、貼り付ける座標とサイズを指定貼っつけ
				//ctx.drawImage(dataImg, 0, 150,50,50 , 50,280,100,100);
				/*};*/

				// 自機を描く
				ctx.fill();

				// fireフラグの値により分岐
				if (fire) {
					score--;
					// すべての自機ショットを調査する
					for (i = 0; i < CHARA_SHOT_MAX_COUNT; i++) {
						// 自機ショットが既に発射されているかチェック
						if (!charaShot[i].alive) {
							// 自機ショットを新規にセット
							charaShot[i].set(chara.position, 6, 20); //自機ショットのスピード設定
							shoot.pause();
							shoot.currentTime = 0;
							shoot.play();

							// ループを抜ける
							break;
						}
					}
					// フラグを降ろしておく
					fire = false;
				}

				// パスの設定を開始
				ctx.beginPath();

				// すべての自機ショットを調査する
				for (i = 0; i < CHARA_SHOT_MAX_COUNT; i++) {
					// 自機ショットが既に発射されているかチェック
					if (charaShot[i].alive) {
						// 自機ショットを動かす
						charaShot[i].move();

						// 自機ショットを描くパスを設定
						ctx.arc(
							charaShot[i].position.x,
							charaShot[i].position.y,
							charaShot[i].size,
							0, Math.PI * 2, false
						);


						// パスをいったん閉じる
						ctx.closePath();
					}
				}

				// 自機ショットの色を設定する
				ctx.fillStyle = CHARA_SHOT_COLOR;

				// 自機ショットを描く
				ctx.fill();








				// エネミーの出現管理 -------------------------------------------------
				// 1000 フレーム目までは 100 フレームに一度出現させる
				if (counter % 100 === 0 && counter < 400) {
					// すべてのエネミーを調査する
					for (i = 0; i < ENEMY_MAX_COUNT; i++) {
						// エネミーの生存フラグをチェック
						if (!enemy[i].alive) {
							// タイプを決定するパラメータを算出
							j = (counter % 200) / 100;
							// タイプに応じて初期位置を決める
							var enemySize = 25;
							p.y = -enemySize + (screenCanvas.height + enemySize * 2) * j
							p.x = screenCanvas.width / 2;
							// エネミーを新規にセット
							enemy[i].set(p, enemySize, j);
							// 1体出現させたのでループを抜ける
							break;
						}
					}
				} else if (counter % 100 === 0 && counter < 800) {
					// すべてのエネミーを調査する
					for (i = 0; i < ENEMY_MAX_COUNT; i++) {
						// エネミーの生存フラグをチェック
						if (!enemy[i].alive) {
							// タイプを決定するパラメータを算出
							j = 2;
							// タイプに応じて初期位置を決める
							var enemySize = 25;
							p.y = Math.floor(Math.random() * screenCanvas.height);
							p.x = screenCanvas.width;
							// エネミーを新規にセット
							enemy[i].set(p, enemySize, 2);
							// 1体出現させたのでループを抜ける
							break;
						}
					}
				} else if (counter >= 800 && counter % 50 === 0 && counter < 1200) {
					// すべてのエネミーを調査する
					for (i = 0; i < ENEMY_MAX_COUNT; i++) {
						// エネミーの生存フラグをチェック
						if (!enemy[i].alive) {
							// タイプを決定するパラメータを算出
							j = Math.floor(Math.random() * 3);
							if (j > 2) {
								j = 2;
							}
							// タイプに応じて初期位置を決める
							var enemySize = 25;
							if (j == 2) {
								p.y = Math.floor(Math.random() * screenCanvas.height);
								p.x = screenCanvas.width;
							} else {
								// タイプに応じて初期位置を決める
								var enemySize = 25;
								p.y = -enemySize + (screenCanvas.height + enemySize * 2) * j
								p.x = screenCanvas.width / 2;
							}

							// エネミーを新規にセット
							enemy[i].set(p, enemySize, j);
							// 1体出現させたのでループを抜ける
							break;
						}
					}
				} else if (counter >= 1200 && counter % 20 === 0 && counter < 1600) {
					// すべてのエネミーを調査する
					for (i = 0; i < ENEMY_MAX_COUNT; i++) {
						// エネミーの生存フラグをチェック
						if (!enemy[i].alive) {
							// タイプを決定するパラメータを算出
							j = Math.floor(Math.random() * 3);
							if (j > 2) {
								j = 2;
							}
							// タイプに応じて初期位置を決める
							var enemySize = 25;
							if (j == 2) {
								p.y = Math.floor(Math.random() * screenCanvas.height);
								p.x = screenCanvas.width;
							} else {
								// タイプに応じて初期位置を決める
								var enemySize = 25;
								p.y = -enemySize + (screenCanvas.height + enemySize * 2) * j
								p.x = screenCanvas.width / 2;
							}

							// エネミーを新規にセット
							enemy[i].set(p, enemySize, j);
							// 1体出現させたのでループを抜ける
							break;
						}
					}
				} else if (counter === 1600) {
					// 1000 フレーム目にボスを出現させる
					p.y /*x*/ = screenCanvas.height /*width*/ / 2;
					p.x /*y*/ = screenCanvas.width + 80;
					boss.set(p, 50, 60); //ボスのポジションとサイズ、ライフをセット

					// 同時にビットも出現させる
					for (i = 0; i < BOSS_BIT_COUNT; i++) {
						j = 360 / BOSS_BIT_COUNT;
						bit[i].set(boss, 25, 5, i * j);
					}
				}

				// カウンターの値によってシーン分岐
				switch (true) {
					// カウンターが70より小さい
				case counter < 70:
					message = 'READY';
					message2 = '';
					break;

					// カウンターが100より小さい
				case counter < 100:
					message = 'START';
					break;

					// カウンターが100より小さい
				case win:
					message = 'GAME CLEAR';
						message2 = 'Press Enter key to restart';
					break;

					// カウンターが100以上
				default:
					message = '';
					message2 = '';




					// パスの設定を開始
					ctx.beginPath();
					// すべてのエネミーを調査する
					for (i = 0; i < ENEMY_MAX_COUNT; i++) {
						// エネミーの生存フラグをチェック
						if (enemy[i].alive) {
							// エネミーを動かす
							enemy[i].move();

							// エネミーを描くパスを設定
							/*ctx.arc(
								enemy[i].position.x,
								enemy[i].position.y,
								enemy[i].size,
								0, Math.PI * 2, false
							);*/
							var EnemyImg = new Image(); //イメージオブジェクトの作成
							if (enemy[i].type == 0 || enemy[i].type == 1) {
								EnemyImg.src = "images/html5_50x50_.png"; //URLの設定
							} else if (enemy[i].type == 2) {
								EnemyImg.src = "images/css3_50x50_.png"; //URLの設定
							}

							ctx.drawImage(EnemyImg, enemy[i].position.x - 25, enemy[i].position.y - 25);

							// ショットを打つかどうかパラメータの値からチェック
							if (enemy[i].param % 20 === 0) {
								// エネミーショットを調査する
								for (j = 0; j < ENEMY_SHOT_MAX_COUNT; j++) {
									if (!enemyShot[j].alive) {
										// エネミーショットを新規にセットする
										p = enemy[i].position.distance(chara.position);
										p.normalize();
										enemyShot[j].set(enemy[i].position, p, 5, 8); //第4引数はエネミーショットスピード
										// 1個出現させたのでループを抜ける
										break;
									}
								}
							}
							// パスをいったん閉じる
							ctx.closePath();
						}
					}
					ctx.fillStyle = ENEMY_COLOR;
					//エネミーを書く
					ctx.fill();


					ctx.beginPath();
					for (i = 0; i < ENEMY_SHOT_MAX_COUNT; i++) {
						if (enemyShot[i].alive) {
							enemyShot[i].move();
							ctx.arc(
								enemyShot[i].position.x,
								enemyShot[i].position.y,
								enemyShot[i].size,
								0, Math.PI * 2, false
							);
							ctx.closePath();
						}
					}

					ctx.fillStyle = ENEMY_SHOT_COLOR;
					ctx.fill();


					// ボス -------------------------------------------------------
					// パスの設定を開始
					ctx.beginPath();

					// ボスの出現フラグをチェック
					if (boss.alive) {
						// ボスを動かす
						boss.move();

						// ボスを描くパスを設定
						/*ctx.arc(
							boss.position.x,
							boss.position.y,
							boss.size,
							0, Math.PI * 2, false
						);*/

						// パスをいったん閉じる
						//ctx.closePath();
						var BossImg = new Image(); //イメージオブジェクトの作成
						BossImg.src = "images/javascriptLogo100x100_.png"; //URLの設定
						ctx.drawImage(BossImg, boss.position.x - 50, boss.position.y - 50);
					}
					// ボスの色を設定する
					//ctx.fillStyle = BOSS_COLOR;
					// ボスを描く
					ctx.fill();

					// ビット -------------------------------------------
					// パスの設定を開始
					ctx.beginPath();
					// すべてのビットを調査する
					for (i = 0; i < BOSS_BIT_COUNT; i++) {
						// ビットの出現フラグをチェック
						if (bit[i].alive) {
							// ビットを動かす
							bit[i].move();
							// ビットを描くパスを設定
							/*ctx.arc(
								bit[i].position.x,
								bit[i].position.y,
								bit[i].size,
								0, Math.PI * 2, false
							);*/
							var BitImg = new Image(); //イメージオブジェクトの作成
							BitImg.src = "images/phpLogo_50x50.png"; //URLの設定
							ctx.drawImage(BitImg, bit[i].position.x - 25, bit[i].position.y - 25);
							// ショットを打つかどうかパラメータの値からチェック
							if (bit[i].param % 25 === 0) {
								// エネミーショットを調査する
								for (j = 0; j < ENEMY_SHOT_MAX_COUNT; j++) {
									if (!enemyShot[j].alive) {
										// エネミーショットを新規にセットする
										p = bit[i].position.distance(chara.position);
										p.normalize();
										enemyShot[j].set(bit[i].position, p, 6, 4); //ボスビットのライフ、ショットスピードを変更可
										// 1個出現させたのでループを抜ける
										break;
									}
								}
							}
							// パスをいったん閉じる
							ctx.closePath();
						}
					}

					// ビットの色を設定する
					ctx.fillStyle = BOSS_BIT_COLOR;
					// ビットを書く
					ctx.fill();

					// 衝突判定 -----------------------------------------------------------
					// すべての自機ショットを調査する
					for (i = 0; i < CHARA_SHOT_MAX_COUNT; i++) {
						// 自機ショットの生存フラグをチェック
						if (charaShot[i].alive) {
							// 自機ショットとエネミーとの衝突判定
							for (j = 0; j < ENEMY_MAX_COUNT; j++) {
								// エネミーの生存フラグをチェック
								if (enemy[j].alive) {
									// エネミーと自機ショットとの距離を計測
									p = enemy[j].position.distance(charaShot[i].position);
									if (p.length() < enemy[j].size) {
										// 衝突していたら生存フラグを降ろす
										enemy[j].alive = false;
										enemy[j].acceleration = 0;
										enemy[j].acceleration02 = -20;
										charaShot[i].alive = false;
										// スコアを更新するためにインクリメント
										score += 100;
										shot_struck1.pause();
										shot_struck1.currentTime = 0;
										shot_struck1.play();
										// 衝突があったのでループを抜ける
										break;
									}
								}
							}

							// 自機ショットとボスビットとの衝突判定
							for (j = 0; j < BOSS_BIT_COUNT; j++) {
								// ビットの生存フラグをチェック
								if (bit[j].alive) {
									// ビットと自機ショットとの距離を計測
									p = bit[j].position.distance(charaShot[i].position);
									if (p.length() < bit[j].size) {
										// 衝突していたら耐久値をデクリメントする
										bit[j].life--;
										score += 100; //スコアをインクリメント
										// 自機ショットの生存フラグを降ろす
										charaShot[i].alive = false;
										// 耐久値がマイナスになったら生存フラグを降ろす
										if (bit[j].life < 0) {
											bit[j].alive = false;
											score += 1000;
											bomb.play();
										}else{
											pico00.pause();
											pico00.currentTime = 0;
											pico00.play();
										}
										// 衝突があったのでループを抜ける
										break;
									}
								}
							}

							// ボスの生存フラグをチェック
							if (boss.alive) {
								// 自機ショットとボスとの衝突判定
								p = boss.position.distance(charaShot[i].position);
								if (p.length() < boss.size) {
									// 衝突していたら耐久値をデクリメントする
									boss.life--;
									score += 100; //スコアをインクリメント

									// 自機ショットの生存フラグを降ろす
									charaShot[i].alive = false;

									// 耐久値がマイナスになったらクリア
									if (boss.life < 0) {
										score += 3000;
										boss.alive = false;
										for (j = 0; j < BOSS_BIT_COUNT; j++) {
											if (bit[j].alive) {
												bit[j].alive = false;
											}
										}
										explosion2.play();
										setTimeout(function () {
											run = false;
											win = true;
											ff4_09_fanfare.play();
										}, 2000);
									}else{
										pi00.pause();
										pi00.currentTime = 0;
										pi00.play();
									}
								}
							}
						}
					}

					// 自機とエネミーショットとの衝突判定
					for (i = 0; i < ENEMY_SHOT_MAX_COUNT; i++) {
						// エネミーショットの生存フラグをチェック
						if (enemyShot[i].alive) {
							// 自機とエネミーショットとの距離を計測
							p = chara.position.distance(enemyShot[i].position);
							if (p.length() < chara.size) {
								if(chara.life > 0){
									enemyShot[i].alive = false;
									buin00.play();
									chara.life--;
								}else{
									// 衝突していたら生存フラグを降ろす
									chara.alive = false;
									// 衝突があったのでパラメータを変更してループを抜ける
									run = false;
									explosion.play();
									message = 'GAME OVER';
									message2 = 'Press Enter key to restart';
									break;
								}
							}
						}
					}
					break;
				}

				console.log(chara.life);


				ctx.font = 'bold 40px Century Gothic';
				ctx.strokeStyle = '#00A3D9';
				ctx.lineWidth = 6;
				ctx.lineJoin = 'round';
				ctx.fillStyle = '#fff';
				ctx.strokeText('SCORE　 ' + score, 180, 45, 520);
				ctx.fillText('SCORE　 ' + score, 180, 45);
				ctx.strokeText('BEST SCORE　 ' + bestScore, 540, 45, 520);
				ctx.fillText('BEST SCORE　 ' + bestScore, 540, 45);
				ctx.textAlign = 'center';
				ctx.font = 'bold 80px Century Gothic';
				ctx.strokeText(message, screenCanvas.width / 2, screenCanvas.height / 2, 520);
				ctx.fillText(message, screenCanvas.width / 2, screenCanvas.height / 2);
				
				ctx.font = 'bold 40px Century Gothic';
				ctx.strokeText(message2, screenCanvas.width / 2, screenCanvas.height / 2 + 80, 580);
				ctx.fillText(message2, screenCanvas.width / 2, screenCanvas.height / 2 + 80);
				


				// フラグにより再帰呼び出し
				if (run) {
					setTimeout(arguments.callee, fps);
				} else {
					if (bestScore < score) {
						bestScore = score;
						localStorage.setItem("bestScore",bestScore);
					}
					hareta.pause();

				}
			})();

		}
		ctx.font = 'bold 40px Century Gothic';
		ctx.strokeStyle = '#00A3D9';
		ctx.lineWidth = 6;
		ctx.lineJoin = 'round';
		ctx.textAlign = 'center';
		ctx.fillStyle = '#fff';
		ctx.strokeText('Press Enter key to play Game', screenCanvas.width / 2, screenCanvas.height / 2, 580);
		ctx.fillText('Press Enter key to play Game', screenCanvas.width / 2, screenCanvas.height / 2);
		/*gameStart();*/
		screenCanvas.addEventListener("click", function () {
			restart();
		}, false);

		function restart(){
			if (!run) {
				score = 0;
				run = true;
				counter = 0;
				chara.life = 1;
				initGame();
				gameStart();
			}
		}


		function initGame() {
			// すべての自機ショットを調査する
			for (i = 0; i < CHARA_SHOT_MAX_COUNT; i++) {
				// 自機ショットの生存フラグをチェック
				if (charaShot[i].alive) {
					charaShot[i].alive = false;
				}
			}
			for (i = 0; i < ENEMY_SHOT_MAX_COUNT; i++) {
				// エネミーショットの生存フラグをチェック
				if (enemyShot[i].alive) {
					enemyShot[i].alive = false;
				}
			}
			for (j = 0; j < ENEMY_MAX_COUNT; j++) {
				// エネミーの生存フラグをチェック
				if (enemy[j].alive) {
					enemy[j].alive = false;
					enemy[j].acceleration = 0;
					enemy[j].acceleration02 = -20;
				}
			}
			for (j = 0; j < BOSS_BIT_COUNT; j++) {
				// ビットの生存フラグをチェック
				if (bit[j].alive) {
					bit[j].alive = false;
				}
			}
			if (boss.alive) {
				boss.alive = false;
			}
		}
		// - event --------------------------------------------------------------------
		function mouseMove(event) {
			// マウスカーソル座標の更新
			mouse.x = event.clientX - screenCanvas.offsetLeft;
			mouse.y = event.clientY - screenCanvas.offsetTop;
		}

		function mouseDown(event) {
			// フラグを立てる
			fire = true;
		}

		function keyDown(event) {
			// キーコードを取得
			var ck = event.keyCode;
			console.log(ck);
			if (ck >= 65 && ck <= 90) {
				fire = true;
			}

			// Escキーが押されていたらフラグを降ろす
			if (ck === 27) {
				run = false;
			}
			// Enterキーが押されていたら
			if (ck === 13) {
				restart();
			}
		}
	};






