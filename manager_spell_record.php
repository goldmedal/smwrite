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
	$sp = $_GET["sp"];

?>
<html>
<head>
<title> �����d�� </title>
 <link type="text/css" rel="stylesheet" href="mainpage.css"> 
  <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <meta charset="big5" />
 <script src="Link.js"></script>
</head>
<body>
<div class="title">�~���d�߬���</div>
<br><br>
<hr>
<center>
<form action="manager_spell_record.php" method="get">
��ܱ��d�ߪ�(a)�G<select name="userlist" size='1' accesskey='a'>
<?
	$user = $_GET['userlist'];
	$user_sql = mysql_query("SELECT DISTINCT id FROM $user_spell_db ORDER BY id") or die(mysql_error());
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

<input name="Submit" type="button" id="Submit" onClick="javascript:history.back(1)" value="�^�@�W��(r)" accesskey="r"/><br>
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
	<td>��� �ɶ�</td>
	<td>�Ҧ�</td>
	<td>��O�ɶ�</td>
	<td>���D��</td>
	<td>���~�v</td>
	<td>��ܪ��D��</td>
	<td>�������D��</td>
</tr>

<?
	$sql = mysql_query("SELECT * FROM $user_db WHERE id = '$user'");
	$total = mysql_num_rows($sql);
	for($i=0;$i<$total;$i++){
		$row = mysql_fetch_assoc($sql);
?>
<tr>
	<td><?echo $row['date']." ".$row['time1'];?></td>
	<td><?
		if(empty($row['group'])){echo "�m�߼Ҧ�";}
		else{
				$gr_query = mysql_query("SELECT * FROM $group_db WHERE id = '$row[group]'") or die(mysql_error());
				$gr_row = mysql_fetch_assoc($gr_query);
				$gr_total = mysql_num_rows($gr_query);

				if($gr_total>0){    // check whether questions exist.
					echo "�D��:".$gr_row['name'];
				}
				else {
					echo "�D��:".$row['group']."<br>���D�վD�R��!";
				}

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
		echo "���祼����";
	}
	?></td>
	<td><?echo $row['sum'];?></td>
	<td><?
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
	<td><form action="user_select.php" method="post">
		<input type="hidden" name="num" value="<?echo $row['num'];?>">
		<input type="hidden" name="sp" value="<?echo $sp?>">
		<input type="submit" value="�i�Ӭ�"></form></td>

	<td><form action="user_error.php" method="post">
		<input type="hidden" name="num" value="<?echo $row['num'];?>">
		<input type="hidden" name="sp" value="<?echo $sp;?>">
		<input type="submit" value="�i�Ӭ�"></form></td>
</tr>
<? } ?>
</body>
</html>

