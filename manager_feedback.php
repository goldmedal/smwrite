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
<div class="title">問題總覽</div><br>
<br><br>
<center>
<input name="Submit" type="button" id="Submit" onClick="javascript:history.back(1)" value="回一上頁(r)" accesskey="r"/><br>

<table border='1'>
<tr>
	<td>問題流水號</td>
	<td>回報者</td>
	<td>問題類型</td>
	<td>問題內容</td>
	<td>狀態</td>
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
				case 1: echo "系統問題";break;
				case 2: echo "題目問題";break;
				case 3: echo "其它問題";break;
			}
		?></td>
	<td><?echo $row['content'];?></td>
	<td><? if($row['done'] == 1){echo "已處理";}
			else{ echo "未處理"; } ?> </td>
	<td><form action="manager_feedback.php" method="post">
			<input type='hidden' value="<?echo $row['num'];?>" name='num'>
			<input type="submit" value="處理完成">
		</form></td>
</tr>
<?
	}
?>
	
</table>
</body>
</html>