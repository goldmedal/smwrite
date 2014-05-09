<?

/**************************************************************

 File Name : group_select.php   date:20120803 
 Programmer : LKS
 Statement : 
 accept the message from question_list and see what questions in this group

 ****************************************************************/ 

	include("connect_db.php");
	include("db_name.php");
	$group_num = $_POST['id'];
	$sql = mysql_query("SELECT * FROM $group_db WHERE id = '$group_num'");
	$group_row = mysql_fetch_assoc($sql);
	$question = explode(",",$group_row['question']);

?>

<html>
<head>
<title>題組題目</title>
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <script src="Link.js"></script>
 <meta http-equiv="Content-Type" content"text/html; charset="big5"/> 
</head>
<body>
<center><font size="5">題組題目</font></center><br><br>
<input name="Submit" type="button" id="Submit" onClick="javascript:history.back(1)" value="回一上頁" /><br>
<center>
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
	for($i=0;$i<count($question);$i++){
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