<?php

	require "fncAnsUser.php";
	$func = $_GET['func'];
	$uid = $_GET['uid'];
	$nowQuesNum = $_GET['nowQuesNum'];
	
	switch($func) {
	
		case 0:   // question number change
			$uquery = mysql_query("SELECT `question` FROM `$user_db` WHERE `num` = '$uid'");
			$user_row = mysql_fetch_assoc($uquery);
			$qrow = explode(',',$user_row['question']);
			$qid = $qrow[$nowQuesNum];
			$qquery = mysql_query("SELECT * FROM `$question_db` WHERE `id` = '$qid'");
			$qrow = mysql_fetch_assoc($qquery);
			$qrow['classfi'] = getClassLevel($qrow['classfi'],$qrow['level']);
			echo $json = json_encode($qrow);
			break;
			
		case 1:  // log time1
		
			$time1 = date("H:i:s",mktime(date('H'),date('i'),date('s')));
			mysql_query("UPDATE $user_db SET time1 = '$time1' WHERE id = '$user' AND end = '0' ")or die(mysql_error());
	
	}

?>