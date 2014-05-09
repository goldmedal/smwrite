<! DOCTYPE html>
<?php

	include("connect_db.php");
	include("db_name.php");
	$user = $_SESSION['sid'];
	
?>
<html>
	<head>
		<title>Screw - SMwrite台語漢字檢測系統 - 測驗中 </title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script src="jquery.hotkeys.js"></script>	
		<link rel='stylesheet' href='css/answer.css' />
		<meta charset='big5' />
	</head>
	
	<body>
	
		<header>Screw - SMwrite台語漢字檢測系統 - 測驗中</header>
		<div id="note">請聆聽整句錄音，題目在整句錄音的後面</div>
		
		<article id="question">
			<section id="user">受試者: <?echo $user; ?></section>
			<section id="numPart">第 1 題 / 共 50 題</section>
			<section id="idPart">題庫代碼: SHA-249</section>
			<audio id="question" controls autoplay preload>
				<source src="">
			</audio>
			<section id="ansPart">
				<label>請輸入答案(a): </label>
				<input type='text' id='userAnswer' />
				<button id='submitAnswer' value='送出' />
			</section>
		</article>
		
		<article id="answer">
		</article>
		
		<aside>
			<section id="operaPart">
				<div class="remidTitle">快捷鍵</div>
				<ol>
					<li>按 Alt+a 能快速到達答題區</li>
					<li>按 Enter 回答問題</li>
					<li>
						按 Space 跳入下一題 or 看結果 <br />
						<span class='note'>( 如無法使用Space快捷鍵,請嘗試先Ctrl+Space關閉輸入法模式, 再換按space換題目 )</span>
					</li>
					<li>按 Alt+q 可以再聽一次題目</li>
					
				</ol>
			</section>
			
			<section id="standardPart">
				<ul>
					<li>
						可表音又可表意的漢字為最佳。<br />
						輸入例子︰胸坎 
					</li>
					<li>
						當只能以漢字表意時，必要時在字後面加括號標明拼音與實發的聲調而非本調。<br />
						輸入例子︰凝(ging7)
					</li>
					<li>
						當只能以拼音表音時，必要時在後面加括號說明語意，以方便讀者了解拼音所代表的語意。<br />
						輸入例子︰moh4落去(陷下去)  ue5(“有的人”連音) 
					</li>
					<li>
						若有漢字可貼切表發音時，後面加括號寫上對譯詞說明意思。<br />
						輸入例子︰散食人(窮人)   凡勢(也許)	
					</li>
				</ul>
			</section>
		</aside>
		
	</body>
</html>