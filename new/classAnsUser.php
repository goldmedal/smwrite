<?php

	include('connect.php');
	include('db_name.php');
	
	class User {
	
		var $id;
		var $selectQuestion[];
		var $errorQuestion[];
		var $singleFalseNum = 0;
		
		function _construct( $uid ) {
		
			$this->id = $uid;
			$getQuestionQuery = mysql_query("SELECT `question` FROM `$user_db` WHERE `id` = '$this->id' AND `end` = '0'");
		
		}
		
	}

?>