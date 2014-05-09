<?	

/**************************************************************

 File Name : question_list.php   date:20120803 
 Programmer : LKS
 Statement : 
 the page of managing all question, group and class. 
 user does deleting, editing, adding or searching action.

 ****************************************************************/ 

	include("connect_db.php");
	include("db_name.php");

	 // header('refresh: 3;url="question_list.php"'); // 自動刷新

?>



<html>
<head>
<title>題庫管理</title>
 <link type="text/css" rel="stylesheet" href="mainpage.css"> 
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
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
function BackToMain(){
	location.href="manager.php";
}

function Delete(id){

	if(confirm('確定要刪除?')==true){	
		location.href="question_delete.php?delete="+id;
	}
	
}

function Edit(id){
		location.href="question_edit.php?edit="+id;	
}

function JC_delete(Jid){
	
	num = Jid;
	Jid = 'JCcheck'+Jid;
	
	if(!($('#'+Jid).checked)){
	
		$.ajax({
			url: "question_JC_delete.php",
			type: 'GET',
			data: { id: num },
			error: function() { alert("刪除發生錯誤"); },
			success: function(response){alert(response);}
		});
	
	}
}

function JC_delete(Jid){
	
	num = Jid;
	Jid = 'JCcheck'+Jid;
	
	if(!($('#'+Jid).checked)){
	
		$.ajax({
			url: "question_JC_delete.php",
			type: 'GET',
			data: { id: num },
			error: function() { alert("刪除發生錯誤"); },
			success: function(response){}
		});
	
	}
}

function callHighFailRateOutput(){

	$('div#mask').css({
		"visibility":"visible",
		"background-color":"#000000",
		"z-index":"2",
		"location":"fixed",
		"width":"100%",
		"height":"100%",
		"opacity":"0.7"
	});
	$('div#highFailRateForm').css({
		"visibility":"visible",
		"background-color":"#0000FF",
		"z-index":"3",
		"location":"fixed",
		"width":"30%",
		"height":"50%",
		"top":"20%",
		"left":"30%",
		"padding":"10px"
	
	});
	


}


//-->
</script>
 <script src="jquery.hotkeys.js"></script>	
 <script src="Link.js"></script>
  <meta http-equiv="Content-Type" content"text/html; charset="big5"/>
</head>
<body>

<div class="title2">題庫管理</div><br><br>
<center>
<input name="Submit" type="button" id="Submit" onClick="BackToMain()" value="回一上頁(r)" accesskey="r"/><br></center>
<hr>
<div class="title">分類清單</div>
<center><table border="1">
<tr>
	<td colspan=4><a href="class_add.php">新增分類</a></td>
</tr>
<tr>
<td>分類代碼</td>
<td>分類名稱</td>

</tr>
<?


	$query = "SELECT * FROM $classfi_db";
	$result = mysql_query($query) or die(mysql_error());
	$question_total = mysql_num_rows($result); // get the totat


	for($i=0;$i<$question_total;$i++){
		$row = mysql_fetch_assoc($result);

?>


	<tr>

	<td><? if(!(empty($row["title"]))){
				echo $row["title"];
			}else{ echo "未填寫";}
			?></td>
	<td><? if(!(empty($row["name"]))){
				echo $row["name"];
			}else{ echo "未填寫";}
			?></td>

	<td>
		<form id="Cldel<?echo $row['id'];?>" method='post' action='class_delete.php'>
		<input type='hidden' name='delete' value='<?echo $row["id"]?>'>  <!-- submit the num of class -->
		<input type='button' value='刪除' onclick="if(confirm('確定要刪除?\n刪除將連帶刪除此類題目')){document.getElementById('Cldel<?echo $row['id'];?>').submit();}"></form>
	</td>

	<td>
		<form action='class_edit.php' method='post'>
		<input type='hidden' name='edit' value='<?echo $row["id"]?>'>
		<input type='submit' value='修改'></form>
	</td>
	</tr>

<? 
	} 
?>
</table>
<br><hr><br>
<div class="title">題目清單</div>
<br>

<form method='post' name='form' action="question_list.php">
<label>選擇分類(a):</label><select id='theList' name='theList[]' size=5 multiple accesskey='a'>
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
<label>選擇級別(s):</label><select id='theLevel' name='theLevel[]' size=5 multiple accesskey='s'>
	<option value="1">1.基本</option>
	<option value="2">2.中階</option>
	<option value="3">3.高階</option>
</select>
<input type="submit" value="查詢(q)" accesskey='q'>
</form>
<br>
<input type='button' onclick='listall()' value='分類全選(x)' accesskey='x'>
<input type='button' onclick='levelall()' value='級別全選(c)' accesskey='c'><br>
<a href="question_add.php">新增題目</a><br><br>
<?
	$qu_total = 0;
	$Listresult = $_POST['theList'];
	$Levelresult = $_POST['theLevel'];

