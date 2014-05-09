<?

/**************************************************************

 File Name : question_jc_delete.php   date:20140312 
 Programmer : LKS
 Statement : 
 accept the message from question_list.php and delete the JC item.

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

	$id = $_GET['id'];
	mysql_query("UPDATE $question_db SET JC = '0' WHERE `id` = '$id' and `JC`='1'");
	echo $id;
?>

</body>
</html>