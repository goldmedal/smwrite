<?
	include("connect_db.php");
?>

<html>
<head>
 <link type="text/css" rel="stylesheet" href="mainpage.css">
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <meta charset="big5" />
 <script src="Link.js"></script> 
</head>
<body>
<div class="title">���D�`��</div><br>
<br><br>
<center>
<input name="Submit" type="button" id="Submit" onClick="javascript:history.back(1)" value="�^�@�W��(r)" accesskey="r"/><br>

<table border='1'>
<tr>
	<td>���D�y����</td>
	<td>�^����</td>
	<td>���D����</td>
	<td>���D���e</td>
	<td>���A</td>
</tr>
<?
	$update = mysql_query("UPDATE `smwrite_feedback` SET `done` = '1' WHERE `num` = '".$_POST['num']."'") or die(mysql_error());

	$query = mysql_query("SELECT * FROM smwrite_feedback");
	$total = mysql_num_rows($query);

	for($i=0;$i<$total;$i++){
		$row = mysql_fetch_assoc($query);
?>
<tr>
	<td><?echo $row['num'];?></td>
	<td><?echo $row['name'];?></td>
	<td><? 
			switch($row['classfi']){
				case 1: echo "�t�ΰ��D";break;
				case 2: echo "�D�ذ��D";break;
				case 3: echo "�䥦���D";break;
			}
		?></td>
	<td><?echo $row['content'];?></td>
	<td><? if($row['done'] == 1){echo "�w�B�z";}
			else{ echo "���B�z"; } ?> </td>
	<td><form action="manager_feedback.php" method="post">
			<input type='hidden' value="<?echo $row['num'];?>" name='num'>
			<input type="submit" value="�B�z����">
		</form></td>
</tr>
<?
	}
?>
	
</table>
</body>
</html>