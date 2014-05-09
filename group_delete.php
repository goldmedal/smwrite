<?

/**************************************************************

 File Name : group_delete.php   date:20120803 
 Programmer : LKS
 Statement : 
 accept the message from question_list.php and delete this group.

 ****************************************************************/ 

 ?>

<html>
<head>
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	

 <script src="Link.js"></script>
  <meta http-equiv="Content-Type" content"text/html; charset="big5"/>
</head>
<body>
<?
	include("connect_db.php");
	include("db_name.php");

	$num = $_POST['delete'];
	$cl_query = mysql_query("SELECT * FROM $group_db WHERE id = '$num'") or die(mysql_error());
	$cl_row = mysql_fetch_assoc($cl_query);
	  // record it's name to user record when it's deleted
	$update = mysql_query("UPDATE `$user_db` SET `group` = '".$cl_row['name']."' WHERE `group` =".$num) or die(mysql_error());
	

	$delete = "DELETE FROM $group_db WHERE id = '".$num."'";
	if(mysql_query($delete)){
		echo "刪除成功<br>";
	}else{
		echo "刪除失敗 ".mysql_error()."<br";
	}

?>
<br>
<a href="question_list.php">回清單</a>
</body>
</html>