<?

/**************************************************************

 File Name : question_update.php   date:20120803 
 Programmer : LKS
 Statement : 
 accept messages from question_edit.php and update the db data.

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
$ori_file = $_POST["ori_file"];
$ori_num = $_POST["ori_num"];
$id = $_POST["id"];
$answer = stripslashes(trim($answer)); // 處裡 許蓋功 問題
$chinese = stripslashes(trim($chinese));
$remind = stripslashes(trim($remind));


if(!(empty($answer)) && !(empty($chinese)) && !(empty($num))){
	$repeat = mysql_query("SELECT * FROM $question_db WHERE Class = '$classfi' AND Level = '$level' AND Num = '$num'");
	$repeat_total = mysql_num_rows($repeat);
	if($num != $ori_num && $repeat_total > 0){  // check whether change num and num can't over three
		echo "此代碼已使用過, 請更改!!<br>";
	} //if($repeat
	else if(strlen($num) != 3){
		echo "請輸入三位代碼!!<br>";
	}// else if
	else{
		$sql = "UPDATE $question_db SET Num = '$num', Class = '$classfi', Level = '$level', Ans = '$answer',Chinese ='$chinese', Spell = '$spell', English = '$english', Remind = '$remind', note = '$note', date = '$now_date', Finish = '$finish' WHERE id = $id";
		mysql_query($sql);

	if(!(empty($_FILES["datasource"]["name"]))){

		if($ori_file != null && $ori_file != $file){
		unlink($ori_file);
		}

		if(!(file_exists("wav_file/".$_FILES["datasource"]["name"])) || $ori_file == $file || $ori_file == null){
	
		$upload = move_uploaded_file($_FILES["datasource"]["tmp_name"],"wav_file/".$_FILES["datasource"]["name"]);
		mysql_query("UPDATE $question_db SET DataSource = '$file' WHERE id = $id");

		if ($_FILES["datasource"]["error"] > 0){

			echo "Error: " . $_FILES["datasource"]["error"]."<br>";

		} // if($_FILES...
	
		else{

			echo "檔案上傳成功! 明細如下：<br/>";
			echo "檔案名稱: " . $_FILES["datasource"]["name"]."<br/>";
			echo "檔案類型: " . $_FILES["datasource"]["type"]."<br/>";
			echo "檔案大小: " . ($_FILES["datasource"]["size"] / 1024)." Kb<br />";

		} // else
		}//if(!(fiel_exist

		}//if(!(empty($_FILE....

	} // else
} //if(!(empty($answer






if($sql == true){

		echo '<br>題目更新成功 !!<br>';

} else{

		echo '<br>題目更新失敗 請確認必填選項是否正確 !!<br>';

}

?>

<html>
<head>
<title>上傳中...</title>
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <script src="Link.js"></script>
  <meta http-equiv="Content-Type" content"text/html; charset="big5"/>

</head>
<body><br>
<a href="question_list.php">回清單</a>
</body>
</html>
