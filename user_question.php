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
<title>��ܪ��D��</title>
 <link type="text/css" rel="stylesheet" href="mainpage.css"> 
  <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <script src="Link.js"></script>
 <meta charset="big5" />
 <script src="Link.js"></script>
</head>
<body>
<div class="title">��ܪ��D��</div><br><br>
<input name="Submit" type="button" id="Submit" onClick="javascript:history.back(1)" value="�^�@�W��" /><br>
<center>
<table border="1">
<tr>
	<td>�D�w�N�X</td>
	<td>�D��</td>
	<td>��y</td>
	<td>�x�y</td>
	<td>����</td>
	<td>�^��</td>
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