<?

/**************************************************************

 File Name : class_submit.php   date:20120801 
 Programmer : LKS
 Statement : 
 process the data from class_add.php

 ****************************************************************/

include("connect_db.php");
include("db_name.php");

$title = $_POST["title"];
$name = $_POST["name"];

if(!(empty($title)) && !(empty($name))){
	$repeat = mysql_query("SELECT * FROM $classfi_db WHERE title = '$title'");
	$repeat_total = mysql_num_rows($repeat);
	if($repeat_total > 0){
		echo "���N�X�w�ϥιL, �Ч��!!<br>";
	} //if($repeat
	else{
		$sql = "INSERT INTO $classfi_db(title,name) VALUE('$title','$name')";
		if(mysql_query($sql)==true){
			echo "�����s�W���\!!<br>";
		}else{
			echo "�����s�W����:".mysql_error();
		}
	} // else if
} // if(!(empty....
else{
	echo "�����s�W����, �нT�{����ﶵ";
} // else


?>

<html>
<head>
<title>�W�Ǥ�...</title>
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <meta charset="big5" />
 <script src="Link.js"></script>
</head>
<body><br>
<a href="question_list.php">�^�M��</a>
</body>
</html>
