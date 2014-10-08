<?

/**************************************************************

 File Name : manager_record.php   date:20120803 
 Programmer : LKS
 Statement : 
 manager can search everybody record by this file.

 ****************************************************************/ 

	include("connect_db.php");
	include("header.php");
	include("db_name.php");

?>
<html>
<head>
<title> 紀錄查詢 </title>
 <link type="text/css" rel="stylesheet" href="mainpage.css"> 
  <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <script src="Link.js"></script>
 <meta charset="big5" />
</head>
<body>
<div class="title">漢字查詢紀錄</div>
<br><br>
<hr>
<center>
<form action="manager_record.php" method="get">
選擇欲查詢者(a)：<select name="userlist" size='1' accesskey='a' >
<?
	$user = $_GET['userlist'];
	$user_sql = mysql_query("SELECT DISTINCT id FROM $user_db ORDER BY id") or die(mysql_error());
	$user_total = mysql_num_rows($user_sql);
	for($j=0;$j<$user_total;$j++){
		$user_row = mysql_fetch_assoc($user_sql);
		if( $user == $user_row['id']){
?>
	<option value="<?echo $user_row['id'];?>" selected><?echo $user_row['id'];?></option>
<?
		}else{
?>
	<option value="<?echo $user_row['id'];?>"><?echo $user_row['id'];?></option>
<?
		}
	}
?>
	<input type="submit" value="查詢(q)" accesskey='q'>
</form>
<form id="theid" action="user_anli.php" method="post">
	<input type="hidden" name="id" value="<?echo $user;?>">
	<input type="hidden" name="hint" value="1">
	<input type="submit" value="弱點分析(w)" accesskey="w">
	<a href="manager.php" accesskey="r">回選單(r)</a>
</form>
<div width="50%" height="60%">
<table border='1' width='60%'>
<tr>
	<td colspan="7">
<?

	if(empty($user)) { echo "尚未選擇查詢目標"; }
	else { echo $user."的歷史紀錄"; }


?>
	</td>
</tr>
<tr>
	<td>日期 時間</td>
	<td>模式</td>
	<td>花費時間</td>
	<td>答題數</td>
	<td>錯誤率</td>
	<td>選擇的題目</td>
	<td>答錯的題目</td>
</tr>
</table>
<div width="60%" height=160px style="overflow: scroll;">
<table>
<?
	$sql = mysql_query("SELECT * FROM $user_db WHERE id = '$user'");
	$total = mysql_num_rows($sql);
	for($i=0;$i<$total;$i++){
		$row = mysql_fetch_assoc($sql);
?>
<tr>
	<td><?echo $row['date']." ".$row['time1'];?></td>
	<td><?
		switch($row['Mode'])
		{
			case "Practice":
				echo "自選練習";
				break;
			case "ClassifyTest":
				echo "類別測驗: ".$row['group'];
				break;
			case "Group" :			
				$gr_query = mysql_query("SELECT * FROM $group_db WHERE id = '$row[group]'") or die(mysql_error());
				$gr_row = mysql_fetch_assoc($gr_query);
				$gr_total = mysql_num_rows($gr_query);

				if($gr_total>0){ 
					echo "題組:".$gr_row['name'];
				}
				else {
					echo "題組:".$row['group']."<br>此題組遭刪除!";
				}
				break;
			case "JCTest":
				echo "JC基本測驗";
				break;
			case "Weak":
				echo "弱點測驗";
				break;
			case "HighFailPractice":
				echo "常錯字練習";
				break;	
		}
		?></td>
	<td><?	
	if($row['finish'] == 1){
		$time1 = $row['time1'];
		$time2 = $row['time2'];
		$hour = floor((strtotime($time2) - strtotime($time1))/3600);
		$min = floor(((strtotime($time2) - strtotime($time1))%3600)/60);
		$sec = floor(((strtotime($time2) - strtotime($time1))%3600)%60);
	
		echo "$hour : $min : $sec";
	}
	else{
		echo "測驗未完成";
	}
	?></td>
	<td><?echo $row['sum'];?></td>

	<td><?
		if($row['finish'] == 1){
			if($row["sum"] == 0){
					echo "無答題";
				}else{
					$error_rate = $row["false_num"]/$row["sum"]*100;
					echo round($error_rate,2)."%"; 
				}
		}
		else{
			echo "測驗未完成";
		}
		?></td>
		
	<td><form action="user_select.php" method="post">
		<input type="hidden" name="num" value="<?echo $row['num'];?>">
		<input type="submit" value="進來看"></form></td>

	<td><form action="user_error.php" method="post">
		<input type="hidden" name="num" value="<?echo $row['num'];?>">
		<input type="submit" value="進來看"></form></td>
</tr>
<? } ?>
</table>
</div>
</div>
</body>
</html>

