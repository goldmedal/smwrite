<?
	include("connect_db.php");
	include("header.php");
	$user = $_SESSION['sid'];
?>

<html>
<head>
  <meta http-equiv='Content-type' charset='Big5'>
  <link type="text/css" rel="stylesheet" href="mainpage.css"> 
   <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <script src="Link.js"></script>
</head>
<body>
<div class='title'>���D�^��</div>
<br><br>
<fieldset class="remind">
<form action="feedback_check.php" method="post" accept-charset="Big5">
<ul>
<li><label>�^����:</label><input type="hidden" name="name" value="<?echo $user;?>"> <? echo $user;?></li>
<li><label>���D����:</label><select size=1 name="classfi">
<option value="1">�t�ΰ��D</option>
<option value="2">�D�ذ��D</option>
<option value="3">�䥦���D</option>
</select></li>
<li><textarea cols=60 rows=6 name="content">�b����J���D(50�r�H��)</textarea></li>
<input type="submit" value="�e�X(q)" accesskey='q'>
<input name="Submit" type="button" id="Submit" onClick="javascript:history.back(1)" value="�^�@�W��(r)" accesskey="r"/></li>
</ul>
</fieldset>
<fieldset class="remind">
	<legend>�p����</legend>
	<ul>
		<li>�p�G�O�D�ئ����D, �O�o�@�w�n���D�إN�X�]�g�W�h��!!</li>
		<li>Ex: SHA001 ��ı�o�o�D���~�r�αo�ǩǪ�!!!</li>
	</ul>
</fieldset>
</form>
</body>
</html>