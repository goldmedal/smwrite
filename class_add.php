<?
/**************************************************************

 File Name : class_add.php   date:20120801 
 Programmer : LKS
 Statement : 
 user can add the class.

 ****************************************************************/
   include("connect_db.php");

?>

<html>
<head>
<title>Screw - SMwrite台語漢字檢測系統 - 新增分類 </title>
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <meta charset="big5" />
 <script src="Link.js"></script>
</head>
<body>
<font size="5" >Screw - SMwrite台語漢字檢測系統 - 新增分類</font><br>
<form action="class_submit.php" method="post" enctype="multipart/form-data">

<label>輸入類別代碼(必填):</label><input type="text" name="title"><br>
<label>輸入類別名稱(必填):</label><input type="text" name="name"><br>

<input type="reset" value="清除">
<input type="submit" value="完成"><br>
<input name="Submit" type="button" id="Submit" onClick="javascript:history.back(1)" value="回一上頁">
</form>


</body>
</html>