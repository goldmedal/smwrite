<?

/**************************************************************

 File Name : question_edit.php   date:20120803 
 Programmer : LKS
 Statement : 
 give user to editing question

 ****************************************************************/ 

	include("connect_db.php");
	include("db_name.php");
	$id = $_GET['edit'];
	$sql = mysql_query("SELECT * FROM $question_db  WHERE id = '".$id."'");
	$row = mysql_fetch_assoc($sql);
	$cl_sql = mysql_query("SELECT * FROM $classfi_db") or die(mysql_error());
    $cl_total = mysql_num_rows($cl_sql);
?>
<html>
<head>
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <meta charset="big5" />
 <script src="Link.js"></script>
</head>
	<form action="question_update.php" method="post" enctype="multipart/form-data">
	<label>選擇分類:</label><select name="classfi" size="1">
<?	for($i=0;$i<$cl_total;$i++){
		$cl_row = mysql_fetch_assoc($cl_sql);
?>
	<option value="<?echo $cl_row["id"];?>" <?if($row['Class']==$cl_row['id'])echo "selected";?>><?echo $cl_row["name"];?>
<?
	}
?>
	</select><br>
	<label>選擇難度:</label>
	<input type="radio" name="level" value="1" <?if($row['Level']==1)echo "checked";?>>基本
	<input type="radio" name="level" value="2" <?if($row['Level']==2)echo "checked";?>>中階
	<input type="radio" name="level" value="3" <?if($row['Level']==3)echo "checked";?>>高階<br>
	<label>輸入題號:</label><input type="text" name="num" value="<?echo $row['Num'];?>" ><br>
	<input type="hidden" name="ori_num" value="<?echo $row['Num']?>" >
	<input type="hidden" name="id" value="<?echo $row['id'];?>">
	<label>輸入國語:</label><input type="text" name="chinese" value="<?echo $row['Chinese'];?>"><br>
	<label>輸入台語:</label><input type="text" name="answer" value="<?echo $row['Ans'];?>"><br>
	<label>輸入拼音:</label><input type="text" name="spell" value="<?echo $row['Spell'];?>"><br>
	<label>輸入英文:</label><input type='text' name="english" value="<?echo $row["English"];?>"><br>
	<label>輸入提示:</label><input type="text" name="remind" value="<?echo $row['Remind'];?>"><br>
	<label>備註:</label><input type="text" name="note" value="<?echo $row['note'];?>"><br>
	<label>狀態:</label><select name="finish" size="1">
	<option value=0 <?if($row['Finish']==0)echo "selected";?>>開放
	<option value=1 <?if($row['Finish']==1)echo "selected";?>>隱藏
</select><br>
	原檔案：<?echo $row['DataSource'];?><br>
	<input type="hidden" name="ori_file" value="<?echo $row['DataSource']?>"><br>
	<input type="hidden" name="max_file_size" value="1024000000">
	<label>更新檔案</label><input type="file" name="datasource"><br>
	<input type="reset" value="清除">
	<input type="submit" value="完成"><br>
	<input name="Submit" type="button" id="Submit" onClick="javascript:history.back(1)" value="回一上頁">
	</form>
</html>