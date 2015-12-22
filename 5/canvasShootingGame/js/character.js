function Character(){
	this.position = new Point();
	this.size = 0;
	this.speed = 0;
	this.life = 0;
	this.alive = false;
}

Character.prototype.init = function(size,life){
	this.size = size;
	this.life = life;
};

function CharacterShot(){
	this.position = new Point();
	this.size = 0;
	this.speed = 0;
	this.alive = false;
}

CharacterShot.prototype.set = function(p, size, speed){
	// 座標をセット
	this.position.x = p.x;
	this.position.y = p.y;

	// サイズ、スピードをセット
	this.size = size;
	this.speed = speed;

	// 生存フラグを立てる
	this.alive = true;
};

CharacterShot.prototype.move = function(){
	// 座標を真上にspeed分だけ移動させる
	this.position.x += this.speed;

	// 一定以上の座標に到達していたら生存フラグを降ろす
	if(this.position.x > screenCanvas.width + this.size){
		this.alive = false;
	}
};



function Enemy(){
	this.position = new Point();
	this.size = 0;
	this.type = 0;
	this.param = 0;
	this.alive = false;
	this.acceleration = 0;
	this.acceleration02 = -20;
	this.initY;
}

Enemy.prototype.set = function(p, size, type){
	// 座標をセット
	this.position.x = p.x;
	this.position.y = p.y;
	this.initY = p.y;

	// サイズ、タイプをセット
	this.size = size;
	this.type = type;

	// パラメータをリセット
	this.param = 0;

	// 生存フラグを立てる
	this.alive = true;
};

Enemy.prototype.move = function(){
	// パラメータをインクリメント
	this.param++;

	// タイプに応じて分岐
	switch(this.type){
		case 0:
			// X 方向へまっすぐ進む
			this.position.y/*x*/ += 5;
			
			this.acceleration += 1/16;
			this.position.x += this.acceleration;

			// スクリーンの右端より奥に到達したら生存フラグを降ろす
			if(this.position.y/*x*/ > this.size + screenCanvas.height/*width*/){
				this.alive = false;
				this.acceleration = 0;
			}
			break;
		case 1:
			// マイナス y 方向へまっすぐ進む
			this.position.y -= 5;
			
			this.acceleration += 1/16;
			this.position.x += this.acceleration;

			// スクリーンの左端より奥に到達したら生存フラグを降ろす
			if(this.position.y < -this.size){
				this.alive = false;
				this.acceleration = 0;
			}
			break;
		case 2:
			if(this.initY < screenCanvas.height / 2){
				this.position.y += 2;
			}else{
				this.position.y -= 2;
			}
			this.acceleration02 += 1/4;
			this.position.x += this.acceleration02;

			// スクリーンの左端より奥に到達したら生存フラグを降ろす
			if(this.position.y/*x*/ < -this.size){
				this.alive = false;
				this.acceleration02 = -20;
			}
			break;
	}
};


function EnemyShot(){
	this.position = new Point();
	this.vector = new Point();
	this.size = 0;
	this.speed = 0;
	this.alive = false;
}

EnemyShot.prototype.set = function(p, vector, size, speed){
	// 座標、ベクトルをセット
	this.position.x = p.x;
	this.position.y = p.y;
	this.vector.x = vector.x;
	this.vector.y = vector.y;

	// サイズ、スピードをセット
	this.size = size;
	this.speed = speed;

	// 生存フラグを立てる
	this.alive = true;
};

EnemyShot.prototype.move = function(){
	// 座標をベクトルに応じてspeed分だけ移動させる
	this.position.x += this.vector.x * this.speed;
	this.position.y += this.vector.y * this.speed;

	// 一定以上の座標に到達していたら生存フラグを降ろす
	if(
		this.position.x < -this.size ||
		this.position.y < -this.size ||
		this.position.x > this.size + screenCanvas.width ||
		this.position.y > this.size + screenCanvas.height
	){
		this.alive = false;
	}
};




function Star(){
	this.position = new Point();
	this.size = 0;
	this.speed = 0;
	this.alive = false;
	this.type = 0;
}

Star.prototype.set = function(p, size, speed, type){
	// 座標をセット
	this.position.x = screenCanvas.width;
	this.position.y = Math.floor(Math.random() * screenCanvas.height);
	// サイズ、スピードをセット
	this.size = size;
	this.speed = speed;
	this.type = type;
	// 生存フラグを立てる
	this.alive = true;
	
};

Star.prototype.move = function(){
	switch(this.type){
		case 0:
			// 座標をspeed分だけ移動させる
			this.position.x -= this.speed;
			break;
		case 1:
			// 座標をspeed分だけ移動させる
			this.position.x -= this.speed * 2;
			break;
		case 2:
			// 座標をspeed分だけ移動させる
			this.position.x -= this.speed * 3;
			break;
	}
	// 一定以上の座標に到達していたら生存フラグを降ろす
	if(this.position.x < -this.size){
		this.alive = false;
	}
};




