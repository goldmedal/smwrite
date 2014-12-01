<?php

	require_once('../connect_db.php');
	require_once('../db_name.php');
	
	function getQuesInformation ($qid) {

		global $question_db;
		$query = "SELECT * FROM `$question_db` WHERE `id` = '$qid'";
		$result = mysql_query($query) or die (mysql_error());
		$row = mysql_fetch_assoc($result);
	//	if(!empty($row['Ans'])) die("hello:".$row['Ans']);
		return $row;

	}

	function countError ($uid, $qid) {

		global $user_db;
		global $question_db;
		$uquery = mysql_query("UPDATE `$user_db` SET `false_time` = false_time+1 WHERE `num` = '$uid' AND `end` = '0'") or die(mysql_error());
		$qquery = mysql_query("UPDATE `$question_db` SET `False_time` = False_time+1 WHERE `id` = '$qid'") or die(mysql_error());

	}

	function recordError ($uid, $qid) {
	
		global $user_db;
		$uquery = mysql_query("SELECT `error_qu` FROM `$user_db` WHERE id = '$uid' AND `end` = '0'") or die(mysql_error());
		$user_row = mysql_fetch_assoc($uquery);
		$error_row = explode(",", $user_row['error_qu']);
		$cont = count($error_row);
		$error_row[$cont] = $qid;
		$new_row = implode(",", $error_row);
		$uquery = mysql_query("UPDATE `$user_db` SET `error_qu` = '$new_row' WHERE id = '$uid' AND `end` = '0'") or die(mysql_error());
	
	}
	
		
	function getClassLevel($class, $level) {
	
		global $classfi_db;
		$cl_query = "SELECT * FROM `$classfi_db` WHERE `id` ='".$class."'";
		$cl_result = mysql_query($cl_query) or die(mysql_error());
		$cl_row = mysql_fetch_assoc($cl_result);
		
		switch($level){

			case 1: return $cl_row['title']."A-";
			case 2: return $cl_row['title']."B-";
			case 3: return $cl_row['title']."C-";
		}
	
	}

	function getNowQId($nowNum, $userQuestion){

		$questionRow = explode(",", $userQuestion);
		if($nowNum < count($questionRow)){

			return $questionRow[$nowNum];

		} else {

			return FALSE;

		}

	}
	
?>