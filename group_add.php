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
<font size='5'>新增題組</font>

<form action="group_check.php" method="post">

<label>題組編號:</label><input type="text" name="num"><br>
<label>題組名稱:</label><input type="text" name="name"><br>
<label>題組類別:</label><input type="radio" name="classfi" value=0>漢字測驗<input type="radio" name="classfi" value=1>漢音測驗</br>
<label>備註:</label><input type="text" name="note"><br>
<input type="reset" value="清除">
<input type="submit" value="下一步">

</form>

</body>
</html>