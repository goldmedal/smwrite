<?

/**************************************************************

 File Name : question_submit.php   date:20120803 
 Programmer : LKS
 Statement : 
 accept datas from questionadd.php and submit to the db.

 ****************************************************************/ 

include("connect_db.php");
include("db_name.php");

$uploaddir = 'localhost/LKStest'; 
$uploadfile = $uploaddir.basename($_FILES['datasource']['tmp_name']);

$num = $_POST["num"];
$classfi = $_POST["classfi"];
$level = $_POST["level"];
$answer = $_POST["answer"];
$chinese = $_POST["chinese"];
$spell = $_POST["spell"];
$english = $_POST["english"];
$remind = $_POST["remind"];
$note = $_POST["note"];
$finish = $_POST["finish"];
$file = "wav_file/".$_FILES["datasource"]["name"];
$now_date = date('Y-m-d');
$answer = stripslashes(trim($answer)); // �B�� �\�\�\ ���D
$chinese = stripslashes(trim($chinese));
$remind = stripslashes(trim($remind));


if(!(empty($answer)) && !(empty($chinese)) && !(empty($num))){ // promise blocks isn't empty
	$repeat = mysql_query("SELECT * FROM $question_db WHERE Class = '$classfi' AND Level = '$level' AND Num = '$num'");
	$repeat_total = mysql_num_rows($repeat);
	if($repeat_total > 0){  // the code can't repeat
		echo "���N�X�w�ϥιL, �Ч��!!<br>";
	} //if($repeat
	else if(strlen($num) != 3){ // code number doesn't over three
		echo "�п�J�T��N�X!!<br>";
	}// else if
	else{
		$sql = "INSERT INTO $question_db(Num,Class,Level,Ans,Chinese,Spell,English,Remind,note,date,Finish) VALUE('$num','$classfi','$level','$answer','$chinese','$spell','$english','$remind','$note','$now_date','$finish')";
		$query = mysql_query($sql);


		if(!(empty($_FILES["datasource"]["name"]))){  // if data form is correct, upload its file.

			if(!(file_exists("wav_file/".$_FILES["datasource"]["name"]))){  // saveing format is the url of this file

				$upload = move_uploaded_file($_FILES["datasource"]["tmp_name"],"wav_file/".$_FILES["datasource"]["name"]);
				mysql_query("UPDATE $question_db SET DataSource = '$file' WHERE Class = '$classfi' AND Level	='$level' AND Num = '$num'");

				if ($_FILES["datasource"]["error"] > 0){

					echo "Error: " . $_FILES["datasource"]["error"]."<br>";

				} // if($_FILES...

			else{

				echo "�ɮפW�Ǧ��\! ���Ӧp�U�G<br/>";
				echo "�ɮצW��: " . $_FILES["datasource"]["name"]."<br/>";
				echo "�ɮ�����: " . $_FILES["datasource"]["type"]."<br/>";
				echo "�ɮפj�p: " . ($_FILES["datasource"]["size"] / 1024)." Kb<br />";

			} // else

		} //if(if(!(file....

		else { 
			echo "���ɮפw�s�b!�нT�{�O�_���~?<br>";
		} //else
	}//if(!(empty($_FILE....
	} // else
} //if(!(empty($answer





if($query == true){

		echo '<br>�D�طs�W���\ !!<br>';

} else{

		echo '<br>�D�طs�W���� �нT�{����ﶵ�O�_���T !!<br>';

}
?>

<html>
<head>
<title>�W�Ǥ�...</title>
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
  <meta http-equiv="Content-Type" content"text/html; charset="big5"/>
 <script src="Link.js"></script>
</head>
<body>
<br>
<a href="question_list.php">�^�M��</a>
</body>
</html>
