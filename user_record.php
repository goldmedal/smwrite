<?
/**************************************************************

 File Name : user_record.php   date:20120803 
 Programmer : LKS
 Statement : 
 user can see his record in this page. include failed question or selected question.

 ****************************************************************/ 

	include("connect_db.php");
	include("header.php");
	include("db_name.php");
	$user = $_SESSION['sid'];
	if($_GET['sp'] == 0) $sp = 0;
	else $sp = $_GET['sp'];
	
	if($sp != 1){
		$sql = mysql_query("SELECT * FROM $user_db WHERE id = '$user' AND time2 > '0' ORDER BY num DESC") or die(mysql_error());
	}else{
		$sql = mysql_query("SELECT * FROM $user_spell_db WHERE id = '$user' AND time2 > '0' ORDER BY num DESC") or die(mysql_error());
	}
	$total = mysql_num_rows($sql);
?>
<html>
<head>
<title> �ӤH�����d�� </title>
 <link type="text/css" rel="stylesheet" href="mainpage.css"> 
 <meta charset="big5" />
 <link type="text/css" rel="stylesheet" href="scrollbar_src/perfect-scrollbar.css">
 <link rel="stylesheet" href="stylesheet/record.css">
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <script src="Link.js"></script>
 <script src="scrollbar_src/perfect-scrollbar.js"></script>
 <script src="js/record.js"></script>
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
</head>


<body>
<div class="title">�d�߭ӤH����</div>
<br><br>
<hr>
<center>
�d�ߪ̡G<b><?echo $user;?></b><br>
<form id="theid" action="user_anli.php" method="post">
	<input type="hidden" name="id" value="<?echo $user?>">
	<input type="hidden" name="sp" value="<?echo $sp;?>">
	<input type="submit" value="�z�I���R(w)" accesskey="w">
</form>

<input name="Submit" type="button" id="Submit" onClick="javascript:history.back(1)" value="�^�@�W��(r)" accesskey="r"/><br>
<div>
	<table border='1'>
	<tr>
		<td class='date'>��� �ɶ�</td>
		<td class='mode'>
<? if($sp == 0) { ?>		
			<select id="modeSelect">
				<option value="all">�Ҧ��Ҧ�</option>
				<option value="Practice">�m�߼Ҧ�</option>
				<option value="ClassifyTest">���O����</option>
				<option value="Group">�D�մ���</option>
				<option value="JCTest">JC����</option>
				<option value="Weak">�z�I����</option>
				<option value="HighFailPractice">�`���r�m��</option>
			</select>
<? }else{ ?>
			�Ҧ�
<? } ?>					
		</td>
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
		for($i=0;$i<$total;$i++){
			$row = mysql_fetch_assoc($sql);
	?>
	<tr>
		<td class='date'><?echo $row['date']." ".$row['time1'];?></td>
		<td class='mode'><?
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

