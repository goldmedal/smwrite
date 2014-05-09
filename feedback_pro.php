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
<div class='title'>問題處理</div>
<br><br>
<fieldset class="remind">

<ul>
<li>回報者:<? echo $BackerRow['name']; ?></li>
<li>問題類型:
<?
	switch($BackerRow['classfi'])
	{
		case 1: echo "系統問題";
				break;
		case 2: echo "題目問題";
				break;
		case 3: echo "其它問題";
	}

?>
</li>
<li>問題內容:<br><textarea cols=60 rows=3><? echo $BackerRow['content']; ?></textarea></li>
<form action="manager_fblist.php?pro_num=<? echo $BackerNum;?>&re_name=<?echo $user;?>&poster=<?echo $BackerRow['name'];?>" method="post" accept-charset="Big5">
<li><label>答覆內容</label><br>
<textarea cols=60 rows=6 name="backcontent"><? echo $BackerRow['contentback']; ?></textarea></li>
<li>
	<input type="radio" value="1" name="proState">已處理
	<input type="radio" value="2" name="proState" checked>處理中
</li>
<input type="submit" value="送出(q)" accesskey='q'>
<input name="Submit" type="button" id="Submit" onClick="javascript:history.back(1)" value="回一上頁(r)" accesskey="r"/></li>
</ul>
</fieldset>

</form>
</body>
</html>