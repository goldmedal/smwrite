<!-- **************************************************************

 File Name : main.php  date:20130430 
 Programmer : LKS
 Statement : 
 the main page of this system

 ****************************************************************  -->
<?
	session_start();
	$user = $_SESSION['sid'];
	include("connect_db.php");
	include("db_name.php");

?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 

"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title> SMWrite �x�y�Ѽg����t�� </title>
 <link type="text/css" rel="stylesheet" href="mainpage.css">
 <meta http-equiv="content-type" content="text/html; charset=big5">
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <script>

		 $(document).bind('keydown','alt+r',function(evt){
			var wparent = window.parent;
			wparent.HotKeyGo();
			
		});
 </script>
</head>
<body>
<div class='title'>
SMWrite �x�y�Ѽg����t�� Beta 4.0 
</div>
<fieldset class="item">
<ul>
<li><a href="sm_list.html" accesskey="a">�~�r����(a)</li>
<li><a href="sp_list.html" accesskey="s">�~������(s)</a></li>
<?	


	$MangerResult = mysql_query("SELECT * FROM $manger_db WHERE `name` = '$user'") or die(mysql_error());
	$MangerTotal = mysql_num_rows($MangerResult);
	if($MangerTotal > 0){


?>
<li><a href="manager.php" accesskey="w">�޲z�̭���(w)</a></li>
<? } ?>
<li><a href="feedback_user.php" accesskey="q">�^�����D(q)</a></li>
</ul>
</fieldset>
<fieldset class="remind">
<legend>������</legend>
<div class="thead">���n�ƶ�</div>
<table border=1>
	<tr>
		<td>���</td>
		<td>����</td>
		<td>�o���H</td>
		<td>���e</td>
	</tr>
	<tr>
		<td>20130513</td>
		<td>�t��</td>
		<td>LKS</td>
		<td>���D�^����, �i�H�쭺���Ӭݰ��D���S�����, �p�G�S��, �i�H���Ƭ����A�ݤ@��. <br>�T�w�S��, �A���s�^���@��. �P�˪����D�Ф��n�@�o�e</td>
	</tr>
	<tr>
		<td>20130506</td>
		<td>�t��</td>
		<td>LKS</td>
		<td>�p��������, ���ﵪ�פ��F�Ѫ��a��, ���i�H���[�ݰO�����a��ݦۤv�����D�O��, �ε۵���</td>
	</tr>
	<tr>
		<td>20130506</td>
		<td>�t��</td>
		<td>LKS</td>
		<td>�w�קﴣ�ܾ���, �����⦸�Y������, �T���H�W�Y������</td>
	</tr>
	<tr>
		<td>20130430</td>
		<td>�t��</td>
		<td>LKS</td>
		<td>�s�����D�^���t�Τw�g�����F, �H��^�����D���|�۰ʱH�H��޲z�����H�c�P�^���̪��H�c��!</td>
	</tr>
	<tr>
		<td>20130417</td>
		<td>�t��</td>
		<td>LKS</td>
		<td>�̪�SMWrite�t�Φb����May���Q�k�ק襤, �Y�Ȯɦ������ƪ��ǲ���, �Ш���</td>
	</tr>



</table>
<div class="thead">�^�����D</div>
<table border=1 style="table-layout:fixed;text-align=left" width=900px >
<tr>
	<td width=100px>��� - �s��</td>
	<td width=100px>�^����</td>
	<td width=50px>���D����</td>
	<td width=300px>�^�����e</td>
	<td width=300px>���Ф��e</td>
	<td width=50px>�B�z���p</td>
	


</tr>
<?
//	$update = mysql_query("UPDATE `smwrite_feedback` SET `done` = '1' WHERE `num` = '".$_POST['num']."'") or die(mysql_error());

	$query = mysql_query("SELECT * FROM smwrite_feedback ORDER BY `num` DESC");
	$total = mysql_num_rows($query);

	for($i=0;$i<10;$i++){
		$row = mysql_fetch_assoc($query);
?>

<tr>
	<td border=0>
	<?
		if($row['question_date'] != 0){
		
			$date = new DateTime($row['question_date']);
			echo date_format($date, "Ymd")." - ";
			
		}
		
		echo $row['num'];
	
	?>
	
	</td>
	<td ><?echo $row['name'];?></td>
	<td><? 
			switch($row['classfi']){
				case 1: echo "�t��<br />���D";break;
				case 2: echo "�D��<br />���D";break;
				case 3: echo "�䥦<br />���D";break;
			}
		?></td>

	<td ><?echo $row['content'];?></td>
	<td><?
	
			if($row['new_respon_date'] != 0){
			
				$date = new DateTime($row['new_respon_date']);
				echo date_format($date, "Ymd")." - ";
			
			}
			echo $row['re_name'];
			
	?>:<br/>
	<?echo $row['contentback']; ?></td>
	<td>
	<? 
		if($row['done'] == 1){echo "�w�ѨM";}
		else if($row['done'] == 2){echo "�B�z��";}
		else{ echo "�ݳB�z"; } 
	?> 
	</td>
</tr>
<?
	}
?>
</table>
<br>

</fieldset>



</body>
</html>
