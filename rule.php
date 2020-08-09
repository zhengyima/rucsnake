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
			<a class="item" href="game.php">Game</a>
			<a class="item" href="upload.php">Upload</a>
			<div class="active item">Rule</div>
		</div>
	</div>
	<div class="ui container">
		<div class="ui segment">
			<div class="ui dividing header">游戏规则</div>
			<div class="ui bulleted list">
				<div class="item">控制一条蛇与其他AI蛇进行对战</div>
				<div class="item">画面中橙色的蛇是你的，红色的蛇是AI，蛇头用绿色框框标出...圆形的东西是食物</div>
				<div class="item">蛇不允许原地回头，只可向左右转向</div>

				<div class="item">
					<div class="item">地图上有三种食物：普通豆子，增长豆，盾牌</div>
					<div class="list">
						<div class="item">当蛇头吃到普通豆子即可吃下并得1分，每得10分蛇长度加1。</div>
						<div class="item">当蛇头吃到增长豆，蛇长度+2</div>
						<div class="item">当蛇头吃下盾牌，可在之后主动使用盾牌，使自己处于三秒的保护状态。</div>
						
					</div>
				</div>
				<div class="item">使用盾牌后蛇第一秒会静止，然后恢复行动。处于保护状态的蛇不会死亡（除非撞墙），但其他蛇的蛇头碰到处于保护状态的蛇身或蛇头仍会死亡。</div>
				<div class="item">蛇头允许碰到自己的蛇身，但碰到其他蛇的蛇身，立刻死亡</div>

				<div class="item">当两蛇头相碰，同时死亡</div>
				<div class="item">当蛇头撞墙，立刻死亡，墙没有坐标，走至地图外即撞墙</div>
				<div class="item">当你的蛇已死亡，游戏结束，此时得分最高的蛇获胜</div>
				
			</div>
			<div class="ui dividing header">数据规则</div>
			<div class="ui bulleted list">
				<div class="item">上传文件进行对战，文件命名格式为"学号.c"，必须使用C文件进行上传且使用你的学号作为文件名</div>
				<div class="item">地图以左上角为(0,0)坐标点，其右侧坐标为(0,1)，下侧坐标为(1,0)，以此类推</div>
				<div class="item"><img class="ui small rounded image" src="pic2.png" alt=""></div>
				<div class="item">C程序接受输入为长1200的数组，代表地图的情况，数组前40个为第一行情况，依此类推</div>
				<div class="item">C程序输出为一个整型数字，代表当前决定的方向或使用盾牌，0为左，1为上，2为右，3为下, 4为使用盾牌</div>
				<div class="item">
					<div class="item">数组中数字的含义</div>
					<div class="list">
						<div class="item">0: 空</div>
						<div class="item">-x: 价值为x的事物(-100为增长豆，-10000为盾牌)</div>
						<div class="item">
							<div class="item" style="color:red;">你的蛇头：学号第四位+学号后三位+当前方向，例如2012202634正在向左走,对应蛇头为26340</div>
							<div class="list">
								<div class="item" style="color:blue;">当蛇正在使用盾牌时，蛇头表示为"学号第四位+学号后三位+当前方向+盾牌剩余秒数"且为负数，如上例蛇盾牌还剩一秒，则表示为-263401</div>
							</div>
						</div>
						
						<div class="item"  style="color:red">你的蛇身：学号3-5位+学号后四位(2019101404对应蛇身为1911404)</div>
						<div class="item"  style="color:red">你的蛇颈(蛇身所在的第一个格子):学号3-5位+学号后四位+拥有盾牌数: (拥有3个盾牌的2019101404，对应蛇颈为19114043)</div>
					</div>
				</div>
			</div>
			<div class="ui dividing header">注意</div>
			<div class="ui bulleted list">
				<div class="item">平台仍有不少错误及细节问题需要调试，请耐心等待...</div>
				<div class="item">请保证你的程序在100ms以内可以返回结果，否则会超时</div>
				<div class="item">请保证你的程序给出正确的返回值（0-4），其他返回值会报错</div>
				<div class="item">使用浏览器控制台(Chrome为例：在网页上右键>检查>Console)可以看到每个时刻的地图以及你的程序输出，可辅助调试程序</div>
				<div class="item">如果新的AI编译错误会继续使用旧的程序</div>
				<div class="item">可以在游戏开始前，在游戏界面上方自定义食物权重。</div>
			</div>
			<div class="ui dividing header">示例代码</div>
			<div class="ui bulleted list">
				<div class="item">完全随机：<a href="rand.c">rand.c</a></div>
				<div class="item">不会撞墙：<a href="demo.c">demo.c</a></div>
			</div>
			<!-- <div class="ui fluid rounded image"><img src="pic1.png" alt=""></div> -->
		</div>
	</div>
	<script type="text/javascript" src="jquery-3.2.0.min.js"></script>
	<script type="text/javascript" src="game.js" ></script>
</body>
</html>