<?	

/**************************************************************

 File Name : manger_manlist.php   date:20130430 
 Programmer : LKS
 Statement : 
 the page of managing all question, group and class. 
 user does deleting, editing, adding or searching action.

 ****************************************************************/ 

	include("connect_db.php");
	include("db_name.php");

	 // header('refresh: 3;url="question_list.php"'); // �۰ʨ�s

	 if($_GET['delete'] == 1){
		
		$num = $_GET['num'];
		$DeleteResult = mysql_query("DELETE FROM `$manger_db` WHERE `num` = '$num'");
		
	 }
	 if($_GET['adder'] == 1){
	 
		$value = $_GET['value'];
		$AddReasult = mysql_query("INSERT INTO `$manger_db` (`name`) VALUES ('$value')") or die(mysql_error());

	 }

?>

<script type="text/javascript">
<!--

function Delete(num){
	location.href="manager_manlist.php?delete=1&num="+num; // give a hint to delete
}

function BackToMain(){
	location.href="manager.php";
}

function Add(){

	adder = document.getElementById('AddMan');
	location.href="manager_manlist.php?adder=1&value="+adder.value;

}
//-->
</script>
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <meta charset="big5" />
 <script src="Link.js"></script>

<html>
<head>
<title>�޲z���W��</title>
 <link type="text/css" rel="stylesheet" href="mainpage.css"> 
 <meta http-equiv="Content-Type" content"text/html; charset="big5"/>
</head>
<body>
<div class="title2">�޲z���W��</div><br><br>
<center>
<input name="Submit" type="button" id="Submit" onClick="BackToMain()" value="�^�@�W��(r)" accesskey="r"/><br></center>
<div id="add">
�s�W�޲z��:<input type='text' id='AddMan'><input type='button' onclick='Add()' value='�s�W'>
</div>
<hr>
<div class="title">�����M��</div>
<center><table border="1">
<tr>
	<td>�޲z��</td>
</tr>
<?
	$ManResult = mysql_query("SELECT * FROM $manger_db");
	$ManRow = mysql_fetch_assoc($ManResult);
	
	while($ManRow != false)
	{
?>
<tr>
	<td><? echo $ManRow['name']; ?></td>
	<td><input name='delete' type='button' onclick="if(confirm('�o�O�޲z���W��, �T�w�n�R��?')){Delete(<? echo $ManRow['num'];?>)}" value="�R��(d)"></td>
</tr>
<?
		$ManRow = mysql_fetch_assoc($ManResult);
	}

?>
</table>
<br><hr><br>

</body>

</html>