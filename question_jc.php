<?

/**************************************************************

 File Name : question_jc.php   date:20140812 
 Programmer : LKS
 Statement : 
 accept the message from question_list.php and update the JC item;

 ****************************************************************/ 

?>

<html>
<head>
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
  <meta http-equiv="Content-Type" content"text/html; charset="big5"/>
 <script src="Link.js"></script>
</head>
<body>

<?
	include("connect_db.php");
	include("db_name.php");

	$JCType = $_POST['JCType'];
	$JCarray = implode(",",$JCType);
	
	foreach($JCType as $key => $index){
	
		mysql_query("UPDATE $question_db SET JC = '1' WHERE `id` = '$index' and `JC`='0'");
	
	}
?>
<br>
JC 更新成功！
<a href="question_list.php">回清單</a>
</body>
</html>