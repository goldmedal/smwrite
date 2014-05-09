<? 	

/**************************************************************

 File Name : group_check.php   date:20120801 
 Programmer : LKS
 Statement : 
 user can select the question he wants to insert to group.
 submit it's data and group_add.php's data to group_submit.

 ****************************************************************/

	include("connect_db.php");
	include("db_name.php");
	$name = $_POST['name'];
	$num = $_POST['num'];
	$classfi = $_POST['classfi'];
	$note = $_POST['note'];
	if( empty($name) && empty($num)){
		echo "請確實填寫名稱與編號!";
	}else{
?>
<html>
<head>
 <link type="text/css" rel="stylesheet" href="mainpage.css"> 
  <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	

 <script src="Link.js"></script>
  <meta http-equiv="Content-Type" content"text/html; charset="big5"/>
</head>
<body>
<script type="text/javascript">
<!--
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
//-->
</script>
<div class="title">選擇題目</div>
<fieldset class='remind'>
<ul>
<li>題組編號:<?echo $num;?></li>
<li>題組名稱:<? echo $name; ?></li>
<li>備註: <?echo $note;?></li>
<li><?echo $classfi; ?></li>
</ul>
</fieldset>
<center>
<form method='post' name='form' action="group_check.php">

<input type='hidden' name='num' value='<?echo $num;?>'>
<input type='hidden' name='name' value='<?echo $name;?>'>
<input type='hidden' name='note' value='<?echo $note;?>'>
<input type='hidden' name='classfi' value='<?echo $classfi;?>'>


<label>選擇分類:</label><select id='theList' name='theList[]' size=5 multiple>
<?

	$Listsql = mysql_query("SELECT * FROM $classfi_db");
	$ListTotal = mysql_num_rows($Listsql);
	for($i=1;$i<$ListTotal+1;$i++){
		$Listrow = mysql_fetch_assoc($Listsql);
		
?>
	<option value="<?echo $Listrow['id']?>"><?echo $i.".".$Listrow['name']?></option>
<?
	}
?>
</select>

<label>選擇級別:</label><select id='theLevel' name='theLevel[]' size=5 multiple>
	<option value="1">1.基本</option>
	<option value="2">2.中階</option>
	<option value="3">3.高階</option>
</select>	
<input type="submit" value="查詢"></form>
<input type='button' onclick='listall()' value='分類全選(x)' accesskey='x'>
<input type='button' onclick='levelall()' value='級別全選(c)' accesskey='c'>



<center><table border="1">
<tr>
<td align=center>分類級別</td>
<td align=center>題目代碼</td>
<td align=center>題目國語</td>
<td align=center>題目英文</td>
<td align=center>題目台語</td>
<td align=center>錯誤率</td>
<form id=form1 action='group_submit.php' method='post'>


<?
	$Listresult = $_POST['theList'];  // accept the class user selected
	$Levelresult = $_POST['theLevel']; // accept the level user selected
	
	for($j=0;$j<count($Listresult);$j++){   // different clsss in different loop
		for($k=0;$k<count($Levelresult);$k++){ // the level loop
	$query = "SELECT * FROM $question_db WHERE Class ='".$Listresult[$j]."' And Level='".$Levelresult[$k]."'";
	$result = mysql_query($query) or die(mysql_error());
	$question_total = mysql_num_rows($result); // get the total

	$dele = mysql_query("DELETE FROM $user_db WHERE time1 = 0"); //delete no start record
	$update = mysql_query("UPDATE $user_db SET end = 1 WHERE id = '$user'"); // initial the end for any unfinished test record.

	$insert = "INSERT INTO $user_db(id,date) VALUES('$user','$today')"; // new record
	$inquery = mysql_query($insert) or id(mysql_error());


	$myquery = "SELECT * FROM $user_db WHERE id = '$user' AND end = '0'";
	$myresult = mysql_query($myquery) or die(mysql_error());
	$user_row = mysql_fetch_assoc($myresult);

	for($i=0;$i<$question_total;$i++){
		$row = mysql_fetch_assoc($result);

		if($row["DataSource"] != null && $row["Finish"] == 0){  // control if question appear

		$cl_query = "SELECT * FROM $classfi_db WHERE id =".$row['Class'];
		$cl_result = mysql_query($cl_query) or die(mysql_error());
		$cl_row = mysql_fetch_assoc($cl_result);

?>

	<tr>
	<td align=center><? switch($row["Level"]){
			case 1:
					echo $cl_row['name']."類-基本";
					break;
			case 2:
					echo $cl_row['name']."類-中階";
					break;
			case 3:
					echo $cl_row['name']."類-高階";
					break;
			}
		?></td>
	<td><? switch($row['Level']){
			case 1: echo $cl_row['title']."A-".$row['Num'];break;
			case 2: echo $cl_row['title']."B-".$row['Num'];break;
			case 3: echo $cl_row['title']."C-".$row['Num'];break; 
			}?></td>
	<td><? echo $row["Chinese"]; ?></td>
	<td><? echo $row["English"]; ?></td>
	<td><? echo $row["Ans"]; ?></td>
	<td><? 
			if($row["Use_time"] == 0){
				echo "尚無人答題";
			}else{
				$error_rate = $row["False_time"]/$row["Use_time"]*100;
				echo round($error_rate,2)."%"; 
			}
		?></td>
	<td align=center valign=middle>
		<input type='checkbox' name='question[]' value="<?echo $row['id']?>">
	</td>
	</tr>
	
<? 
	} // if($row["DataSource"] != null || $row["Finish"] == 0){
	} 
	} // for($k=0;$k<count($Levelresult);$k++){
	}  // for($j=0;$j<count(Listresult)...
?>
</table>
<input type='hidden' name='num' value='<?echo $num;?>'>
<input type='hidden' name='name' value='<?echo $name;?>'>
<input type='hidden' name='note' value='<?echo $note;?>'>
<input type='hidden' name='classfi' value='<?echo $classfi;?>'>
<input type='submit' value="確認"></form>
</center>

</body>
</html>
<?}?>