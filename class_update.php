<?

/**************************************************************

 File Name : class_update.php   date:20120801 
 Programmer : LKS
 Statement : 
 process the data from class_edit.php

 ****************************************************************/

include("connect_db.php");
include("db_name.php");

$title = $_POST["title"];
$name = $_POST["name"];
$num = $_POST["num"];
$ori_title = $_POST["ori_title"];

if(!(empty($title)) && !(empty($name))){
	$repeat = mysql_query("SELECT * FROM $classfi_db WHERE title = '$title'");
	$repeat_total = mysql_num_rows($repeat);
	if($title != $ori_title && $repeat_total > 0){
		echo "���N�X�w�ϥιL, �Ч��!!<br>";
	} // if($title)
	else{
		$sql = "UPDATE $classfi_db SET title = '$title', name = '$name' WHERE id = '$num'";
		if(mysql_query($sql)==true){
			echo "������s���\!!<br>";
		}
		else{
			echo "������s����:".mysql_error();
		}
	}// else
} // if(!(empty....))
else{
	echo "������s����, �нT�{����ﶵ";
} // else

echo '<input name="Submit" type="button" id="Submit" onClick="javascript:history.back(1)" value="�^�@�W��" />';

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
