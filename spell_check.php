<html>
<head>
<meta charset="big5" />
</head>
<?

/**************************************************************

 File Name : spell_answer_check.php   date:20121119 
 Programmer : LKS
 Statement : 
 accept the data from answer.php.
 this file used to check the answer whether it's correct.

 ****************************************************************/

	include("connect_db.php");
	include("header.php");
	include("db_name.php");

	$user = $_SESSION['sid'];
	$user_query = "SELECT * FROM $user_spell_db WHERE id = '$user' AND end = '0'";
	$user_result = mysql_query($user_query);
	$user_row = mysql_fetch_array($user_result);

	$user_answer = $_POST["user_answer"];  // get user answer
	$false_time = $user_row["false_time"];
	$user_num = $user_row["num"];
	$false_num = $user_row["false_num"]; // answer false num
	$ture_num =  $user_row["true"]; // answer true num
	$running = $user_row["running"];
	$sum = $user_row["sum"];
	$qu_end = $user_row["qu_end"];
	$error_qu = explode(",",$user_row["error_qu"]);

	$question_num = $_POST["id"]; 
	$question_total = $_POST["total"]-1;

	$myquery = "SELECT * from $question_db where id='".$question_num."'";
	$result = mysql_query($myquery);
	$row = mysql_fetch_array($result); // get the question answer
	$all_false = $row["False_time"];
	
	if($qu_end == 0 || $qu_end == 2){ // count this question's time of used.  qu_end = 0 or 2 mean doesn't false yet.
		$use = $row["Use_time"] + 1;
		mysql_query("UPDATE $question_db SET Use_time = '$use' WHERE id = '$question_num'");
	}


	if($user_answer == NULL) {
		echo " ";
	}

	else if($user_answer == $row["Spell"]){

		if($qu_end == 2 || $qu_end == 3){ // for only the last question and right
			if($qu_end == 2){// prevent the sum be added extraly
				$sum++;
				$qu_end = 3;
			}// if($qu_end == 2)
		//	mysql_query("UPDATE $user_spell_db SET running=0 WHERE num = ".$user_num); //initial the running to 1
			$time2 = date("H:i:s",mktime(date('H')+8,date('i'),date('s')));
			mysql_query("UPDATE $user_spell_db SET time2 = '$time2' WHERE id = '$user' AND end = '0' ")or die(mysql_error());
			if($qu_end == 3){
				echo "國語:".$row['Chinese']." 台語:".$row['Ans']."<br>";
				echo "拼音:".$row['Spell']." 英文:".$row['English']."<br>";
				echo "恭喜你完成了本次測驗！<br>";
				mysql_query("UPDATE $user_spell_db SET finish = '1' WHERE id = '$user' AND end = '0' ");
				echo "<form action='spell_answer_result.php' method='post' target='_parent' name='nextqu'>";
				echo "<input type='hidden' value='1' name='check'>";
				echo "<input type='submit' value='看結果' name='next'></form>";
			}// if($qu_end == 3){
		}// if($qu_end == 2 || $qu_end == 3){

		else if($running <= $question_total){ // doesnt' reach the last question
			if($qu_end == 0){ // prevent the sum and false_time be added extraly
				$sum++;
				$false_time = 0;
				$qu_end = 1;
				mysql_query("UPDATE $user_spell_db SET running = ".++$running." WHERE num = ".$user_num); //count q_num 

			}
			if($qu_end == 1){
				echo "恭喜你答對了 =D <br>";
				echo "國語:".$row['Chinese']." 台語:".$row['Ans']."<br>";
				echo "拼音:".$row['Spell']." 英文:".$row['English']."<br>";
				echo "<form action='spell_answer.php' method='post' name='nextqu' target='_parent'>";
				echo "<input type='hidden' value='1' name='check'>";
				echo "<input type='submit' value='下一題' name='next'></form>";
			}
		} // else if($running <= $question_total){
	}//else if($user_answer == $row["Ans"])

	else if($user_answer != $row["Spell"] && $false_time == 0 && ($qu_end == 0 || $qu_end == 2)){ //  when answer is error
		
		mysql_query("UPDATE $user_spell_db SET false_num = ".++$false_num." WHERE num = ".$user_num) or die(mysql_error());  
		
		$all_false++;  // count this question all false time.
		mysql_query("UPDATE $question_db SET False_time = '$all_false' WHERE id = '$question_num'"); // update the db data
		echo "答錯了喔！ ";
		$cont = count($error_qu);
		$error_qu[$cont] = $question_num;
		$new_error = implode(",",$error_qu); // record user failed in this question
		mysql_query("UPDATE $user_spell_db SET error_qu = '$new_error' WHERE num = $user_num") or die(mysql_error());
		$false_time++;
	}
	else if($user_answer != $row["Spell"] && $false_time == 1 && ($qu_end == 0 || $qu_end == 2)){
		echo "不對不對！ ";
		$false_time++;
	}
	else if($user_answer != $row["Spell"] && $false_time == 2 && ($qu_end == 0 || $qu_end == 2)){
		echo "吼~ 行不行阿？ ˊ_>ˋ<br>";
		echo "加油好嗎好嗎好嗎?<br>";
		$false_time++;
	}
	else if($user_answer != $row["Spell"] && $false_time >= 3 && ($qu_end == 0 || $qu_end == 2 )){
		echo "好拉! 答案是:".$row["Spell"];
	}
	else if($user_answer != $row["Spell"] && ($qu_end == 1 || $qu_end == 2 || $qu_end == 3)){
		echo "都答對了, 又把答案改錯<br>真是受不了你耶！";
	}
	mysql_query("UPDATE $user_spell_db SET qu_end = '$qu_end' WHERE num = ".$user_num);
	mysql_query("UPDATE $user_spell_db SET false_time = '$false_time',sum = '$sum' WHERE num = ".$user_num); // count false_time by DB.

?>
</html>