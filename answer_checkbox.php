<html>
<head>
<meta charset="big5" />
</head>
<?

/**************************************************************

 File Name : answer_checkbox.php   date:20120801 
 Programmer : LKS
 Statement : 
 this file used to process user's checkbox or question group.

 ****************************************************************/

	include("connect_db.php");
	include("header.php");
	include("db_name.php");
	$user = $_SESSION["sid"];
	$group = $_POST['gr_num']; // accept group radio which user checked .
	$mode = $_POST['mode'];
	$today = date('Y-m-d');
	$allquestion = $_POST['all_question'];  // for weak test
//	echo $allquestion;
//	echo $mode;

	
	if(!(empty($question)) || !(empty($group)) || ($mode == "Weak")){ 
		if(empty($group)){
		
				$question = $_POST["question"];  // accept checkbox which user checked .
				if($mode == "Weak") $question = explode(",",$allquestion);
				shuffle($question); // random this array
				$allquestion = implode(",",$question);
			//	echo "all:".$allquestion;
				// echo $allquestion;

		}else{

				$gr_query = mysql_query("SELECT * FROM $group_db WHERE id ='$group'");
				$gr_row = mysql_fetch_assoc($gr_query);
				$question = explode(",",$gr_row['question']);
				shuffle($question); // random this array
				$allquestion = implode(",",$question);

		}
		if($mode != "Weak"){
			$sql = "UPDATE `$user_db` SET `question` = '$allquestion',`mode` = '$mode', `group` = '$group' WHERE `id`= '$user' AND `end`= '0'";
		}else{
			$sql = "INSERT INTO `$user_db`(`id`,`date`,`question`,`mode`,`group`) VALUES('$user','$today','$allquestion','$mode','$group')";
		}
			$query = mysql_query($sql) or die(mysql_error());
		

		/* 

		$test = mysql_query("SELECT * FROM`$user_db` WHERE `id` = '$user' AND `end` = '0'");
		$row = mysql_fetch_assoc($test);
		echo $row["question"]; 
		
		*/
		echo "Loading...";
		
		header("Refresh: 3; url=answer.php"); // after 3 sec, to answer page
	}else{
	
		echo "未選擇任何題目 ! 請回到上一頁重新選取! (Alt + left)";
	}
	
?>
</html>
