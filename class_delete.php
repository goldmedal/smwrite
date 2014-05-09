<?
/**************************************************************

 File Name : class_delete.php   date:20120801 
 Programmer : LKS
 Statement : 
 process the delete class action from question_list.php

 ****************************************************************/
?>
<html>
<head>
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <script src="Link.js"></script>
 <meta charset="big5" />
</head>
<body>
<?
	include("connect_db.php");
	include("db_name.php");

	$num = $_POST['delete'];

	$delete = "DELETE FROM $classfi_db WHERE id = '".$num."'";
	if(mysql_query($delete)){
		echo "刪除成功<br>";
	}else{
		echo "刪除失敗 ".mysql_error()."<br>";
	}

?>
<br>
<a href="question_list.php">回清單</a>
</body>
</html>