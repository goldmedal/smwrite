<?

/**************************************************************

 File Name : class_edit.php   date:20120801 
 Programmer : LKS
 Statement : 
 user can edit the class record.

 ****************************************************************/

   include("connect_db.php");
   include("db_name.php");
   $num = $_POST['edit'];
   $sql = mysql_query("SELECT * FROM $classfi_db WHERE id ='".$num."'") or die(mysql_error());
   $row = mysql_fetch_assoc($sql);
?>

<html>
<head>
<title>Screw - SMwrite�x�y�~�r�˴��t�� - �ק���� </title>
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <meta charset="big5" />
 <script src="Link.js"></script>
</head>
<body>
<font size="5" >Screw - SMwrite�x�y�~�r�˴��t�� - �ק����</font><br>
<form action="class_update.php" method="post" enctype="multipart/form-data">

<label>��J���O�N�X(����):</label><input type="text" name="title" value="<?echo $row['title'];?>"><br>
<label>��J���O�W��(����):</label><input type="text" name="name" value="<?echo $row['name'];?>"><br>
<input type='hidden' name='ori_title' value="<?echo $row['title'];?>">
<input type='hidden' name='num' value=<?echo $num;?>>

<input type="reset" value="�M��">
<input type="submit" value="����"><br>
<input name="Submit" type="button" id="Submit" onClick="javascript:history.back(1)" value="�^�@�W��">
</form>


</body>
</html>