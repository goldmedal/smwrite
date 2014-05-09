<?

/**************************************************************

 File Name : user_error.php   date:20120803 
 Programmer : LKS
 Statement : 
 display user failed question in this test.

 ****************************************************************/ 

	include("connect_db.php");
	include("db_name.php");
	$user_num = $_POST['num'];
	$sp = $_POST['sp'];
	if($sp == 1){
		$user_sql = mysql_query("SELECT * FROM $user_spell_db WHERE num = '$user_num'") or die(mysql_error());
	}else{
		$user_sql = mysql_query("SELECT * FROM $user_db WHERE num = '$user_num'") or die(mysql_error());
	}
	$user_row = mysql_fetch_assoc($user_sql);
	$question = explode(",",$user_row['error_qu']);
?>
<html>
<head>
<title>選擇的題目</title>
 <link type="text/css" rel="stylesheet" href="mainpage.css"> 
  <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <meta charset="big5" />
 <script src="Link.js"></script>
</head>
<body>
<div class="title">錯誤的題目</div><br><br>
<center>
<input name="Submit" type="button" id="Submit" onClick="javascript:history.back(1)" value="回一上頁(r)" accesskey="r"/><br>
<table border="1">
<tr>
	<td align=center>題庫代碼</td>
	<td align=center>題目</td>
	<td align=center>國語</td>
	<td align=center>台語</td>
	<td align=center>拼音</td>
	<td align=center>英文</td>
</tr>

<?
	for($i=1;$i<count($question);$i++){ //error_qu array is start from 1
		$que_sql = mysql_query("SELECT * FROM $question_db WHERE id = '$question[$i]'") or die(mysql_error());
		$que_total = mysql_num_rows($que_sql);
		if($que_total > 0){
			$row = mysql_fetch_assoc($que_sql);
			$cl_query = "SELECT * FROM $classfi_db WHERE id =".$row['Class'];
			$cl_result = mysql_query($cl_query) or die(mysql_error());
			$cl_row = mysql_fetch_assoc($cl_result);
?>

	<tr>

	<td><? echo $cl_row['title'].$row['Level']."-".$row['Num']; ?></td>
	<td>
	<audio controls="controls">
		<source src="<?echo $row['DataSource'];?>">
	</audio>

	</td>
	<td><?echo $row["Chinese"];?></td>
	<td><?echo $row["Ans"];?></td>
	<td><?echo $row["Spell"];?></td>
	<td><?echo $row["English"];?></td>

</tr>
<?		
		} //if(!($que_sql)
		else{
?>
	<tr>
		<td colspan=6 align=center>此題已刪除</td>
	</tr>
<?
		}//else
	} // for
?>

</table>
</body>
</html>