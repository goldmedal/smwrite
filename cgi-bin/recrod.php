<?php

	include("connect_db.php");
	include("header.php");
	include("db_name.php");
	$user = $_GET['user'];
	$mode = $_GET['mode'];
	$sp = $_GET['sp'];
	
?>

<table border='1'>
<?
	if($mode != 'all'){
		if($sp == 0) $sql = mysql_query("SELECT * FROM $user_db WHERE id = '$user' AND time2 > '0' AND mode = '$mode' ORDER BY num DESC");
		else $sql = mysql_query("SELECT * FROM $user_spell_db WHERE id = '$user' AND time2 > '0' AND mode = '$mode'  ORDER BY num DESC");
	}else {
		if($sp == 0) $sql = mysql_query("SELECT * FROM $user_db WHERE id = '$user' AND time2 > '0' ORDER BY num DESC");
		else $sql = mysql_query("SELECT * FROM $user_spell_db WHERE id = '$user' AND time2 > '0' ORDER BY num DESC");
	}

	$total = mysql_num_rows($sql);
	for($i=0;$i<$total;$i++){
		$row = mysql_fetch_assoc($sql);
?>
<tr>
	<td class='date'><?echo $row['date']." ".$row['time1'];?></td>
	<td class='mode'><?
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
	<td class='wasteTime'><?	
	if($row['finish'] == 1){
		$time1 = $row['time1'];
		$time2 = $row['time2'];
		$hour = floor((strtotime($time2) - strtotime($time1))/3600);
		$min = floor(((strtotime($time2) - strtotime($time1))%3600)/60);
		$sec = floor(((strtotime($time2) - strtotime($time1))%3600)%60);
	
		echo "$hour : $min : $sec";
	}
	else{
		echo "未完成";
	}
	?></td>
	<td class='answerNum'><?echo $row['sum'];?></td>

	<td class='errorRate'><?
		if($row['finish'] == 1){
			if($row["sum"] == 0){
					echo "無答題";
				}else{
					$error_rate = $row["false_num"]/$row["sum"]*100;
					echo round($error_rate,2)."%"; 
				}
		}
		else{
			echo "未完成";
		}
		?></td>
		
	<td class='select'><form action="user_select.php" method="post">
		<input type="hidden" name="num" value="<?echo $row['num'];?>">
		<input type="submit" value="進來看"></form></td>

	<td class='error'><form action="user_error.php" method="post">
		<input type="hidden" name="num" value="<?echo $row['num'];?>">
		<input type="submit" value="進來看"></form></td>
</tr>
<? } ?>
</table>