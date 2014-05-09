<!-- **************************************************************

 File Name : main.php  date:20130430 
 Programmer : LKS
 Statement : 
 the main page of this system

 ****************************************************************  -->
<?
	session_start();
	$user = $_SESSION['sid'];
	include("connect_db.php");
	include("db_name.php");

?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 

"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title> SMWrite 台語書寫測驗系統 </title>
 <link type="text/css" rel="stylesheet" href="mainpage.css">
 <meta http-equiv="content-type" content="text/html; charset=big5">
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <script>

		 $(document).bind('keydown','alt+r',function(evt){
			var wparent = window.parent;
			wparent.HotKeyGo();
			
		});
 </script>
</head>
<body>
<div class='title'>
SMWrite 台語書寫測驗系統 Beta 4.0 
</div>
<fieldset class="item">
<ul>
<li><a href="sm_list.html" accesskey="a">漢字測驗(a)</li>
<li><a href="sp_list.html" accesskey="s">漢音測驗(s)</a></li>
<?	


	$MangerResult = mysql_query("SELECT * FROM $manger_db WHERE `name` = '$user'") or die(mysql_error());
	$MangerTotal = mysql_num_rows($MangerResult);
	if($MangerTotal > 0){


?>
<li><a href="manager.php" accesskey="w">管理者頁面(w)</a></li>
<? } ?>
<li><a href="feedback_user.php" accesskey="q">回報問題(q)</a></li>
</ul>
</fieldset>
<fieldset class="remind">
<legend>公布欄</legend>
<div class="thead">重要事項</div>
<table border=1>
	<tr>
		<td>日期</td>
		<td>類型</td>
		<td>發布人</td>
		<td>內容</td>
	</tr>
	<tr>
		<td>20130513</td>
		<td>系統</td>
		<td>LKS</td>
		<td>問題回報後, 可以到首頁來看問題有沒有顯示, 如果沒有, 可以等數秒鐘再看一次. <br>確定沒有, 再重新回報一次. 同樣的問題請不要一發送</td>
	</tr>
	<tr>
		<td>20130506</td>
		<td>系統</td>
		<td>LKS</td>
		<td>如做完測驗, 有對答案不了解的地方, 都可以到觀看記錄的地方看自己的答題記錄, 或著答案</td>
	</tr>
	<tr>
		<td>20130506</td>
		<td>系統</td>
		<td>LKS</td>
		<td>已修改提示機制, 答錯兩次即給提示, 三次以上即給答案</td>
	</tr>
	<tr>
		<td>20130430</td>
		<td>系統</td>
		<td>LKS</td>
		<td>新的問題回報系統已經完成了, 以後回報問題都會自動寄信到管理員的信箱與回報者的信箱中!</td>
	</tr>
	<tr>
		<td>20130417</td>
		<td>系統</td>
		<td>LKS</td>
		<td>最近SMWrite系統在按照May的想法修改中, 若暫時有版面排版怪異的, 請見諒</td>
	</tr>



</table>
<div class="thead">回報問題</div>
<table border=1 style="table-layout:fixed;text-align=left" width=900px >
<tr>
	<td width=100px>日期 - 編號</td>
	<td width=100px>回報者</td>
	<td width=50px>問題類型</td>
	<td width=300px>回報內容</td>
	<td width=300px>答覆內容</td>
	<td width=50px>處理狀況</td>
	


</tr>
<?
//	$update = mysql_query("UPDATE `smwrite_feedback` SET `done` = '1' WHERE `num` = '".$_POST['num']."'") or die(mysql_error());

	$query = mysql_query("SELECT * FROM smwrite_feedback ORDER BY `num` DESC");
	$total = mysql_num_rows($query);

	for($i=0;$i<10;$i++){
		$row = mysql_fetch_assoc($query);
?>

<tr>
	<td border=0>
	<?
		if($row['question_date'] != 0){
		
			$date = new DateTime($row['question_date']);
			echo date_format($date, "Ymd")." - ";
			
		}
		
		echo $row['num'];
	
	?>
	
	</td>
	<td ><?echo $row['name'];?></td>
	<td><? 
			switch($row['classfi']){
				case 1: echo "系統<br />問題";break;
				case 2: echo "題目<br />問題";break;
				case 3: echo "其它<br />問題";break;
			}
		?></td>

	<td ><?echo $row['content'];?></td>
	<td><?
	
			if($row['new_respon_date'] != 0){
			
				$date = new DateTime($row['new_respon_date']);
				echo date_format($date, "Ymd")." - ";
			
			}
			echo $row['re_name'];
			
	?>:<br/>
	<?echo $row['contentback']; ?></td>
	<td>
	<? 
		if($row['done'] == 1){echo "已解決";}
		else if($row['done'] == 2){echo "處理中";}
		else{ echo "待處理"; } 
	?> 
	</td>
</tr>
<?
	}
?>
</table>
<br>

</fieldset>



</body>
</html>
