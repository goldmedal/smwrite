<html>
<head>
<meta charset="big5" />
</head>
<?

/**************************************************************

 File Name : answer_checkbox.php   date:20121119 
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
	
	if(!(empty($question))){
		if(empty($group)){
			$question = $_POST["question"];  // accept checkbox which user checked .
			shuffle($question); // random this array
			$allquestion = implode(",",$question);
			
		}else{
			$gr_query = mysql_query("SELECT * FROM $group_db WHERE id ='$group'");
			$gr_row = mysql_fetch_assoc($gr_query);
			$question = explode(",",$gr_row['question']);
			shuffle($question); // random this array
			$allquestion = implode(",",$question);

		}
		
		$sql = "UPDATE `$user_spell_db` SET `question` = '$allquestion', `Mode` = '$mode', `group` = '$group' WHERE `id`= '$user' AND `end`= '0'";
		$query = mysql_query($sql) or die(mysql_error());

		/* 

		$test = mysql_query("SELECT * FROM`$user_spell_db` WHERE `id` = '$user' AND `end` = '0'");
		$row = mysql_fetch_assoc($test);
		echo $row["question"]; 
		
		*/

		header("Refresh: 3; url=spell_answer.php"); // after 3 sec, to answer page
		echo "Loading...";
	}else{
	
		echo "未選擇任何題目 ! 請回到上一頁重新選取! (Alt + left)";
	}
	
?>
</html>