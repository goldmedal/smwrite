<!DOCTYPE html>

<?php

	/*
		1. read the nowNum from GET
		2. get question
	*/

	require_once "funcAnsUser.php";
	$user = $_GET['uid']; 
	$uquery = mysql_query("SELECT `num`, `question` FROM `$user_db` WHERE `id` = '$user' AND `end` = '0'") or die(mysql_error());
	$user_row = mysql_fetch_assoc($uquery);
	$questionRow = explode(",", $user_row['question']);
	$total = count($questionRow);
	$nowNum = ($_GET['nowNum'] > 0)?$_GET['nowNum']:0;
	$firstQid = getNowQid($nowNum, $user_row['question']);
	$firstQrow = getQuesInformation($firstQid);

	/* record start time */
	
	if($nowNum == 0) {
	
		$time1 = date("H:i:s",mktime(date('H'),date('i'),date('s')));
		mysql_query("UPDATE $user_db SET time1 = '$time1' WHERE id = '$user' AND end = '0' ")or die(mysql_error());

	}

?>
<html>
	<head>
		<title>Screw - SMwrite�x�y�~�r�˴��t�� - ���礤</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script src="../jquery.hotkeys.js"></script>
		<script src="answer.js"></script>
		<script>

		//	var uid = "<? echo empty($_GET['sid'])?'none':$_GET['sid']; ?>";
			var uid = "LKS201111";
			var nowId = "<? echo $nowNum; ?>";
			var qid = "<? echo $firstQid; ?>";
			var answerChecker = checkClosure();
			var userText = 0;

			function answerSubmitFunc(_checker){

				var ans = $('#userAnswer').val();
				_checker(uid, qid, ans, nowId);

			}

			function keyFunction() {

				if (event.keyCode==81 && event.altKey) {
					$('#audioQuestion').trigger('play');
				}else if(event.keyCode == 13 && userText == 1){
					$('#submitAnswer').click();
				}

			}	

			function answerPaste(){
				alert("�Цۤv��J��! �����D�����Ϊ`������, ��Google�a!");
			}		

			$(document).ready( function() {

				var playTime = 0; 
				document.onkeydown = keyFunction;

				$('#submitAnswer').click(function(){
					var answer = $('#userAnswer').val();
					if(answer) {
						answerSubmitFunc(answerChecker);
					}
				});

				$('#userAnswer').focus(function(){
					userText = 1;
				});

				$('#userAnswer').blur(function(){
					userText = 0;
				});

				$('#audioQuestion').bind("ended", function() {

					if(playTime == 0){
						$('#audioQuestion').trigger('play');
						playTime = 1;
					}

				});

				
			});
		</script>
		<link rel='stylesheet' href='answer.css' />
		<meta charset='big5' />
	</head>
	
	<body>
	
		<header>
			<div id="title">Screw - SMwrite�x�y�~�r�˴��t�� - ���礤</div>
			<div id="note">�в�ť��y�����A�D�ئb��y�������᭱</div>
		</header>
		<div id="middle">
			<article id="answer">
			</article>
			<article id="question">
				<section id="user">���ժ�: <? echo $user; ?></section>
				<section id="numPart">�� <span id="nowNum"><? echo $nowNum+1; ?></span> �D / �@ <? echo $total ?> �D</section>
				<section id="idPart">�D�w�N�X: 
					<span id="nowQid">
					<?
						$ClassLevel = getClassLevel($firstQrow['Class'], $firstQrow['Level']);
						echo $ClassLevel.$firstQrow['Num'];
					?>
					</span>
				</section>
				<audio id="audioQuestion" controls autoplay preload>
					<source src="../<?echo $firstQrow['DataSource']; ?>">
				</audio>
				<section id="ansPart">
					<label>�п�J����(a): </label>
					<input type='text' id='userAnswer' onpaste="answerPaste();return false" autofocus accesskey="a" />
					<button id='submitAnswer'>�e�X</button>
				</section>
			</article>
		</div>
		
		<aside>
			<section id="operaPart">
				<div class="remidTitle">�ֱ���</div>
				<ol>
					<li>�� Alt+a ��ֳt��F���D��</li>
					<li>�� Enter �^�����D</li>
					<li>
						�� Enter ���J�U�@�D or �ݵ��G <br />
						<span class='note'> �p�L�k�ϥ�Space�ֱ���,�й��ե�Ctrl+Space������J�k�Ҧ�, �A����space���D�� </span>
					</li>
					<li>�� Alt+q �i�H�Ať�@���D��</li>
					
					
				</ol>
			</section>
			
			<section id="standardPart">
				<div class="remidTitle">���D�з�</div>
				<ul>
					<li>
						�i���S�i��N���~�r���̨ΡC<br />
						��J�Ҥl�J�ݧ�
					</li>
					<li>
						��u��H�~�r��N�ɡA���n�ɦb�r�᭱�[�A���Щ������P��o���n�զӫD���աC<br />
						��J�Ҥl�J��(ging7)
					</li>
					<li>
						��u��H�������ɡA���n�ɦb�᭱�[�A�������y�N�A<br />�H��KŪ�̤F�ѫ����ҥN���y�N�C<br />
						��J�Ҥl�Jmoh4���h(���U�h) ue5(�������H���s��)
					</li>
					<li>	
						�Y���~�r�i�K����o���ɡA�᭱�[�A���g�W��Ķ�������N��C<br />
						��J�Ҥl�J�����H(�a�H) �Z��(�]�\)
					</li>
				</ul>
			</section>
		</aside>
		
	</body>
</html>