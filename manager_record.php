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
	$sp = $_GET['sp'];

?>
<html>
<head>
<title> �����d�� </title>
 <link type="text/css" rel="stylesheet" href="mainpage.css"> 
 <link type="text/css" rel="stylesheet" href="scrollbar_src/perfect-scrollbar.css">  
  <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <script src="Link.js"></script>
 <script src="scrollbar_src/perfect-scrollbar.js"></script>
 
 <meta charset="big5" />
<style>

#child {

	position: relative;
	max-height: 64%;
	width: 100%;
	overflow: hidden;

}

td.date {

	width: 114px;

}

td.mode {

	width: 95px;

}
	
td.wasteTime {

	width: 95px;

}	

td.answerNum {

	width: 83px;

}

td.errorRate {

	width: 83px;

}

td.select {

	width: 113px;

}

td.error {

	width: 113px;

}

</style> 
</head>
<script>

$(document).ready(function(){

	$('#child').perfectScrollbar();

});

function record(_user, _mode, _sp){

	$.ajax({
	
		url: "record.php",
		type: "get",
		dataType: "html",
		data: { user: _user, mode: _mode, sp: _sp },
		success: function(data){
		
			$('#child').html(data);
		
		},
		error: function(xhr){
		
			alert(xhr.status);
		
		}
	
	});

}

</script>

<body>
<div class="title">
<? 
	if($sp == 0) echo "�~�r�d�߬���";
	else echo "�~���d�߰O��";
?>
</div>
<br><br>
<hr>
<center>
<form action="manager_record.php" method="get">
��ܱ��d�ߪ�(a)�G<select name="userlist" size='1' accesskey='a' >
<?
	$user = $_GET['userlist'];
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
	<input type="submit" value="�d��(q)" accesskey='q'>
</form>
<form id="theid" action="user_anli.php" method="post">
	<input type="hidden" name="id" value="<?echo $user;?>">
	<input type="hidden" name="hint" value="1">
	<input type="submit" value="�z�I���R(w)" accesskey="w">
	<a href="manager.php" accesskey="r">�^���(r)</a>
</form>
<div>
	<table border='1'>
	<tr>
		<td colspan="7">
	<?
		if(empty($user)) { echo "�|����ܬd�ߥؼ�"; }
		else { echo $user."�����v����"; }

	?>
		</td>
	</tr>
	<tr>
		<td class='date'>��� �ɶ�</td>
		<td class='mode'>�Ҧ�</td>
		<td class='wasteTime'>��O�ɶ�</td>
		<td class='answerNum'>���D��</td>
		<td class='errorRate'>���~�v</td>
		<td class='select'>��ܪ��D��</td>
		<td class='error'>�������D��</td>
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
					echo "�ۿ�m��";
					break;
				case "ClassifyTest":
					echo "���O����: ".$row['group'];
					break;
				case "Group" :			
					$gr_query = mysql_query("SELECT * FROM $group_db WHERE id = '$row[group]'") or die(mysql_error());
					$gr_row = mysql_fetch_assoc($gr_query);
					$gr_total = mysql_num_rows($gr_query);

					if($gr_total>0){ 
						echo "�D��:".$gr_row['name'];
					}
					else {
						echo "�D��:".$row['group']."<br>���D�վD�R��!";
					}
					break;
				case "JCTest":
					echo "JC�򥻴���";
					break;
				case "Weak":
					echo "�z�I����";
					break;
				case "HighFailPractice":
					echo "�`���r�m��";
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
			echo "������";
		}
		?></td>
		<td class='answerNum'><?echo $row['sum'];?></td>

		<td class='errorRate'><?
			if($row['finish'] == 1){
				if($row["sum"] == 0){
						echo "�L���D";
					}else{
						$error_rate = $row["false_num"]/$row["sum"]*100;
						echo round($error_rate,2)."%"; 
					}
			}
			else{
				echo "������";
			}
			?></td>
			
		<td class='select'><form action="user_select.php" method="post">
			<input type="hidden" name="num" value="<?echo $row['num'];?>">
			<input type="submit" value="�i�Ӭ�"></form></td>

		<td class='error'><form action="user_error.php" method="post">
			<input type="hidden" name="num" value="<?echo $row['num'];?>">
			<input type="submit" value="�i�Ӭ�"></form></td>
	</tr>
	<? } ?>
	</table>
	</div>
</div>
</body>
</html>

