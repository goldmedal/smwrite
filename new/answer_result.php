<?

/**************************************************************

 File Name : answer_result.php   date:20120801 
 Programmer : LKS
 Statement : 
 accept the data from answer_check when user end this test.
 user can see the resutlt of test.

 ****************************************************************/

	include("../connect_db.php");
	include("../db_name.php");
	$user = $_GET['uid'];
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
 <link rel="stylesheet" href="answer_result.css">
 <link rel="stylesheet" href="fadeAndBlurTable.css">
 <meta charset="big5" />
  <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <script src="Link.js"></script>
 <script>
 	$(document).ready(function(){

 		$('#end').click(function(){

 			window.location.href="../main.php";

 		});

 	});
 </script>
</head>
<body>

<header>���絲�G</header>

<section id='userInformation'>

	<div id='uid' class='userItem'>���ժ̡G<?echo $user;?></div>
	<div id='testDate' class='userItem'>�������G<?echo $user_row['date'];?></div>
	<div id='startTime' class='userItem'>�}�l�ɶ��G<?echo $time1; ?></div>
	<div id='endTime' class='userItem'>�����ɶ��G<?echo $time2; ?></div>
	<div id='mode' class='userItem'>�Ҧ��G<?
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
			?></div>
	<div id='totalTime' class='userItem'>�@�p�G<?echo "$hour : $min : $sec";?></div>
	<div id='ansNum' class='userItem'>�@ �� <?echo $user_row['sum']; ?> �D, �� <?echo $user_row['false_num'];?> �D</div>
	<div id='failRate' class='userItem'>���~�v�G<? 
				if($user_row["sum"] == 0){
					echo "�L���D";
				}else{
					$error_rate = $user_row["false_num"]/$user_row["sum"]*100;
					echo round($error_rate,2)."%"; 
				}
			?></div>
	<div id='endTest' class='userItem'><button id='end'>��������</button></div>


</section>
<table>
	<caption>���~���D�ءG</caption>
	<thead>
		<tr>
			<th>�D�w�N�X</th>
			<th>�D��</th>
			<th>��y</th>
			<th>�x�y</th>
			<th>����</th>
			<th>�^��</th>
		</tr>
	</thead>
	<tbody>
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
			<source src="../<?echo $row['DataSource'];?>">
		</audio>
		</td>
		<td><?echo $row["Chinese"];?></td>
		<td><?echo $row["Ans"];?></td>
		<td><?echo $row["Spell"];?></td>
		<td><?echo $row["English"];?></td>

	</tr>
<?		
	}
?>
	</tbody>
</table>
<?

mysql_query("UPDATE $user_db SET end=1 WHERE num = ".$user_num); //1 present this test has finished.

?>

</body>
</html>


<!--  ANSWER��Bug -->