for($j=0;$j<count($Listresult);$j++){    // the class loop

	$titleResult = mysql_query("SELECT * FROM $classfi_db WHERE id ='".$Listresult[$j]."'");
	$titlerow = mysql_fetch_assoc($titleResult);
		
?>
<center><table border="1">
<caption><?echo $titlerow['name'];?>類</caption>
<tr>
<td>流水號</td>
<td>分類級別</td>
<td>題目代碼</td>
<td>國語</td>
<td>台語</td>
<td>拼音</td>
<td>英文</td>
<td>提示</td>	
<td>檔案來源</td>
<td>錯誤率</td>
<td>最後修改日期</td>
<td>狀態</td>
<td>備註/JC狀態</td>
</tr>
<form action="question_jc.php" method="POST">
<?
	$counter = 1;
	for($k=0;$k<count($Levelresult);$k++){  // the level loop

		$query = "SELECT * FROM $question_db WHERE Class = '".$Listresult[$j]."' AND Level =".$Levelresult[$k];
		$result = mysql_query($query) or die(mysql_error());
		$question_total = mysql_num_rows($result); // get the totat
		$qu_total += $question_total;

	for($i=0;$i<$question_total;$i++, $counter++){  // the question loop
		$row = mysql_fetch_assoc($result);
		$cl_query = "SELECT * FROM $classfi_db WHERE id =".$row['Class'];
		$cl_result = mysql_query($cl_query) or die(mysql_error());
		$cl_row = mysql_fetch_assoc($cl_result);

?>

	<tr>
	<td><? echo $counter; ?> </td>
	<td><? switch($row["Level"]){
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
	<td><? echo $row["Chinese"];?></td>
	<td><? echo $row["Ans"]; ?></td>
	<td><? if(!(empty($row["Spell"]))){
				echo $row["Spell"];
			}else{ echo "未填寫";}
			?></td>
	<td><? if(!(empty($row["English"]))){
				echo $row["English"];
			}else{ echo "未填寫";}
			?></td>
	<td><? if(!(empty($row["Remind"]))){
				echo $row["Remind"];
			}else{ echo "未填寫";}
			?></td>
	<td><? if(!(empty($row["DataSource"]))){
				echo "<a href='".$row["DataSource"]."'>".$row["DataSource"]."</a>";
			}else{ echo "未選檔 無法出題";}
			?></td>

	<td><? 
			if($row["Use_time"] == 0){
				echo "尚無人答題";
			}else{
				$error_rate = $row["False_time"]/$row["Use_time"]*100;
				echo round($error_rate,2)."%"; 
			}
		?></td>
	<td><? echo $row["date"]; ?></td>
	<td><?
			switch($row["Finish"]){
				case 0: echo "開放";
						break;
				case 1: echo "隱藏";
						break;
			}
			?></td>
	<td>
		<?echo $row["note"];?> / 
		<? if($row['JC']==0){ ?>
			<input type="checkbox" id='JCcheck<? echo $row['id'];?>' name='JCType[]' value='<? echo $row["id"]; ?>' onclick='JC_delete("<?echo $row['id'];?>");'>
		<? } else { ?>
			<input type="checkbox" id='JCcheck<? echo $row['id'];?>' name='JCType[]' value='<? echo $row["id"];?>' onclick='JC_delete("<?echo $row['id'];?>");' checked>
		<? } ?>
		/<input type='button' value='刪除' onclick="Delete('<?echo $row["id"];?>')"> <input type='button' value='修改' onclick="Edit('<? echo $row["id"]; ?>')">
	</td>
	
	</tr>
	
<? 
	} 
	} // for . the level
	$sql = "ALTER TABLE $question_db ORDER BY Num"; 
	mysql_query($sql);
?>
	</table>
	
<?
}  //for. the top table
?>


<br><input type='submit' value='JC送出(j)' accesskey='j'> 總計查詢了 <?echo $qu_total;?> 個題目
</form>
<br><hr><br>

<div class="title">題組清單</div>

<center><table border="1">

<tr>
	<td colspan=4 align=center><a href="group_add.php">新增題組</a></td>
<!-- 	<td colspan=3><a href="#" onclick="callHighFailRateOutput()">輸出常錯字題組</a></td> -->
</tr>

<tr>

<td>編號</td>
<td>名稱</td>
<td>類型</td>
<td>題數</td>
<td>題目</td>
<td></td>
<td>備註</td>

</tr>

<?

	$query = "SELECT * FROM $group_db";
	$result = mysql_query($query) or die(mysql_error());
	$question_total = mysql_num_rows($result); // get the totat


	for($i=0;$i<$question_total;$i++){
		$row = mysql_fetch_assoc($result);

?>

	<tr>
		<td><?echo $row["num"];?></td>
		<td><?echo $row["name"];?></td>
		<td><? if($row["classfi"]==0) echo "漢字測驗";
				else echo "漢音測驗";?></td>
				
		<td><?echo $row["total"]?></td>
		<td>
			<form action='group_select.php' method='post'>
			<input type='hidden' name='id' value='<?echo $row["id"]?>'>
			<input type='submit' value='進來看'></form>
		</td>
		<td>
			<form id='Grdel<?echo $row['id'];?>' action='group_delete.php' method='post'>
			<input type='hidden' name='delete' value='<?echo $row["id"]?>'>
			<input type='button' value='刪除' onclick="if(confirm('確定要刪除?')){document.getElementById('Grdel<?echo $row['id'];?>').submit();}"></form>
		</td>
		<td><?echo $row['note'];?></td>
	</tr>

<? 
	} 
	$sql = "ALTER TABLE $group_db ORDER BY id"; 
	mysql_query($sql);
?>
</table>
</center>
<div id="mask"></div>
<div id="highFailRateForm" style="visibility:hidden">

	<div id="classfiForm">
		分類: 
			<input type="radio" id='classfi' value='0' />漢音測驗
			<input type="radio" id='classfi' value='1' />漢拼測驗
	</div>
	<div id="stdRateForm">
		錯誤率標準: <input type="text" id='stdRate' />
	</div>
	<div id="submitForm">
		<button id="highFailRateSubmit" />
	</div>
	
</div>

</body>

</html>