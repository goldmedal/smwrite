<?

/**************************************************************

 File Name : group_add.php   date:20120801 
 Programmer : LKS
 Statement : 
 user can add the new group.
 submit the data to group_check.php

 ****************************************************************/

?>
<html>
<head>
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <meta charset="big5" />
 <script src="Link.js"></script>
 <meta http-equiv="Content-Type" content"text/html; charset="big5"/>
</head>
<body>
<font size='5'>�s�W�D��</font>

<form action="group_check.php" method="post">

<label>�D�սs��:</label><input type="text" name="num"><br>
<label>�D�զW��:</label><input type="text" name="name"><br>
<label>�D�����O:</label><input type="radio" name="classfi" value=0>�~�r����<input type="radio" name="classfi" value=1>�~������</br>
<label>�Ƶ�:</label><input type="text" name="note"><br>
<input type="reset" value="�M��">
<input type="submit" value="�U�@�B">

</form>

</body>
</html>