<script language="JavaScript">
function chkall(input1,input2)
{
    var objForm = document.forms[input1];
    var objLen = objForm.length;
    for (var iCount = 0; iCount < objLen; iCount++)
    {
        if (input2.checked == true)
        {
            if (objForm.elements[iCount].type == "checkbox")
            {
                objForm.elements[iCount].checked = true;
            }
        }
        else
        {
            if (objForm.elements[iCount].type == "checkbox")
            {
                objForm.elements[iCount].checked = false;
            }
        }
    }
}
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

function Submit()
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
  <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <script src="Link.js"></script>
<title>準備開始</title>
</head>
<body>

<div class='title'>高錯誤率題目練習</div>
<br>
<center>受試者：<? echo $user;?>   日期：<?echo $today?><br><br></center>

<center>

<form method='post' name='form' action="high_fail_rate_answer_list.php">
<label>選擇分類(a):</label><select id='theList' name='theList[]' size=5 multiple accesskey="a">
<?
	$Listsql = mysql_query("SELECT * FROM $classfi_db");
	$ListTotal = mysql_num_rows($Listsql);
	for($i=1;$i<$ListTotal+1;$i++){
		$Listrow = mysql_fetch_assoc($Listsql);
		
?>
	<option value="<?echo $Listrow['id']?>"><?echo $i.".".$Listrow['name'];?></option>
<?
	}
?>

</select>
<label>選擇級別(s):</label><select id='theLevel' name='theLevel[]' size=5 multiple accesskey="s">
	<option value="1">1.基本</option>
	<option value="2">2.中階</option>
	<option value="3">3.高階</option>
</select>
<input type="submit" value="查詢(q)" accesskey="q">
</form><br>
<input type='button' onclick='listall()' value='分類全選(x)' accesskey='x'>
<input type='button' onclick='levelall()' value='級別全選(c)' accesskey='c'>
<input type="button" value="確認(w)" onclick="Submit()">
<center><table>
<tr>
<td align=center>題目代碼</td>
<td align=center>題目國語</td>
<td align=center>題目英文</td>
<td align=center>錯誤率</td>
<td align=center>全選(z)
<input type="checkbox" value='全部選取' onclick='chkall("form1",this)' name=chk accesskey="z">
</td>
</tr>
<form id=form1 action='answer_checkbox.php' method='post'>
<?
	$Listresult = $_POST['theList'];
	$Levelresult = $_POST['theLevel'];

	for($j=0;$j<count($Listresult);$j++){
		for($k=0;$k<count($Levelresult);$k++){

	$query = "SELECT * FROM $question_db WHERE Class ='".$Listresult[$j]."' And Level='".$Levelresult[$k]."'";
			
	$result = mysql_query($query) or die(mysql_error());
	$question_total = mysql_num_rows($result); // get the total


	$dele = mysql_query("DELETE FROM $user_db WHERE time1 = 0"); //delete no start record


	$update = mysql_query("UPDATE $user_db SET end = 1 WHERE id = '$user'");
	$insert = "INSERT INTO `$user_db`(`id`,`date`) VALUES('$user','$today')";
	$inquery = mysql_query($insert) or die(mysql_error());


	$myquery = "SELECT * FROM $user_db WHERE id = '$user' AND end = '0'";
	$myresult = mysql_query($myquery) or die(mysql_error());
	$user_row = mysql_fetch_assoc($myresult);

//	for($i=0;$i<$question_total;$i++){
	while(($row = mysql_fetch_assoc($result)) != FALSE){;
		
		if($row['Use_time'] != 0 ){
		
			if(($row['False_time'] / $row['Use_time']) >= 0.2) {   // if fail rate more than 20%
			
				
				if($row["DataSource"] != null && $row["Finish"] == 0){  // control if question appear

				$cl_query = "SELECT * FROM $classfi_db WHERE id =".$row['Class'];
				$cl_result = mysql_query($cl_query) or die(mysql_error());
				$cl_row = mysql_fetch_assoc($cl_result);

?>

	<tr>
	<td><? switch($row['Level']){
			case 1: echo $cl_row['title']."A-".$row['Num'];break;
			case 2: echo $cl_row['title']."B-".$row['Num'];break;
			case 3: echo $cl_row['title']."C-".$row['Num'];break; 
			}?></td>
	<td><? echo $row["Chinese"]; ?></td>
	<td><? echo $row["English"]; ?></td>
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
		}  // if($row[False_time'] ...
	} // if($row[use_time] != null)
	}  //  for($i=0;$i<$question_total;$i++){
	} // for($k=0;$k<count($Levelresult);$k++){
	}  // for($j=0;$j<count(Listresult)...
?>
</table>
<input type='hidden' value="HighFailPractice" name="mode">
<input type='submit' value="確認(w)" accesskey="w"></form>
<input name="Submit" type="button" id="Submit" onClick="javascript:history.back(1)" value="回一上頁(r)" accesskey="r"/><br>
</center>

</body>

</html>