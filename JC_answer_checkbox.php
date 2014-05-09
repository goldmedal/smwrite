<?
/**************************************************************

 File Name : test_answer_list.php   date:20140103 
 Programmer : LKS
 Statement :  處理類別測驗時，使用者所選取的題目群組

 ****************************************************************/

	include("connect_db.php");
	include("header.php");
	include("db_name.php");
	
	$user = $_SESSION["sid"];
	$classfi = $_POST['classfi'];
	$level = $_POST['level'];
	$mode = $_POST['mode'];
	$range = $_POST['group'];
	$i = 0;
	
	
	$cl_result = mysql_query("SELECT * FROM `$classfi_db` WHERE `id` = '$classfi'") or die(mysql_error());
	$cl_row = mysql_fetch_assoc($cl_result);
	
	switch($level)
	{
			case 1: $group = $cl_row['title']."A";break;
			case 2: $group = $cl_row['title']."B";break;
			case 3: $group = $cl_row['title']."C";break; 
	}
	
	$q_sql = "SELECT * FROM `$question_db` WHERE `JC` = '1' AND `Finish`='0'";
	$q_query = mysql_query($q_sql) or die(mysql_error());
	$q_total = mysql_num_rows($q_query);
	
	// echo "range = ".$range;
	
	if( ($range + 49) < $q_total )  // 一組題組 50題
	{	
		$q_sql = "SELECT * FROM `$question_db` WHERE `JC` = '1' AND `Finish`='0'";
		$q_query = mysql_query($q_sql) or die(mysql_error());
		
		while($i<=($range+49)){

			$q_row = mysql_fetch_assoc($q_query);
			
			if($i >= $range){

				if(empty($allquestion)){
					$allquestion = $q_row['id'];
				}else{
					$allquestion = $allquestion.",".$q_row['id'];
				}

			}
			
			$i++;
		}
	}
	else{	
			$q_sql = "SELECT * FROM `$question_db` WHERE `JC` = '1' AND `Finish`='0'";
			$q_query = mysql_query($q_sql) or die(mysql_error());
			
		while($i <= ($q_total)){
		
			$q_row = mysql_fetch_assoc($q_query);
			if($i >= $range){

				if(empty($allquestion)){
					$allquestion = $q_row['id'];
				}else{
					$allquestion = $allquestion.",".$q_row['id'];
				}

			}
			$i++;
		}
	}


	$question = explode(",",$allquestion);
	shuffle($question); // random this array
	$allquestion = implode(",",$question);
	
		
	$sql = "UPDATE `$user_db` SET `question` = '$allquestion', `mode` = '$mode', `group` = '$group' WHERE `id`= '$user' AND `end`= '0'";
	$query = mysql_query($sql) or die(mysql_error());

	
/*	$test = mysql_query("SELECT * FROM`$user_db` WHERE `id` = '$user' AND `end` = '0'");
	$row = mysql_fetch_assoc($test);
	echo $row["question"];
	
	*/ 
	
	

	header("Refresh: 3; url=answer.php"); // after 3 sec, to answer page
	
?>

Loading...