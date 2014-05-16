<?

/**************************************************************

 File Name : answer.php   date:20120801 
 Programmer : LKS
 Statement : 
 this file is used to play questions and give user block to input answer.
 It has two frame. one is itself, anotehr is answer_check.php which can check answer whether it's correct or not.

*****************************************************************/

	include("connect_db.php");
	include("header.php");
	include("db_name.php");
	$user = $_SESSION["sid"];
?>

<html>
<head>
<title>Screw - SMwrite台語漢字檢測系統 - 測驗中 </title>
 <link type="text/css" rel="stylesheet" href="mainpage.css"> 
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <script src="Link.js"></script>
</head>

<body>
<div class='title'>Screw - SMwrite台語漢字檢測系統 - 測驗中</div>
<fieldset class='remind'>
<legend>請聆聽整句錄音，題目在整句錄音的後面</legend>
<pre>
1. 可表音又可表意的漢字為最佳。
     輸入例子︰胸坎 
2. 當只能以漢字表意時，必要時在字後面加括號標明拼音與實發的聲調而非本調。
    輸入例子︰凝(ging7) 
3. 當只能以拼音表音時，必要時在後面加括號說明語意，以方便讀者了解拼音所代表的語意。
    輸入例子︰moh4落去(陷下去)  ue5(“有的人”連音) 
4. 若有漢字可貼切表發音時，後面加括號寫上對譯詞說明意思。
    輸入例子︰散食人(窮人)   凡勢(也許)	
</pre>
</fieldset>
<fieldset class='remind'>
<pre>
<legend>懶人不用滑鼠答題技巧：</legend>
1. 按 Alt+a 能快速到達答題區
2. 按 Enter 回答問題
3. 按 Space 跳入下一題 or 看結果 ( 如無法使用Space快捷鍵, 請嘗試先Ctrl+Space關閉輸入法模式, 再換按space換題目 )
4. 按 Alt+q 可以再聽一次題目
</pre>
</fieldset>
<br><br>
<?

	$user_query = "SELECT * FROM $user_db WHERE id = '$user' AND end = '0'";/* select the new user record. 
										                                         the end is check whether this test end or not. */
	$user_result = mysql_query($user_query) or die(mysql_error());
	$user_row = mysql_fetch_array($user_result);

	echo "<center>受試者:".$user_row['id']."</center><br>";

	
	mysql_query("UPDATE $user_db SET qu_end = 0, false_time =0 WHERE id = '$user' AND end = '0'") or die(mysql_error());
																			//initial the qu_end and false each question start
	$question_num = $user_row["running"];
	$question_base = explode(",", $user_row['question']); 
	$total = count($question_base);
	if($question_num == ($total-1)){   // only the last question, set qu_end = 2 for entering another loop.
		mysql_query("UPDATE $user_db SET qu_end = 2 WHERE id = '$user' AND end = '0'");
	}
	$place = $question_num + 1; // running is start from 0;
	echo "<center>第 ".$place." 題 / 共 $total 題</center>";

// select question by serial number

	$myquery = "SELECT * FROM $question_db WHERE id = '$question_base[$question_num]' ";  // 
	$result = mysql_query($myquery); 
	$row = mysql_fetch_assoc($result);
	$cl_query = "SELECT * FROM $classfi_db WHERE id =".$row['Class'];
	$cl_result = mysql_query($cl_query) or die(mysql_error());
	$cl_row = mysql_fetch_assoc($cl_result);

	if($question_num == 0){
	
		$time1 = date("H:i:s",mktime(date('H'),date('i'),date('s')));
		mysql_query("UPDATE $user_db SET time1 = '$time1' WHERE id = '$user' AND end = '0' ")or die(mysql_error());
		
	}

	switch($row['Level']){
	
			case 1: echo "<center>題庫代碼：".$cl_row['title']."A-".$row['Num']."</center>";break;
			case 2: echo "<center>題庫代碼：".$cl_row['title']."B-".$row['Num']."</center>";break;
			case 3: echo "<center>題庫代碼：".$cl_row['title']."C-".$row['Num']."</center>";break;

	}
?>

	<center>
	<audio id="question" controls autoplay preload>
		<source src="<?echo $row['DataSource'];?>">
	</audio>
	</center> 

<script type="text/javascript">   //For audio's two loop

<!--
	var time = 0;

	document.getElementById("question").addEventListener('ended',function(){
		if(time==0){
			document.getElementById("question").play();
			time = 1;
			}
	}, false);

	function hi(){ // close the copy function
		alert("自己輸入喔!!");
	}
	document.captureEvents(Event.KEYDOWN);

//-->

function keyFunction() {
	if (event.keyCode==81 && event.altKey) {
		document.getElementById("question").play();	
	}else if(event.keyCode==32){

		var frm = document.getElementById('SfMessCopyFrame');
		if(frm.contentDocument.nextqu.check.value == 1){
	        if(event.which==32){
				frm.contentDocument.nextqu.next.click();
			}
		}
	}

}

document.onkeydown=keyFunction;

</script>


<br>
<center>

<form action='answer_check.php' method='post' target='SfMessCopyFrame'>
<input type='hidden' name='id' value="<?echo $row['id'];?>"> <!-- tranfer question's num -->
<input type='hidden' name='total' value="<?echo $total;?>">
<label>請輸入答案(a):</label><input type='text' name='user_answer' autofocuse autocomplete="off" onpaste="hi();return false" accesskey='a' /> 
<input type='submit' value='送出'>

</form></center>

</body>
</html>

<center><iframe id="SfMessCopyFrame" name="SfMessCopyFrame" src="answer_check.php" width="250" height="250" scrolling="no" frameborder="0" accesskey='q'></iframe></center>