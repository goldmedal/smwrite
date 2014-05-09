<?php

	include('connect.php');
	include('db_name.php');
	
	function getQuestion ($qid) {

		$query = "SELECT * FROM `$question_db` WHERE `id` = '$qid'";
		$result = mysql_query($query) or die (mysql_error());
		$row = mysql_fetch_assoc($result);
		return $json = json_encode($row);

	}

	function countError ($uid, $qid) {

		$uquery = mysql_query("SELECT `false_time` FROM '$user_db' WHERE `num` = '$uid' ");
		$qquery = mysql_query("SELECT `False_time` FROM '$question_db' WHERE `id` = '$qid'");
		$utime = mysql_fetch_assoc($uquery);
		$qtime = mysql_fetch_assoc($qquery);
		
	}

?>