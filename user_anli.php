<?

/**************************************************************

 File Name : user_anli.php   date:20120803 
 Programmer : LKS
 Statement : 
 analysis the user weak point and display the data of question.

 ****************************************************************/ 

	include("connect_db.php");
	include("header.php");
	include("db_name.php");
	$user = $_POST['id'];
	$hint = $_POST['hint'];
	$sp = $_POST['sp'];

?>

<html>
<head>
 <link type="text/css" rel="stylesheet" href="mainpage.css"> 
<title>弱點分析</title>
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <meta charset="big5" />
 <script src="Link.js"></script>
</head>
<body>
<div class="title">弱點分析</div>
<br>
<Center>
<pre>
弱點的定義為個人錯誤率達四成以上的題目, 
<?echo $user;?>請再針對這些題目做加強唷!
</pre>
<br>
<?
	if(!($hint == 1)){
?>
<input name="Submit" type="button" id="Submit" onClick="javascript:history.back(1)" value="回一上頁(r)" accesskey="r"/><br>
<?
	}else{
?>
	<input name="Submit" type="button" id="Submit" onClick="javascript:history.go(-2)" value="回一上頁(r)" accesskey="r"/><br>
<?
	}	
?>
<table border=1>
<tr>
	<td>題目代碼</td>
	<td>題目</td>
	<td>國語</td>
	<td>台語</td>
	<td>拼音</td>
	<td>英文</td>
	<td>錯誤率</td>
</tr>
<?
	if($sp != 1){
		$query = mysql_query("SELECT * FROM $user_db WHERE id = '$user'") or die(mysql_error());
	}else{
		$query = mysql_query("SELECT * FROM $user_spell_db WHERE id = '$user'") or die(mysql_error());
	}
	$user_total = mysql_num_rows($query) or die(mysql_error());
	$used_array = array();
	$error_array = array();
	$weak_array = array();

// process the used question

	for($i=0;$i<$user_total;$i++){

		$user_row = mysql_fetch_assoc($query) or die(mysql_error());
		$question = explode(',',$user_row['question']);
		for($j=0;$j<count($question);$j++){
			$qu_query = mysql_query("SELECT * FROM $question_db WHERE id =".$question[$j]);
			if($qu_query != false){
			//	$num = $used_array[$question[$j]];
			//	$num += 1;
				$used_array[$question[$j]] += 1;
			}
		}
				
// process the error question
		
		$question = explode(',',$user_row['error_qu']);
		for($j=1;$j<count($question);$j++){
			$qu_query = mysql_query("SELECT * FROM $question_db WHERE id =".$question[$j]);
			if($qu_query != false){
				$num = $error_array[$question[$j]];
				$num += 1;
				$error_array[$question[$j]] = $num;
				
			}
		}

	}
	
	$dele = mysql_query("DELETE FROM $user_db WHERE time1 = 0");
	$update = mysql_query("UPDATE $user_db SET end = 1 WHERE id = '$user'");
	
	do{
		$thekey = key($error_array);
		if($used_array[$thekey] != 0){
			$result = (current($error_array)/$used_array[$thekey]);
			 
			if($result >= 0.4){
				$qu_query = mysql_query("SELECT * FROM $question_db WHERE id =".$thekey);
				$qu_row = mysql_fetch_assoc($qu_query);
				$weak_array[] = $thekey;
				$cl_query = "SELECT * FROM $classfi_db WHERE id =".$qu_row['Class'];
				$cl_result = mysql_query($cl_query) or die(mysql_error());
				$cl_row = mysql_fetch_assoc($cl_result);
?>
		<tr>
			<td align=center>
			<? switch($qu_row['Level']){
				case 1: echo $cl_row['title']."A-".$qu_row['Num'];break;
				case 2: echo $cl_row['title']."B-".$qu_row['Num'];break;
				case 3: echo $cl_row['title']."C-".$qu_row['Num'];break; 
			}?></td>
			<td>
				<audio controls="controls">
					<source src="<?echo $qu_row['DataSource'];?>">
				</audio>

			</td>
			<td align=center><? echo $qu_row['Chinese'];?></td>
			<td align=center><? echo $qu_row['Ans'];?></td>
			<td align=center><? echo $qu_row['Spell'];?></td>
			<td align=center><? echo $qu_row['English'];?></td>
			<td align=center><?echo round($result*100,2)."%";?></td>
		</tr>
<?
			}
		}
	}while(next($error_array) != false);
	// foreach($weak_array as $value) echo $value."+";
	$allweak = implode(',',$weak_array);
	//echo $allweak;
?>
</table>
<? if($sp != 1) { ?>
<form action="answer_checkbox.php" id="weak_output" method="post">
<? }else{ ?>
<form action="spell_answer_checkbox.php" id="weak_output" method="post">
<? } ?>
<input type="hidden" name="all_question" value="<?echo $allweak;?>">
<input type="hidden" name="mode" value="Weak" >
<input type="submit" value="進行弱點測驗" >
</form>
</body>
</html>
