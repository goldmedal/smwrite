<?
	include("connect_db.php");
	include("db_name.php");
	$user_num = $_POST['num'];
	$user_sql = mysql_query("SELECT * FROM $user_db WHERE num = $num");
	$user_row = mysql_fetch_assoc($user_sql);
	$allquestion = explode(",",$row['question']);
?>
<html>
<head>
<title>選擇的題目</title>
 <link type="text/css" rel="stylesheet" href="mainpage.css"> 
  <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <script src="Link.js"></script>
 <meta charset="big5" />
 <script src="Link.js"></script>
</head>
<body>
<div class="title">選擇的題目</div><br><br>
<input name="Submit" type="button" id="Submit" onClick="javascript:history.back(1)" value="回一上頁" /><br>
<center>
<table border="1">
<tr>
	<td>題庫代碼</td>
	<td>題目</td>
	<td>國語</td>
	<td>台語</td>
	<td>拼音</td>
	<td>英文</td>
</tr>

<?
	for($i=0;$i<count($allquestion);$i++){
		$que_sql = mysql_query("SELECT * FROM $question_db WHERE id = $question[$i]");
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
	}
?>
</table>