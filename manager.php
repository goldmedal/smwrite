<!-- **************************************************************

 File Name : manager.php   date:20120426 
 Programmer : LKS
 Statement : 
 the manage page of this system

 ****************************************************************  -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 

"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
<script language=javascript>

	function h_submit(){

		document.getElementById('judge').submit();
		
	}

</script>
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <meta charset="big5" />
 <script src="Link.js"></script>
 <link type="text/css" rel="stylesheet" href="mainpage.css">
 <meta http-equiv="Content-Type" content"text/html; charset='big5'"/>
</head>
 <body>
  <div class='title'>�޲z�̭���</div>
<?
/*
	$code = $_POST['code'];
	if($code == "SMWRITELKS2012"){
*/
?>
<fieldset class='item'>
<ul>
  <li><a href="question_list.php" accesskey='a'>�D�w�޲z�t��(a)</a></li>
  <li><a href="manager_manlist.php" accesskey='s'>�޲z���W��(s)</a></li>
  <li><a href="manager_fblist.php" accesskey='w'>���D�޲z(w)</a></li>
 </ul>
 <ul>
  <li><a href="manager_record.php" accesskey='c'>�[�ݺ~�r�m�߰O��(c)</a></li>
<form action="manager_spell_record.php" method="get" id="judge">
	<input type="hidden" name="sp" value=1>
  <li><a href="#" onclick="h_submit();" accesskey='q'>�[�ݺ~���m�߰O��(q)</a></li>
</form>
</ul>
</fieldset>
<?
//	}else{
?>

<!--

<fieldset class='item'>
<ul><p class='ps'>�ݪ`�N�j�p�g</p></ul>
<ul>
  <form action='manager.php' method='post'>
	<center><li><label>��J�K�X(a):</label><input type='password' name='code' accesskey='a'>
	<input type='submit' value='�e�X'></li></center>
  </form>
 </ul>
 <ul>
  <li><a href="main.html" accesskey='r'>�^�D�e��(r)</a></li>
</ul>
</fieldset>

-->

<?
// }
?>

 </body>
</html>
