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
    
	$cl_result = mysql_query("SELECT * FROM `$classfi_db` WHERE `id` = '$classfi'") or die(mysql_error());
	$cl_row = mysql_fetch_assoc($cl_result);
	
	switch($level)
	{
			case 1: $group = $cl_row['title']."A-".$range;break;
			case 2: $group = $cl_row['title']."B-".$range;break;
			case 3: $group = $cl_row['title']."C-".$range;break; 
	}

	$q_sql = "SELECT * FROM `$question_db` WHERE `Class` = '$classfi' AND `Level` = '$level' `Finish`='0'";
	$q_query = mysql_query($q_sql) or die(mysql_error());
	$q_total = mysql_num_rows($q_query);
	// echo "range = ".$range;
	if( ($range + 49) < $q_total )  // 一組題組 50題
	{
		for($i=$range+1;$i<$range+50;$i++)
		{
			if($i<10) $tmp = "00".$i;    // 處理編號為varchar的格式
			else if($i<100) $tmp = "0".$i;
			else $tmp = $i;
			$q_sql = "SELECT * FROM `$question_db` WHERE `Class` = '$classfi' AND `Level` = '$level' AND `Num` = '$tmp' `Finish`='0'";
			$q_query = mysql_query($q_sql) or die(mysql_error());
			$q_row = mysql_fetch_assoc($q_query);
			if(empty($allquestion)){
					$allquestion = $q_row['id'];
			}else{
					$allquestion = $allquestion.",".$q_row['id'];
				}
		//	echo $allquestion."</br>";
		}
	}
	else
	{
		for($i=$range;$i<=$q_total;$i++)  // 當剩下題目不足50題則只算到最後一題
		{
			if($i<10) $tmp = "00".$i;
			else if($i<100) $tmp = "0".$i;
			else $tmp = $i;
			$q_sql = "SELECT * FROM `$question_db` WHERE `Class` = '$classfi' AND `Level` = '$level' AND `Num` = '$tmp' `Finish`='0'";
			$q_query = mysql_query($q_sql) or die(mysql_error());
			$q_row = mysql_fetch_assoc($q_query);
			if(empty($allquestion)){
					$allquestion = $q_row['id'];
			}else{
					$allquestion = $allquestion.",".$q_row['id'];
				}
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