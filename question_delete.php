<?

/**************************************************************

 File Name : question_delete.php   date:20120803 
 Programmer : LKS
 Statement : 
 accept the message from question_list.php and delete this question.

 ****************************************************************/ 

?>

<html>
<head>
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <meta charset="big5" />
 <script src="Link.js"></script>
</head>
<body>

<?
	include("connect_db.php");
	include("db_name.php");

	$id = $_GET['delete'];
	$query = mysql_query("SELECT * FROM $question_db WHERE id = '".$id."'");
	$row = mysql_fetch_assoc($query);
	if(!(empty($row['DataSource']))){
		if(unlink($row['DataSource'])){
			echo "檔案刪除成功!!<br>";
		}else{
			echo "檔案刪除失敗!!<br>";
		}
	} // if($row['DataSource'] != null){
	$delete = "DELETE FROM $question_db WHERE id = '".$id."'";
	if(mysql_query($delete)){
		echo "刪除成功!!<br>";
	}else{
		echo "刪除失敗!!<br>";
	}

?>
<br>
<a href="question_list.php">回清單</a>
</body>
</html>