<?

	include("connect_db.php");
	include("header.php");
	include("db_name.php");

	$user = $_SESSION['sid'];
	$BackerNum = $_GET['num'];
	
	$BackerResult = mysql_query("SELECT * FROM $feedback_db WHERE `num` = $BackerNum");
	$BackerRow = mysql_fetch_assoc($BackerResult);

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
<div class='title'>���D�B�z</div>
<br><br>
<fieldset class="remind">

<ul>
<li>�^����:<? echo $BackerRow['name']; ?></li>
<li>���D����:
<?
	switch($BackerRow['classfi'])
	{
		case 1: echo "�t�ΰ��D";
				break;
		case 2: echo "�D�ذ��D";
				break;
		case 3: echo "�䥦���D";
	}

?>
</li>
<li>���D���e:<br><textarea cols=60 rows=3><? echo $BackerRow['content']; ?></textarea></li>
<form action="manager_fblist.php?pro_num=<? echo $BackerNum;?>&re_name=<?echo $user;?>&poster=<?echo $BackerRow['name'];?>" method="post" accept-charset="Big5">
<li><label>���Ф��e</label><br>
<textarea cols=60 rows=6 name="backcontent"><? echo $BackerRow['contentback']; ?></textarea></li>
<li>
	<input type="radio" value="1" name="proState">�w�B�z
	<input type="radio" value="2" name="proState" checked>�B�z��
</li>
<input type="submit" value="�e�X(q)" accesskey='q'>
<input name="Submit" type="button" id="Submit" onClick="javascript:history.back(1)" value="�^�@�W��(r)" accesskey="r"/></li>
</ul>
</fieldset>

</form>
</body>
</html>