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
	$sp = $_GET['sp'];
	
	if($sp != 1){
		$sql = mysql_query("SELECT * FROM $user_db WHERE id = '$user'") or die(mysql_error());
	}else{
		$sql = mysql_query("SELECT * FROM $user_spell_db WHERE id = '$user'") or die(mysql_error());
	}
	$total = mysql_num_rows($sql);
?>
<html>
<head>
<title> �ӤH�����d�� </title>
 <link type="text/css" rel="stylesheet" href="mainpage.css"> 
 <meta charset="big5" />
  <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <script src="Link.js"></script>
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
<table border='1'>
<tr>
	<td align=center>��� �ɶ�</td>
	<td align=center>�Ҧ�</td>
	<td align=center>��O�ɶ�</td>
	<td align=center>���D��</td>
	<td align=center>���~�v</td>
	<td align=center>��ܪ��D��</td>
	<td align=center>�������D��</td>
</tr>

<?

	for($i=0;$i<$total;$i++){
		$row = mysql_fetch_assoc($sql);
?>
<tr>
	<td align=center><?echo $row['date']." ".$row['time1'];?></td>
	<td align=center><?
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
	<td align=center><?	
	if($row['finish'] == 1){
		$time1 = $row['time1'];
		$time2 = $row['time2'];
		$hour = floor((strtotime($time2) - strtotime($time1))/3600);
		$min = floor(((strtotime($time2) - strtotime($time1))%3600)/60);
		$sec = floor(((strtotime($time2) - strtotime($time1))%3600)%60);
	
		echo "$hour : $min : $sec";
	}
	else{
		echo "���祼����";
	}
	?></td>
	<td align=center><?echo $row['sum'];?></td>
	<td align=center><?
		if($row['finish'] == 1){
			if($row["sum"] == 0){
					echo "�L���D";
				}else{
					$error_rate = $row["false_num"]/$row["sum"]*100;
					echo round($error_rate,2)."%"; 
				}
		}
		else{
			echo "���祼����";
		}
		?></td>
	<td align=center><form action="user_select.php" method="post">
		<input type="hidden" name="num" value="<?echo $row['num'];?>">
		<input type="hidden" name="sp" value="<?echo $sp;?>">
		<input type="submit" value="�i�Ӭ�"></form></td>

	<td align=center><form action="user_error.php" method="post">
		<input type="hidden" name="num" value="<?echo $row['num'];?>">
		<input type="hidden" name="sp" value="<?echo $sp;?>">
		<input type="submit" value="�i�Ӭ�"></form></td>
</tr>
<? } ?>
</body>
</html>

