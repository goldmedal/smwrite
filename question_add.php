<?

/**************************************************************

 File Name : question_add.php   date:20120803 
 Programmer : LKS
 Statement : 
 this file can give user a page to input his data to add a new question,
 submit this data to question_submit.php.

 ****************************************************************/ 

   include("connect_db.php");
   include("db_name.php");
   $cl_sql = mysql_query("SELECT * FROM $classfi_db") or die(mysql_error());
   $cl_total = mysql_num_rows($cl_sql);
?>

<html>
<head>
<title>Screw - SMwrite�x�y�~�r�˴��t�� - �s�W�D�� </title>
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <meta charset="big5" />
 <script src="Link.js"></script>
</head>
<body>
<font size="5" >Screw - SMwrite�x�y�~�r�˴��t�� - �s�W�D��</font><br>
<form action="question_submit.php" method="post" enctype="multipart/form-data">
<label>��ܤ���(����):</label><select name="classfi" size="1">
<?	for($i=0;$i<$cl_total;$i++){
		$cl_row = mysql_fetch_assoc($cl_sql);
?>
	<option value="<?echo $cl_row["id"];?>"><?echo $cl_row["name"];?>
<?
	}
?>
</select><br>
<label>�������(����):</label>
	<input type="radio" name="level" value="1" checked>��
	<input type="radio" name="level" value="2">����
	<input type="radio" name="level" value="3">����<br>
<label>��J�D��(����):</label><input type="text" name="num"><br>
<label>��J��y(����):</label><input type="text" name="chinese"><br>
<label>��J�x�y(����):</label><input type="text" name="answer"><br>
<label>��J����:</label><input type="text" name="spell"><br>
<label>��J�^��:</label><input type="text" name="english"><br>
<label>��J����:</label><input type="text" name="remind"><br>
<label>�Ƶ�:</label><input type="text" name="note"><br>
<label>���A:</label><select name="finish" size="1">
	<option value=0 selected>�}��
	<option value=1>����
</select><br>
<input type="hidden" name="max_file_size" value="1024000000">
<label>����ɮ�</label><input type="file" name="datasource"><br>
<input type="reset" value="�M��">
<input type="submit" value="����"><br>
<input name="Submit" type="button" id="Submit" onClick="javascript:history.back(1)" value="�^�@�W��">
</form>


</body>
</html>