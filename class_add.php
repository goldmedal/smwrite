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
<title>Screw - SMwrite�x�y�~�r�˴��t�� - �s�W���� </title>
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <meta charset="big5" />
 <script src="Link.js"></script>
</head>
<body>
<font size="5" >Screw - SMwrite�x�y�~�r�˴��t�� - �s�W����</font><br>
<form action="class_submit.php" method="post" enctype="multipart/form-data">

<label>��J���O�N�X(����):</label><input type="text" name="title"><br>
<label>��J���O�W��(����):</label><input type="text" name="name"><br>

<input type="reset" value="�M��">
<input type="submit" value="����"><br>
<input name="Submit" type="button" id="Submit" onClick="javascript:history.back(1)" value="�^�@�W��">
</form>


</body>
</html>