<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Snake</title>
	<link rel="stylesheet" type="text/css" href="semantic.min.css">
	<link rel="stylesheet" type="text/css" href="my.css">
</head>
<body>
	<div class="ui menu">
		<div class="ui container">
		<div class="header item">Snake</div>
		<div class="active item">Game</div>
		<a class="item" href="upload.php">Upload</a>
		<a class="item" href="rule.php">Rule</a>
		<div class="right menu">
			<div class="item">
				<?php echo $_SESSION['username']; ?>		
			</div>
			<a href="signout.php" class="item">退出</a>
		</div>
		</div>
	</div>
	<?php 
		$username = $_SESSION['username'];
		if(is_null($username)) {
			?>
				<div class="ui middle aligned center aligned grid" style="height:100%">
					<div class="left aligned column" style="max-width: 450px;">
						<div class="ui negative message">
							<div class="header">错误</div>
							<p>记得登录呀...
							<br/>
							<a href="index.html">返回</a>
							</p>
						</div>
					</div>
				</div>
			<?php
		}
		else {
	?>
	<div class="ui container">

		<div class="ui form">
			<div class="fields">
				<div class="field">
					<label>1分豆</label>
					<input type="text" placeholder="0.3" value="0.3" id="col1">
				</div>
				<div class="field">
					<label>2分豆</label>
					<input type="text" placeholder="0.2" value="0.2" id="col2">
				</div>
				<div class="field">
					<label>5分豆</label>
					<input type="text" placeholder="0.2" value="0.2" id="col3">
				</div>
				<div class="field">
					<label>10分豆</label>
					<input type="text" placeholder="0.1" value="0.1" id="col4">
				</div>
				<div class="field">
					<label>增长豆</label>
					<input type="text" placeholder="0.1" value="0.1" id="col5">
				</div>
				<div class="field">
					<label>盾牌</label>
					<input type="text" placeholder="0.1" value="0.1" id="col6">
				</div>
			</div>
		</div>

		<div class="ui segment">
			
			<div class="ui grid">
				<div class="twelve wide column">
					<canvas id="canvas" height="606" width="806"></canvas>
				</div>
				<div class="four wide column">
					<div class="ui grid">
						<div class="row">
							<form class="ui form" id="chooseform">
								<div class="ui dividing header">文件列表</div>
								<div class="field" id="fixlist">
									<div class="ui list" id="filelist">
										<div class="item">
											<div class="ui checkbox"></div>
										</div>
									</div>
								</div>
								<div class="ui button" onclick="addStus()">添加</div>
								<div class="ui button" onclick="checkChoice()">确认</div>
								<input type="hidden" value="" id="student_id">
							</form>
						</div>
						<div class="row">
							<div class="ui statistic">
								<div class="label">Time</div>
								<div class="value" id="time">0</div>
							</div>
						</div>
						<div class="row">
							<div class="ui three column stackable padded color grid" id="note"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="ui form">
				<div class="field">
					<label>学号(以空格分开)</label>
					<input type="text" placeholder="2015201901 2015201902 2015201903"  id="snos">
				</div>
		</div>
	</div>
	<?php } ?>

	<img src="shield.jpg" alt="tulip" id="shield" style="margin-left:0px;display:none;" />
	<img src="douzi.jpg" alt="tulip" id="douzi" style="margin-left:0px;display:none;" />

	<script type="text/javascript" src="jquery-3.2.0.min.js"></script>
	<script type="text/javascript" src="semantic.min.js"></script>
	<script type="text/javascript" src="game.js"></script>
	<script>
	
	var otherSnakeScore = new Array(); //得分
	var time = 0; //游戏时间
	var choice = new Array(); //每次游戏选择的学号数组
	var gameid; //随机生成每一局id，用于后台地图命名
	var functionId;
	var timeFuncId;
	var speed = 2; //蛇移动速度
	var otherSnakeNumber; //蛇数
	var bonusNumber = 100; //豆子数
	var boxNumber = 0;
	var canvas; //画图
	var context;
	var falloff = 0;
	var score;
	var width; //画布宽度
	var height; //画布长度
	var otherSnakeX = new Array(); //蛇横坐标
	var otherSnakeY = new Array(); //蛇纵坐标
	var otherSnakeDirection = new Array(); //蛇方向
	var otherSnakePreDirection = new Array(); //每一节蛇前一节的方向
	var otherSnakeInitLength = new Array(); //每条蛇初始长度
	var otherSnakeAddLength = new Array(); 	// 每条蛇的附加长度，涞源自额外豆子
	var otherSnakeLength = new Array(); //每条蛇当前长度
	var otherSnakeShieldNums = new Array(); //每条蛇拥有盾牌数
	var otherSnakeShieldTimes = new Array(); //每条蛇盾牌剩余时间
	var bonusX = new Array(); //豆子横坐标
	var bonusY = new Array(); //豆子纵坐标
	var boxX = new Array();
	var boxY = new Array();
	var bonusValue = new Array(); //豆子得分
	var refresh_times = 0; //刷新次数记录，每10次刷新调用一次后台
	var map = new Array(); //地图
	var error_student_id = new Array(); //出错学生的id
	var snake_colors = ["red", "darkorange", "gold", "teal", "steelblue", 
	"hotpink", "aqua", "cornsilk", "chocolate", "darkgreen", 
	"dimgray", "dodgerblue", "ghostwhite", "indigo", "lightsteelblue", 
	"sandybrown", "yellowgreen", "peru", "navy", "linen", 
	"fuchsia", "deeppink", "darkblue", "cornflowerblue", "coral"]; //蛇颜色
	var bonus_color = ["#FF4500", "#76EE00", "#AEEEEE", "#EE82EE", "#FFD700"]; //豆子颜色
	var box_value = new Array();
	var box_color = "#3366cc";
	var bonus_value = [-1, -2, -3, -5, -100, -10000]; //豆子得分
	var game_over = false; //记录游戏结束

	//蛇身体移动
	function othersnake_body_move(i) {
		for(var j = 1; j < otherSnakeLength[i]; j++) {
				if(otherSnakeDirection[i][j] == 0) {
					otherSnakeX[i][j] -= speed;
				}
				else if(otherSnakeDirection[i][j] == 1) {
					otherSnakeY[i][j] -= speed;
				}
				else if(otherSnakeDirection[i][j] == 2) {
					otherSnakeX[i][j] += speed;
				}
				else {
					otherSnakeY[i][j] += speed;
				}
			}
	}

	//蛇移动
	function othersnake_move() {
		for(var i = 0; i < otherSnakeNumber; i++) {
			//当其运动到整格点
			if(otherSnakeShieldTimes[i] > 20){
				
				otherSnakeShieldTimes[i] -= 1
				continue
			}
			if((otherSnakeX[i][0] - 3) % 20 == 0 && (otherSnakeY[i][0] - 3) % 20 == 0) {
				//向左走
				if(otherSnakePreDirection[i][0] == 0 && otherSnakeDirection[i][0] != 2) {
					for(var j = otherSnakeLength[i] - 1; j > 0; j--) {
						otherSnakeDirection[i][j] = otherSnakeDirection[i][j - 1];
					}
					otherSnakeDirection[i][0] = otherSnakePreDirection[i][0];
					otherSnakeX[i][0] -= speed;
					othersnake_body_move(i);
				}
				//向上走
				else if(otherSnakePreDirection[i][0] == 1 && otherSnakeDirection[i][0] != 3) {
					for(var j = otherSnakeLength[i] - 1; j > 0; j--) {
						otherSnakeDirection[i][j] = otherSnakeDirection[i][j - 1];
					}
					otherSnakeDirection[i][0] = otherSnakePreDirection[i][0];
					otherSnakeY[i][0] -= speed;
					othersnake_body_move(i);
				}
				//向右走
				else if(otherSnakePreDirection[i][0] == 2 && otherSnakeDirection[i][0] != 0) {
					for(var j = otherSnakeLength[i] - 1; j > 0; j--) {
						otherSnakeDirection[i][j] = otherSnakeDirection[i][j - 1];
					}
					otherSnakeDirection[i][0] = otherSnakePreDirection[i][0];
					otherSnakeX[i][0] += speed;
					othersnake_body_move(i);
				}
				//向下走
				else if(otherSnakePreDirection[i][0] == 3 && otherSnakeDirection[i][0] != 1){
					for(var j = otherSnakeLength[i] - 1; j > 0; j--) {
						otherSnakeDirection[i][j] = otherSnakeDirection[i][j - 1];
					}
					otherSnakeDirection[i][0] = otherSnakePreDirection[i][0];
					otherSnakeY[i][0] += speed;
					othersnake_body_move(i);
				}
				else if(otherSnakeShieldNums[i] > 0 && otherSnakePreDirection[i][0] == 4){
					otherSnakeShieldNums[i] -= 1
					otherSnakeShieldTimes[i] = 30
				}
				else {
					//如果其给出了完全相反的方向，则忽略该请求，保持原方向移动
					for(var j = otherSnakeLength[i] - 1; j > 0; j--) {
						otherSnakeDirection[i][j] = otherSnakeDirection[i][j - 1];
					}
					//向左
					if(otherSnakeDirection[i][0] == 0) {
						otherSnakeX[i][0] -= speed;
					}
					//向上
					else if(otherSnakeDirection[i][0] == 2) {
						otherSnakeX[i][0] += speed;
					}
					//向右
					else if(otherSnakeDirection[i][0] == 1) {
						otherSnakeY[i][0] -= speed;
					}
					//向下
					else if(otherSnakeDirection[i][0] == 3) {
						otherSnakeY[i][0] += speed;
					}
					othersnake_body_move(i);
				}
			}
			//不在整格点时
			else {
				if(otherSnakeDirection[i][0] == 0) {
					otherSnakeX[i][0] -= speed;
				}
				else if(otherSnakeDirection[i][0] == 2) {
					otherSnakeX[i][0] += speed;
				}
				else if(otherSnakeDirection[i][0] == 1) {
					otherSnakeY[i][0] -= speed;
				}
				else if(otherSnakeDirection[i][0] == 3) {
					otherSnakeY[i][0] += speed;
				}
				othersnake_body_move(i);
			}

			if(otherSnakeShieldTimes[i] > 0){
				otherSnakeShieldTimes[i] -= 1
			}
			
		}
	}

	//通过判断蛇的方向增加蛇的长度
	function add_snake(snakeID) {
		if(otherSnakeDirection[snakeID][otherSnakeLength[snakeID] - 1] == 0) {
			otherSnakeX[snakeID][otherSnakeLength[snakeID]] = otherSnakeX[snakeID][otherSnakeLength[snakeID] - 1] + 20;
			otherSnakeY[snakeID][otherSnakeLength[snakeID]] = otherSnakeY[snakeID][otherSnakeLength[snakeID] - 1];
			otherSnakeDirection[snakeID][otherSnakeLength[snakeID]] = otherSnakeDirection[snakeID][otherSnakeLength[snakeID] - 1];
			otherSnakePreDirection[snakeID][otherSnakeLength[snakeID]] = otherSnakeDirection[snakeID][otherSnakeLength[snakeID] - 1];
		}
		else if(otherSnakeDirection[snakeID][otherSnakeLength[snakeID] - 1] == 1) {
			otherSnakeX[snakeID][otherSnakeLength[snakeID]] = otherSnakeX[snakeID][otherSnakeLength[snakeID] - 1];
			otherSnakeY[snakeID][otherSnakeLength[snakeID]] = otherSnakeY[snakeID][otherSnakeLength[snakeID] - 1] + 20;
			otherSnakeDirection[snakeID][otherSnakeLength[snakeID]] = otherSnakeDirection[snakeID][otherSnakeLength[snakeID] - 1];
			otherSnakePreDirection[snakeID][otherSnakeLength[snakeID]] = otherSnakeDirection[snakeID][otherSnakeLength[snakeID] - 1];
		}
		else if(otherSnakeDirection[snakeID][otherSnakeLength[snakeID] - 1] == 2) {
			otherSnakeX[snakeID][otherSnakeLength[snakeID]] = otherSnakeX[snakeID][otherSnakeLength[snakeID] - 1] - 20;
			otherSnakeY[snakeID][otherSnakeLength[snakeID]] = otherSnakeY[snakeID][otherSnakeLength[snakeID] - 1];
			otherSnakeDirection[snakeID][otherSnakeLength[snakeID]] = otherSnakeDirection[snakeID][otherSnakeLength[snakeID] - 1];
			otherSnakePreDirection[snakeID][otherSnakeLength[snakeID]] = otherSnakeDirection[snakeID][otherSnakeLength[snakeID] - 1];
		}
		else {
			otherSnakeX[snakeID][otherSnakeLength[snakeID]] = otherSnakeX[snakeID][otherSnakeLength[snakeID] - 1];
			otherSnakeY[snakeID][otherSnakeLength[snakeID]] = otherSnakeY[snakeID][otherSnakeLength[snakeID] - 1] - 20;
			otherSnakeDirection[snakeID][otherSnakeLength[snakeID]] = otherSnakeDirection[snakeID][otherSnakeLength[snakeID] - 1];
			otherSnakePreDirection[snakeID][otherSnakeLength[snakeID]] = otherSnakeDirection[snakeID][otherSnakeLength[snakeID] - 1];
		}
		otherSnakeLength[snakeID] += 1;
	}

	//吃豆子，通过计算豆子所在的格子和蛇头所在的格子来判断豆子是否被吃掉
	function eat_bonus() {
		for(var i = 0; i < bonusNumber; i++) {
			var bonus_x = (bonusX[i] - 13) / 20;
			var bonus_y = (bonusY[i] - 13) / 20;
			for(var j = 0; j < otherSnakeNumber; j++) {
				if(otherSnakeLength[j] != 0) {
					var o_s_x = Math.floor((otherSnakeX[j][0] - 3) / 20);
					var o_s_y = Math.floor((otherSnakeY[j][0] - 3) / 20);
					if(o_s_x == bonus_x && o_s_y == bonus_y) {
						bonusX[i] = -10;
						bonusY[i] = -10;
						if(bonusValue[i] < 4 ){
							otherSnakeScore[j] += Math.abs(bonus_value[bonusValue[i]]);
						}
						
						else if(bonusValue[i] == 4) {
							otherSnakeAddLength[j] += 2;
						}else if(bonusValue[i] == 5){
							otherSnakeShieldNums[j] += 1;
						}else{}
						$("#score" + j).html(otherSnakeScore[j].toString() + "_" + otherSnakeShieldNums[j].toString() + "_" + otherSnakeShieldTimes[j].toString() );
						var add_length = otherSnakeScore[j] / 10;
						for(var t = 0; t < (otherSnakeInitLength[j] + add_length + otherSnakeAddLength[j]) - otherSnakeLength[j]; t++) {
							add_snake(j);
						}
					}
				}
			}
		}
	}

	function eat_box() {
		for(var i = 0; i < boxNumber; i++) {
			var box_x = (boxX[i] - 13) / 20;
			var box_y = (boxY[i] - 13) / 20;
			for(var j = 0; j < otherSnakeNumber; j++) {
				if(otherSnakeLength[j] != 0) {
					var o_s_x = Math.floor((otherSnakeX[j][0] - 3) / 20);
					var o_s_y = Math.floor((otherSnakeY[j][0] - 3) / 20);
					if(o_s_x == box_x && o_s_y == box_y) {
						boxX[i] = -10;
						boxY[i] = -10;
						
						otherSnakeScore[j] += Math.abs(box_value[i]);
						$("#score" + j).html(otherSnakeScore[j].toString() + "_" + otherSnakeShieldNums[j].toString() + "_" + otherSnakeShieldTimes[j].toString() );
						var add_length = otherSnakeScore[j] / 10;
						for(var t = 0; t < (otherSnakeInitLength[j] + add_length + otherSnakeAddLength[j]) - otherSnakeLength[j]; t++) {
							add_snake(j);
						}
					}
				}
			}
		}
	}

	//判断死亡，当蛇头碰到其他蛇的身体，该蛇死亡，当两蛇头相碰，均死亡
	function check_death() {
		var flag = 1;
		for(var i = 0; i < otherSnakeNumber; i++) {
			
			if(otherSnakeLength[i] > 0 && otherSnakeShieldTimes[i] == 0) {

				var flag_other = 1;
				var my_s_x = Math.floor((otherSnakeX[i][0] - 3) / 20); //i的头
				var my_s_y = Math.floor((otherSnakeY[i][0] - 3) / 20);
				for(var j = 0; j < otherSnakeNumber && flag_other == 1; j++) {
					if(j == i) {
						continue;
					}
					for(var k = 0; k < otherSnakeLength[j]; k++) { //遍历j的全身
						var o_s_x = Math.floor((otherSnakeX[j][k] - 3) / 20);
						var o_s_y = Math.floor((otherSnakeY[j][k] - 3) / 20);
						if(my_s_x == o_s_x && my_s_y == o_s_y) { // 如果i碰到了j
							
							if(k == 0) { // 且碰到了j的头
								//otherSnakeLength[j] = 0;
								error_student_id[j] = 1;
								if(otherSnakeShieldTimes[j] == 0){
									snake_die(j);
								}
							}
							//otherSnakeLength[i] = 0;
							error_student_id[i] = 1;
							snake_die(i);
							flag_other = 0;
							break;
						}
					}
				}
			}
		}
		var count = 0;
		for(i = 0; i < otherSnakeNumber; i++) {
			if(otherSnakeLength[i] == 0) {
				count ++;
			}
		}
		if(count == otherSnakeNumber) {
			game_over = true;
		}
	}

	function add_box(x,y,val){
		boxX[boxNumber] = x*20+13;
		boxY[boxNumber] = y*20+13;
		box_value[boxNumber] = val;
		boxNumber += 1;	
	}

	function snake_die(idx) {
		var s_score = otherSnakeScore[idx];
		for(var i = 0;i < otherSnakeLength[idx]; i++){
			
			if(otherSnakeX[idx][i] < 0 || otherSnakeX[idx][i] > width - 10 || otherSnakeY[idx][i] < 0 || otherSnakeY[idx][i] > height - 10)continue;
			if(s_score <= 0)break;
			var s_x = Math.floor((otherSnakeX[idx][i] - 3) / 20);
			var s_y = Math.floor((otherSnakeY[idx][i] - 3) / 20);
			if(s_score >= 10){
				add_box(s_x,s_y,10);
				s_score -= 10;
			}
			else {
				add_box(s_x,s_y,s_score);
				s_score = 0;
			}
		}
		otherSnakeLength[idx] = 0;
	}

	//判断是否撞墙
	function check_wall() {
		for(var i = 0; i < otherSnakeNumber; i++) {
			if(otherSnakeLength[i] > 0) {
				if(otherSnakeX[i][0] < 0 || otherSnakeX[i][0] > width - 10 || otherSnakeY[i][0] < 0 || otherSnakeY[i][0] > height - 10) {
					//otherSnakeLength[i] = 0;
					error_student_id[i] = 1;
					snake_die(i);
				}
			}
		}
	}

	//计时
	function set_time() {
		time += 1;
		if(time > 120) {
			game_over = true;
		}
		$('#time').html(time);
	}

	//补充豆子，随着时间增长，豆子逐渐往中间生成
	function update_bonus() {
		for(var i = 0; i < bonusNumber; i++) {
			if(time < 40) {
				if(bonusX[i] == -10 || bonusY[i] == -10) {
					bonusX[i] = 13 + Math.floor((i * ((width - 20) / bonusNumber)) / 20) * 20;
					bonusY[i] = 13 + Math.floor((Math.random() * (height - 20)) / 20) * 20;
					random_num(i);
				}
			}
			if(time > 40 && time < 60) {
				if(bonusX[i] == -10 || bonusY[i] == -10) {
					bonusX[i] = 193 + Math.floor((i * (400 / bonusNumber)) / 20) * 20;
					bonusY[i] = 13 + Math.floor((Math.random() * (height - 20)) / 20) * 20;
					random_num(i);
				}
			}
			if(time > 60) {
				if(bonusX[i] == -10 || bonusY[i] == -10) {
					bonusX[i] = 193 + Math.floor((i * (400 / bonusNumber)) / 20) * 20;
					// bonusY[i] = 93 + Math.floor((i * (400 / bonusNumber)) / 20) * 20;
					bonusY[i] = 93 + Math.floor((Math.random() * 400) / 20) * 20;
					random_num(i);
				}
			}
		}
	}

	//随机生成豆子颜色及分值
	function random_num(bonusID) {

		var num = Math.random();

		w1 = parseFloat($("#col1").val())
		w2 = parseFloat($("#col2").val())
		w3 = parseFloat($("#col3").val())
		w4 = parseFloat($("#col4").val())
		w5 = parseFloat($("#col5").val())
		w6 = parseFloat($("#col6").val())
		// if(  Math.abs(w1 + w2 + w3 + w4 + w5 + w6 - 1)  )
		if(Math.abs(w1 + w2 + w3 + w4 + w5 + w6 - 1) > 1e-3){
			alert("豆子权重和不等于1，非法！")
			return
		}
		num1 = w1
		num2 = num1 + w2
		num3 = num2 + w3
		num4 = num3 + w4
		num5 = num4 + w5
		
		if(num <= num1) {
			bonusValue[bonusID] = 0;
		}
		else if(num > num1 && num <= num2) {
			bonusValue[bonusID] = 1;
		}
		else if(num > num2 && num <= num3) {
			bonusValue[bonusID] = 2;
		}
		else if(num > num3 && num <= num4){
			bonusValue[bonusID] = 3;
		}
		else if(num > num4 && num <= num5){
			bonusValue[bonusID] = 4;
		}else{
			bonusValue[bonusID] = 5;
		}
		// if(num <= 0.1) {
		// 	bonusValue[bonusID] = 0;
		// }else{
		// 	bonusValue[bonusID] = 5;
		// }
	}

	//开始
	function btn_begin() {
		game_over = false;
		time = 0;
		//助教的变态蛇长度为25
		for(var i = 0; i < otherSnakeNumber; i++) {
			if(choice[i] == "1015202401" || choice[i] == "1015202402"  || choice[i] == "1015202403") {
				otherSnakeInitLength[i] = 25;
			}
			else {
				otherSnakeInitLength[i] = 12;
			}
		}
		//变量初始化
		for(var i = 0; i < otherSnakeNumber; i++) {
			otherSnakeLength[i] = otherSnakeInitLength[i];
			otherSnakeScore[i] = 0;
			otherSnakeAddLength[i] = 0;
			error_student_id[i] = 0;
			otherSnakeShieldNums[i] = 1;
			otherSnakeShieldTimes[i] = 0;
		}
		for(var i = 0; i < otherSnakeNumber; i++) {
			otherSnakeScore[i] = 0;
			if(choice[i] == "2016202202") {
				var basicX = 723;
				var basicY = 203;
				var basicDir = 0;
				for(var j = 0; j < otherSnakeLength[i]; j++) {
					otherSnakeX[i][j] = basicX + j * 20;
					otherSnakeY[i][j] =	basicY;
					otherSnakeDirection[i][j] = basicDir;
					otherSnakePreDirection[i][j] = basicDir;
				}
			}
			else if(choice[i] == "admin") {
				var basicX = 83;
				var basicY = 203;
				var basicDir = 2;
				for(var j = 0; j < otherSnakeLength[i]; j++) {
					otherSnakeX[i][j] = basicX - j * 20;
					otherSnakeY[i][j] =	basicY;
					otherSnakeDirection[i][j] = basicDir;
					otherSnakePreDirection[i][j] = basicDir;
				}
			}
			else {
				//计算出生点
				var g = 0;
				var l = 0;
				if(otherSnakeNumber < 14) {
					g = (Math.floor((720 / otherSnakeNumber) / 20)) * 20;
				}
				else {
					g = (Math.floor((720 / 13) / 20) + 1) * 20;
					l = (Math.floor((720 / (otherSnakeNumber - 13)) / 20)) * 20;
				}
				var basicX = 0;
				var basicY = 0;
				var basicDir = 1;
				if(i < 13) {
					if(i % 2 == 0) {
						basicX = 43 + i * g;
						basicY = 143;
						basicDir = 1;	
					}
					else {
						basicX = 43 + i * g;
						basicY = 303;
						basicDir = 3;
					}
				}
				else {
					if(i % 2 == 0) {
						basicX = 43 + (i - 13) * l;
						basicY = 323;
						basicDir = 1;	
					}
					else {
						basicX = 43 + (i - 13) * l;
						basicY = 483;
						basicDir = 3;
					}
				}
				//根据出生点生成蛇
				for(var j = 0; j < otherSnakeLength[i]; j++) {
					if(basicDir == 0) {
						otherSnakeX[i][j] = basicX + j * 20;
						otherSnakeY[i][j] =	basicY;
					}
					else if(basicDir == 1) {
						otherSnakeX[i][j] = basicX;
						otherSnakeY[i][j] =	basicY + j * 20;
					}
					else if(basicDir == 2) {
						otherSnakeX[i][j] = basicX - j * 20;
						otherSnakeY[i][j] =	basicY;
					}
					else{
						otherSnakeX[i][j] = basicX;
						otherSnakeY[i][j] =	basicY - j * 20;
					}
					otherSnakeDirection[i][j] = basicDir;
					otherSnakePreDirection[i][j] = basicDir;
				}
			}
		}
		canvas = document.getElementById("canvas");
		width = canvas.width;
		height = canvas.height;
		context = canvas.getContext('2d');
		//初始化豆子
		for(var i = 0; i < bonusNumber; i++) {
			bonusX[i] = 13 + Math.floor((i * ((width - 20) / bonusNumber)) / 20) * 20;
			bonusY[i] = 13 + Math.floor((Math.random() * (height - 20)) / 20) * 20;
			random_num(i);
		}
		//初始化地图
		for(var i = 0; i < 30; i++) {
			for(var j = 0; j < 40; j++) {
				map[i * 40 + j] = 0;
			}
		}
		$('#score').html(score);
		$('#time').html(time);
		var colorstring = "";
		//初始化图例
		for(var i = 0; i < otherSnakeNumber; i++) {
			colorstring += "<div class=\"" + "column\" style=\"background-color:" + snake_colors[i] + "!important\">" + choice[i].toString() + "</div>"
			colorstring += "<div class=\"column\" id=\"score" + i + "\">" + otherSnakeScore[i].toString() + "_" + otherSnakeShieldNums[i].toString() + "_" + otherSnakeShieldTimes[i].toString() +  "</div>"
		}
		$('#note').html(colorstring);
		//刷新画图，50ms
		functionId = setInterval("draw()", 50);
		//计时器更新，1s
		timeFuncId = setInterval("set_time()", 1000);
	}

	//生成向后台传输的地图，豆子均为负分，蛇身为学号，蛇头为学号第4位+后3位
	function transform_to_map() {
		for(var i = 0; i < 30; i++) {// 初始化
			for(var j = 0; j < 40; j++) {
				map[i * 40 + j] = "0";
			}
		}
		for(var i = 0; i < bonusNumber; i++) { //豆子
			if(bonusX[i] == -10 || bonusY[i] == -10) {
				continue;
			}
			var bonus_x = (bonusX[i] - 13) / 20;
			var bonus_y = (bonusY[i] - 13) / 20;
			map[bonus_y * 40 + bonus_x] = bonus_value[bonusValue[i]] + "";
		}
		for(var i = 0;i < boxNumber;i ++){ //感觉也是豆子
			if(boxX[i] == -10 || boxY[i] == -10){
				continue;
			}
			var box_x = (boxX[i] - 13) / 20;
			var box_y = (boxY[i] - 13) / 20;
			map[box_y * 40 + box_x] = box_value[i] + "";
		}
		for(var i = 0; i < otherSnakeNumber; i++) { //蛇
			if(otherSnakeLength[i] > 0) {

				//蛇身 2019101404 -> 1911404
				for(var j = 2; j < otherSnakeLength[i]; j++) {
					var o_s_x = Math.floor((otherSnakeX[i][j] - 3) / 20);
					var o_s_y = Math.floor((otherSnakeY[i][j] - 3) / 20);
					map[o_s_y * 40 + o_s_x] = choice[i].substr(2,3) + choice[i].substr(6,4);
				}

				//蛇颈
				var o_s_x = Math.floor((otherSnakeX[i][1] - 3) / 20);
				var o_s_y = Math.floor((otherSnakeY[i][1] - 3) / 20);
				map[o_s_y * 40 + o_s_x] = choice[i].substr(2,3) + choice[i].substr(6,4) + otherSnakeShieldNums[i].toString();

				//蛇头
				var o_s_x = Math.floor((otherSnakeX[i][0] - 3) / 20);
				var o_s_y = Math.floor((otherSnakeY[i][0] - 3) / 20);
				if(otherSnakeShieldTimes[i] == 0){
					map[o_s_y * 40 + o_s_x] = choice[i][3] + choice[i].substr(choice[i].length - 3)+otherSnakeDirection[i][0].toString()+"";
				}
				else{
					map[o_s_y * 40 + o_s_x] = "-" + choice[i][3].toString() + choice[i].substr(choice[i].length - 3)+otherSnakeDirection[i][0].toString()+ (otherSnakeShieldTimes[i] / 10).toString() + "";
				}

			
				
			}
		}
	}

	//画图
	function draw() {
		if(game_over && falloff == 2) {
			clearInterval(functionId);
			clearInterval(timeFuncId);
			alert("游戏结束~");
		}
		else {
			if(game_over){
				falloff ++;
			}
			//画桌布
			context.clearRect(0, 0, width, height);
			context.save();
			context.fillStyle = "#262626";
			context.strokeStyle = "#4682B4";
			context.fillRect(3, 3, width - 3, height - 3);
			context.lineWidth = 3;
			context.strokeRect(0, 0, width, height);
			context.lineWidth = 1;
			//画格子
			for(var i = 0; i < 30; i++) {
				context.moveTo(3, 3 + i * 20);
				context.lineTo(803, 3 + i * 20);
			}
			for(var i = 0; i < 40; i++) {
				context.moveTo(3 + i * 20 ,3);
				context.lineTo(3 + i * 20 ,603);
			}
			context.strokeStyle = "#FFFFFF";
			context.stroke();
			//画蛇
			for(var i = 0; i < otherSnakeNumber; i++) {
				for(var j = 0; j < otherSnakeLength[i]; j++) {
					context.fillStyle = snake_colors[i];
					context.fillRect(otherSnakeX[i][j], otherSnakeY[i][j], 20, 20);
					if(j == 0 && otherSnakeShieldTimes[i] == 0) {
						context.strokeStyle = "#C0FF3E";
						context.lineWidth = 3;
						context.strokeRect(otherSnakeX[i][j] + 1, otherSnakeY[i][j] + 1, 17, 17);
					}else if(j == 0 && otherSnakeShieldTimes[i] > 0){
						context.strokeStyle = "#4285f4";
						context.lineWidth = 3;
						context.strokeRect(otherSnakeX[i][j] + 1, otherSnakeY[i][j] + 1, 17, 17);
					}
				}
			}
			//画豆子
			for(var i = 0; i < bonusNumber; i++) {

				if(bonusValue[i] == 5){
					var img=document.getElementById("shield")
					context.drawImage(img,bonusX[i]-10, bonusY[i]-10,20,20)
					continue;
				}

				if(bonusValue[i] == 4){
					var img=document.getElementById("douzi")
					context.drawImage(img,bonusX[i]-10, bonusY[i]-10,20,20)
					continue;
				}
				
				context.beginPath();
				context.fillStyle = bonus_color[bonusValue[i]];
				context.arc(bonusX[i], bonusY[i], 10, 0, Math.PI * 2, false);
				context.closePath();
				context.fill();
			}
			// draw box
			for(var i = 0; i < boxNumber; i++) {
				context.beginPath();
				context.fillStyle = box_color
				context.arc(boxX[i], boxY[i], 10, 0, Math.PI * 2, false);
				context.closePath();
				context.fill();
			}

			var colorstring = "";
			//初始化图例
			for(var i = 0; i < otherSnakeNumber; i++) {
				colorstring += "<div class=\"" + "column\" style=\"background-color:" + snake_colors[i] + "!important\">" + choice[i].toString() + "</div>"
				colorstring += "<div class=\"column\" id=\"score" + i + "\">" + otherSnakeScore[i].toString() + "_" + otherSnakeShieldNums[i].toString() + "_" + otherSnakeShieldTimes[i].toString() +  "</div>"
			}
			$('#note').html(colorstring);

			//如果刷新了10次，向后台请求数据，由于格子大小为20，每次移动2，10次正好走满一格
			if(refresh_times % 10 == 0) {
				transform_to_map();
				console.log("--------------------------------")
				console.log("本次的输入为:")
				console.log(map.join(" "));
				var post_data = $.ajax({
					type: "POST",
					data: {student_id:choice, map:map.join(" "), game_id:game, error_id:error_student_id},
					url: "background.php",
					async: false, //采用同步ajax，保证数据都能准确获得
					timeout: 100, //似乎采用同步方式以后，此处设置的超时并没有什么作用
					success: function(data, status) {
						var tmp_s = data.split(" ");
						console.log("本次的输出为:")
						console.log(tmp_s);	
						// console.log(game);
						console.log("------------------------------------")
						var tmp_dir = new Array();
						for(var i = 0; i < tmp_s.length; i++) {
							
							//后台返回值为“学号+空格+方向”，通过判断方向是否存在及取值是否合理决定蛇是否死亡
							var loc = $.inArray(tmp_s[i], choice);
							if(loc != -1) {
								if(parseInt(tmp_s[i + 1]) != 0 && parseInt(tmp_s[i + 1]) != 1 && parseInt(tmp_s[i + 1]) != 2 && parseInt(tmp_s[i + 1]) != 3  && parseInt(tmp_s[i + 1]) != 4) {
									otherSnakeLength[loc] = 0;
									error_student_id[loc] = 1;
								}
								else {
									otherSnakePreDirection[loc][0] = parseInt(tmp_s[i + 1]);
								}
							}
						}
					},
					error: function(data, statue) {
						console.log("接收数据出错啦！！！");
					},
					complete: function(XMLHttpRequest, status) {
						if(status == 'timeout') {
							post_data.abort();
							game_over = true;
							alert("超时啦！！！");
						}
					}
				});
				//只在整格点判断蛇是否相碰，否则可能由于一点点位置变化导致判断错误
				check_death();
				check_wall();
				refresh_times = 0;
			}
			othersnake_move();
			eat_bonus();
			eat_box();
			if(time % 10 == 0) {
				update_bonus();
			}
			refresh_times ++;
		}
	}

	//判断选择了多少选手，并记录学号
	function checkChoice() {
		var checklist = $(".checkbox").checkbox('is checked');
		var choice_num = 0;
		for(var i = 0; i < checklist.length; i++) {
			if(checklist[i] == true) {
				choice_num ++;
				choice.push($(".checkbox").children()[i * 2].name);
			}
		}
		if(choice_num > 25) {
			alert("你最多只能选25个选手呃...");
		}
		else if(choice_num < 1) {
			alert("你总得选点什么 ...");
		}
		if(choice_num <= 25) {
			otherSnakeNumber = choice_num;
			for(var i = 0; i < otherSnakeNumber; i++) {
				otherSnakeX[i] = new Array();
				otherSnakeY[i] = new Array();
				otherSnakeDirection[i] = new Array();
				otherSnakePreDirection[i] = new Array();
			}
			btn_begin();
			$(".ui.button").addClass("disabled");
		}
	}

	function addStus()
	{
		snos_str = $("#snos").val()
		snos = snos_str.split(" ")
		// console.log(snos)
		for(var i = 0; i < snos.length; i++){
			$(":checkbox[name='"+snos[i]+"']").prop("checked",true);
		}
		
		
	}

	//向后台请求同学们的程序列表
	$.ajax({  
		type: "POST",
		url: "get_file_list.php",
		success: function (data) {  
			var arr = data.split(" ");
			var s = "";
			for(var i = 0; i < arr.length - 1; i++) {
				s += "<div class=\"item\"><div class=\"ui checkbox\"><input type=\"checkbox\" name=\"" + arr[i] + "\"><label for=\"\">" + arr[i] + "</label></div></div>"
			}
			$("#filelist").html(s);
		},  
		error: function (data) {  
			alert("error");
		}
	});

	//计算每局对战ID
	var date = new Date();
	game = date.getHours() * 3600 + date.getMinutes() * 60 + date.getSeconds();
	
	</script>
</body>
</html>