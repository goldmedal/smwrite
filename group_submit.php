<?

/**************************************************************

 File Name : group_submit.php   date:20120803 
 Programmer : LKS
 Statement : 
 accept the message from group_check.php and upload datas to db.

 ****************************************************************/ 

	include("connect_db.php");
	include("db_name.php");

	$num = $_POST['num'];
	$name = $_POST['name'];
	$note = $_POST['note'];
	$classfi = $_POST['classfi'];
	$question = $_POST['question'];
	$allquestion = implode(',',$question);
	$total = count($question);

	$sql = "INSERT INTO $group_db(num,name,note,question,total,classfi) VALUES('$num','$name','$note','$allquestion','$total','$classfi')";
	$query = mysql_query($sql);

	if($query){
		echo "�s�W���\! ";
		if(!(empty($question))){
			echo "�@��� ".count($question)." �D<br>";
		}else{
			echo "�A����ܥ����D�� !!<br>";
		}
	}else{
		echo "�s�W����: ".mysql_error();
	}
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
<a href="question_list.php">�^�M��</a>
</body>
</html>