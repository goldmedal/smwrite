<?

/**************************************************************

 File Name : answer_result.php   date:20120801 
 Programmer : LKS
 Statement : 
 accept the data from answer_check when user end this test.
 user can see the resutlt of test.

 ****************************************************************/

	include("connect_db.php");
	include("header.php");
	include("db_name.php");
	$user = $_SESSION['sid'];
	$user_sql = mysql_query("SELECT * FROM $user_db WHERE id = '$user' AND end = 0");
	$user_row = mysql_fetch_assoc($user_sql);
	$time1 = $user_row['time1'];
	$time2 = $user_row['time2'];
	$hour = floor((strtotime($time2) - strtotime($time1))/3600);  // process the time of test. end - start
	$min = floor(((strtotime($time2) - strtotime($time1))%3600)/60);
	$sec = floor(((strtotime($time2) - strtotime($time1))%3600)%60);

?>

<html>
<head>
<title>���絲�G</title>
 <link type="text/css" rel="stylesheet" href="mainpage.css"> 
 <meta charset="big5" />
  <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <script src="Link.js"></script>
</head>
<body>

<div class="title">���絲�G</div><br><br>

���ժ̡G<b><?echo $user;?></b><br>
�������G<?echo $user_row['date'];?><br>
�}�l�ɶ��G<?echo $time1; ?><br>
�����ɶ��G<?echo $time2; ?><br>
�Ҧ��G<?
		switch($user_row['Mode']){
		
			case "Practice" :
				echo "�ۿ�m�߼Ҧ�";
				break;
			case "Group" :
				$gr_query = mysql_query("SELECT * FROM $group_db WHERE id = '$user_row[group]'") or die(mysql_error());
				$gr_row = mysql_fetch_assoc($gr_query);
				echo "�D��:".$gr_row['name']."<br>";
				break;
			case "ClassifyTest":
				echo "���O����: ".$user_row['group'];
				break;
		}
		?><br>
�@�p�G<?echo "$hour : $min : $sec";?><br>
<br>
�@�� <?echo $user_row['sum']; ?> �D, �� <?echo $user_row['false_num'];?> �D<br>
���~�v�G<? 
			if($user_row["sum"] == 0){
				echo "�L���D";
			}else{
				$error_rate = $user_row["false_num"]/$user_row["sum"]*100;
				echo round($error_rate,2)."%"; 
			}
		?><br>
�o���������D�ءG

<hr>
<table border="1">
<tr>
	<td>�D�w�N�X</td>
	<td>�D��</td>
	<td>��y</td>
	<td>�x�y</td>
	<td>����</td>
	<td>�^��</td>
</tr>

<?
	$error_qu = explode(",",$user_row["error_qu"]);
	for($i=1;$i<count($error_qu);$i++){
		$que_sql = mysql_query("SELECT * FROM $question_db WHERE id = $error_qu[$i]");
		$row = mysql_fetch_assoc($que_sql);
		$cl_query = "SELECT * FROM $classfi_db WHERE id =".$row['Class'];
		$cl_result = mysql_query($cl_query) or die(mysql_error());
		$cl_row = mysql_fetch_assoc($cl_result);

?>
<tr>

	<td><? echo $cl_row['title'].$row['Level']."-".$row['Num']; ?></td>
	<td>
	<audio controls="controls">
		<source src="<?echo $row['DataSource'];?>">
	</audio>
<!--		
	LKS : object and embed can't close the autoplay and use loop time functions in Chrome.
		  so i choose use html5 tag <audio>

		<object width="180" height="65" data="<?echo $row['DataSource'];?>">
		<param name="URL" value="<?echo $row['DataSource'];?>">
		<param name="autostart" value="1">
		<param name="autoplay" value="1">
	</object> 
-->
	</td>
	<td><?echo $row["Chinese"];?></td>
	<td><?echo $row["Ans"];?></td>
	<td><?echo $row["Spell"];?></td>
	<td><?echo $row["English"];?></td>

</tr>
<?		
	}
?>
</table>
<?

mysql_query("UPDATE $user_db SET end=1 WHERE num = ".$user_num); //1 present this test has finished.

?>

</body>
</html>


<!--  ANSWER��Bug -->