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
<div class='title'>問題回報</div>
<br><br>
<fieldset class="remind">
<form action="feedback_check.php" method="post" accept-charset="Big5">
<ul>
<li><label>回報者:</label><input type="hidden" name="name" value="<?echo $user;?>"> <? echo $user;?></li>
<li><label>問題類型:</label><select size=1 name="classfi">
<option value="1">系統問題</option>
<option value="2">題目問題</option>
<option value="3">其它問題</option>
</select></li>
<li><textarea cols=60 rows=6 name="content">在此輸入問題(50字以內)</textarea></li>
<input type="submit" value="送出(q)" accesskey='q'>
<input name="Submit" type="button" id="Submit" onClick="javascript:history.back(1)" value="回一上頁(r)" accesskey="r"/></li>
</ul>
</fieldset>
<fieldset class="remind">
	<legend>小提醒</legend>
	<ul>
		<li>如果是題目有問題, 記得一定要把題目代碼也寫上去喔!!</li>
		<li>Ex: SHA001 我覺得這題的漢字用得怪怪的!!!</li>
	</ul>
</fieldset>
</form>
</body>
</html>