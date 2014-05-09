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
<title>Screw - SMwrite台語漢字檢測系統 - 新增題目 </title>
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <meta charset="big5" />
 <script src="Link.js"></script>
</head>
<body>
<font size="5" >Screw - SMwrite台語漢字檢測系統 - 新增題目</font><br>
<form action="question_submit.php" method="post" enctype="multipart/form-data">
<label>選擇分類(必選):</label><select name="classfi" size="1">
<?	for($i=0;$i<$cl_total;$i++){
		$cl_row = mysql_fetch_assoc($cl_sql);
?>
	<option value="<?echo $cl_row["id"];?>"><?echo $cl_row["name"];?>
<?
	}
?>
</select><br>
<label>選擇難度(必選):</label>
	<input type="radio" name="level" value="1" checked>基本
	<input type="radio" name="level" value="2">中階
	<input type="radio" name="level" value="3">高階<br>
<label>輸入題號(必填):</label><input type="text" name="num"><br>
<label>輸入國語(必填):</label><input type="text" name="chinese"><br>
<label>輸入台語(必填):</label><input type="text" name="answer"><br>
<label>輸入拼音:</label><input type="text" name="spell"><br>
<label>輸入英文:</label><input type="text" name="english"><br>
<label>輸入提示:</label><input type="text" name="remind"><br>
<label>備註:</label><input type="text" name="note"><br>
<label>狀態:</label><select name="finish" size="1">
	<option value=0 selected>開放
	<option value=1>隱藏
</select><br>
<input type="hidden" name="max_file_size" value="1024000000">
<label>選擇檔案</label><input type="file" name="datasource"><br>
<input type="reset" value="清除">
<input type="submit" value="完成"><br>
<input name="Submit" type="button" id="Submit" onClick="javascript:history.back(1)" value="回一上頁">
</form>


</body>
</html>