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
	if($_GET['sp'] == 0) $sp = 0;
	else $sp = $_GET['sp'];
	$user = $_GET['userlist'];	


?>
<html>
<head>
<title> 紀錄查詢 </title>
 <link type="text/css" rel="stylesheet" href="mainpage.css"> 
 <link type="text/css" rel="stylesheet" href="scrollbar_src/perfect-scrollbar.css"> 
 <link rel="stylesheet" href="stylesheet/record.css"> 
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <script src="Link.js"></script>
 <script src="scrollbar_src/perfect-scrollbar.js"></script>
 <script src="js/record.js"></script>
 <meta charset="big5" />

</head>
<script>

$(document).ready(function(){

	var user = '<? echo $user; ?>';
	var sp = <? echo $sp; ?>;
	$('#child').perfectScrollbar();
	$('#modeSelect').change(function() {

		var val = this.value;
		record(user, val, sp);

	});

});


</script>

<body>
<div class="title">
<? 
	if($sp == 0) echo "漢字查詢紀錄";
	else echo "漢拼查詢記錄";
?>
</div>
<br><br>
<hr>
<center>
<? if($sp == 0) { ?>
<form action="manager_record.php" method="get">
<? }else{?>
<form action="manager_record.php" method="get">
<input type='hidden' value='1' name='sp'>
<? } ?>
選擇欲查詢者(a)：<select name="userlist" size='1' accesskey='a' >
<?
	
	if($sp == 0) {
		$user_sql = mysql_query("SELECT DISTINCT id FROM $user_db ORDER BY id") or die(mysql_error());
	}else {
		$user_sql = mysql_query("SELECT DISTINCT id FROM $user_spell_db ORDER BY id") or die(mysql_error());		
	}
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
<div>
	<table border='1'>
	<tr>
		<td colspan="7">
	<?
		if(empty($user)) { echo "尚未選擇查詢目標"; }
		else { echo $user."的歷史紀錄"; }

	?>
		</td>
	</tr>
	<tr>
		<td class='date'>日期 時間</td>
		<td class='mode'>
<? if($sp == 0) { ?>		
			<select id="modeSelect">
				<option value="all">所有模式</option>
				<option value="Practice">練習模式</option>
				<option value="ClassifyTest">類別測驗</option>
				<option value="Group">題組測驗</option>
				<option value="JCTest">JC測驗</option>
				<option value="Weak">弱點測驗</option>
				<option value="HighFailPractice">常錯字練習</option>
			</select>
<? }else{ ?>
			模式
<? } ?>			
		</td>
		<td class='wasteTime'>花費時間</td>
		<td class='answerNum'>答題數</td>
		<td class='errorRate'>錯誤率</td>
		<td class='select'>選擇的題目</td>
		<td class='error'>答錯的題目</td>
	</tr>
	</table>

	<div id='child'>
	<table border='1'>
	<?
		if($sp == 0) $sql = mysql_query("SELECT * FROM $user_db WHERE id = '$user' AND time2 > '0' ORDER BY num DESC");
		else $sql = mysql_query("SELECT * FROM $user_spell_db WHERE id = '$user' AND time2 > '0' ORDER BY num DESC");

		$total = mysql_num_rows($sql);
		for($i=0;$i<$total;$i++){
			$row = mysql_fetch_assoc($sql);
	?>
	<tr>
		<td class='date'><?echo $row['date']." ".$row['time1'];?></td>
		<td class='mode' id='modeTitle'><?
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
	</div>
</div>
</body>
</html>

