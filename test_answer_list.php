<script language="JavaScript">

function listall()
{
	var frm = document.getElementById('theList');
	for( var i=0;i<frm.length;i++){
		if(frm[i].selected == false){
			frm[i].selected = true;
		}
	}
}

function levelall()
{
	var frm = document.getElementById('theLevel');
	for( var i=0;i<frm.length;i++){
		if(frm[i].selected == false){
			frm[i].selected = true;
		}
	}
}

function mit()
{
	var frm = document.getElementById('form1');
	frm.submit();

}
</script>

<? 

	include("connect_db.php");
	include("header.php");
	include("db_name.php");
	$user = $_SESSION["sid"];
	$today = date('Y-m-d');

?>


<html>
<head>
 <link type="text/css" rel="stylesheet" href="mainpage.css">
 <meta http-equiv="content-type" content="text/html; charset=big5">
<title>準備開始</title>
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <meta charset="big5" />
 <script src="Link.js"></script>
</head>
<body>

<div class='title'>選擇題目</div>
<br>
<center>受試者：<? echo $user;?>   日期：<?echo $today?><br><br></center>

<center>

<form method='post' name='form' action="test_answer_list.php">
<label>選擇分類(a):</label><select id='theList' name='theList[]' size=5 accesskey="a">
	<option value="1">1. JC基礎</option>
<?
	$dele = mysql_query("DELETE FROM `$user_db` WHERE time1 = 0"); //delete no start record
	$update = mysql_query("UPDATE `$user_db` SET end = 1 WHERE id = '$user'");
	
	$Listsql = mysql_query("SELECT * FROM $classfi_db");
	$ListTotal = mysql_num_rows($Listsql);
	for($i=2;$i<$ListTotal+1;$i++){
		$Listrow = mysql_fetch_assoc($Listsql);
		
?>
	<option value="<?echo $Listrow['id']?>"><?echo $i.".".$Listrow['name'];?></option>
<?
	}
?>

</select>
<label>選擇級別(s):</label><select id='theLevel' name='theLevel[]' size=5 accesskey="s">
	<option value="1">1.基本</option>
	<option value="2">2.中階</option>
	<option value="3">3.高階</option>
</select>
<input type="submit" value="查詢(q)" accesskey="q"> 
</form><br>

<center>
<?

	$Listrow = $_POST['theList'];
	$Levelrow = $_POST['theLevel'];
	$Listresult = $Listrow[0];
	$Levelresult = $Levelrow[0];
//	echo $Listresult[0]." ".$Levelresult[0];

	if($Listresult != 1){
		$query = "SELECT * FROM `$question_db` WHERE Class ='".$Listresult."' AND Level='".$Levelresult."' AND `Finish`='0'";
	}else {
		$query = "SELECT * FROM `$question_db` WHERE `JC`='1' AND `Finish`='0'";
	}
			
	$result = mysql_query($query) or die(mysql_error());
	$question_total = mysql_num_rows($result); // get the total

	$insert = "INSERT INTO `$user_db`(`id`,`date`) VALUES('$user','$today')";  // 新增 ID 紀錄
	$inquery = mysql_query($insert) or die(mysql_error());

	$myquery = "SELECT * FROM `$user_db` WHERE id = '$user' AND `end` = '0'";
	$myresult = mysql_query($myquery) or die(mysql_error());
	$user_row = mysql_fetch_assoc($myresult);

	if($Listresult != 1){
		$title_query = "SELECT * FROM $classfi_db WHERE `id` = '$Listresult'";
	}else{
		$title_query = "SELECT * FROM $question_db WHERE `JC` = '1' AND `Finish`='0'";
	}
	$title_result = mysql_query($title_query) or die(mysql_error());
	$title_row = mysql_fetch_assoc($title_result);

?>

<table>
<?  
	switch($Levelresult)
	{
		case 1:
		       echo "<caption> ".$title_row['name']." - 基本</caption>";
			   break;   
		case 2:
		       echo "<caption> ".$title_row['name']." - 中階</caption>";
			   break;   
		case 3:
		       echo "<caption> ".$title_row['name']." - 高階</caption>";
			   break;
		default:	   
	} ?>
<tr>
	<td align=center>題組編號</td>
	<td align=center>題目範圍</td>
	<td align=center></td>
</tr>
<? 	if($Listresult != 1){ ?>
<form id='form1' action='test_answer_checkbox.php' method='post'>
<? }else{ ?>
<form id='form1' action='JC_answer_checkbox.php' method='post'>
<? } ?>

<?

	for($i=0,$number=1;$i<$question_total;$i+=50,$number++){
?>

<tr>
	<td><? echo $number; ?></td>
	<td><? 
			$i_fif = $i + 49;
			if($i_fif <= $question_total) echo $i." ~ ".$i_fif; 
			else echo $i." ~ ".$question_total;
			?></td>
	<td> <input type="radio" name="group" value="<?echo $i;?>"></td>
</tr>

<?	
	} 
?>
</table>
<input type='hidden' value='<? echo $Listresult;?>' name="classfi">
<input type='hidden' value='<? echo $Levelresult;?>' name="level">
<? 	if($Listresult != 1){ ?>
<input type='hidden' value="ClassifyTest" name="mode">
<? }else{ ?>
<input type='hidden' value="JCTest" name="mode">	
<? } ?>
<input type='submit' value="確認(w)" accesskey="w"></form>
<br>
</center>

</body>

</html>