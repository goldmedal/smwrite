<? 

/**************************************************************

 File Name : answer_group_list.php   date:20120801 
 Programmer : LKS
 Statement : 
 this file for user select the group he want to play.

 ****************************************************************/

include("connect_db.php");
include("header.php");
include("db_name.php");
	$user = $_SESSION["sid"];
	$today = date('Y-m-d');

?>

<html>
<head>
<title>�ǳƶ}�l</title>
 <link type="text/css" rel="stylesheet" href="mainpage.css">
  <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <meta charset="big5" />
 <script src="Link.js"></script>
</head>
<body>

<div class="title">����D��</div>
<br>
<center>���ժ̡G<? echo $user;?>   ����G<?echo $today?><br></center>
<br>
<center><table>
<tr>
<td>�D�սs��</td>
<td>�D�զW��</td>
<td>�Ƶ�</td>
</tr>

<form id=form1 action='spell_answer_checkbox.php' method='post'>
<?
	$dele = mysql_query("DELETE FROM $user_spell_db WHERE time1 = 0"); //delete no start record

	$update = mysql_query("UPDATE $user_spell_db SET end = 1 WHERE id = '$user'");
	$insert = "INSERT INTO $user_spell_db(id,date) VALUES('$user','$today')";  // add new record
	$inquery = mysql_query($insert); //or die(mysql_error());

	$query = mysql_query("SELECT * FROM $group_db WHERE classfi = 1") or die(mysql_error());
	$total = mysql_num_rows($query);
	for($i=0;$i<$total;$i++){
		$row = mysql_fetch_assoc($query);
?>
<tr>
	<td><?echo $row['num'];?></td>
	<td><?echo $row['name'];?></td>
	<td><?echo $row['note'];?></td>
	<td><input type="radio" name="gr_num" value="<?echo $row['id'];?>"></td>
</tr>
<?
	}
?>
</table>
<input type='hidden' value="SpellGroup" name='mode'>
<input type='submit' value="�T�{(w)" accesskey="w"></form>
<input name="Submit" type="button" id="Submit" onClick="javascript:history.back(1)" value="�^�@�W��(r)" accesskey="r"/><br>
</center>

</body>

</html>