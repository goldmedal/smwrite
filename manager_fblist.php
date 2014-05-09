<?	

/**************************************************************

 File Name : question_fblist.php   date:20130429 
 Programmer : LKS
 Statement : 
 the page of managing all feedback, group and class. 
 user does deleting, editing, adding or searching action.

 ****************************************************************/ 

	include("connect_db.php");
	include("db_name.php");

	 // header('refresh: 3;url="question_list.php"'); // 自動刷新

?>

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

function BackToMain(){
	location.href="manager.php";
}

function GoDo(num)
{

	location.href="feedback_pro.php?num="+num;

}

//-->
</script>
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <meta charset="big5" />
 <script src="Link.js"></script>
<?

	if($_GET['pro_num'] > 0) 
	{
		
		$pro_num = $_GET['pro_num'];
		$re_name = $_GET['re_name'];
		$poster = $_GET['poster'];
		$re_content = $_POST['backcontent'];
		$pro_state = $_POST['proState'];
		$today = date('Ymd');
		$UpdateResult = mysql_query("UPDATE $feedback_db SET `re_name`= '$re_name',`contentback`= '$re_content', `done` = '$pro_state', `new_respon_date` = '$today' WHERE `num` = '$pro_num'") or die(mysql_error());
		
		// list the mail
		
		$ListResult = mysql_query("SELECT * FROM $manger_db");
		$ListRow = mysql_fetch_assoc($ListResult);

		while($ListRow != FALSE)
		{
			$MailResult = mysql_query("SELECT `email` FROM `assistant` WHERE id = '".$ListRow['name']."'") or die(mysql_error());
			$ManMail = mysql_fetch_assoc($MailResult);
			$List = $List.", tsaim@mail.ncku.edu.tw";
			$List = $List.",".$ManMail['email'];
			$ListRow = mysql_fetch_assoc($ListResult);
		}

		$ReResult = mysql_query("SELECT `email` FROM `assistant` WHERE id = '$poster'") or die(mysql_error());
		$ReMail = mysql_fetch_assoc($ReResult);
		$List = $List.",".$ReMail['email'];

		$PosterResult = mysql_query("SELECT * FROM $feedback_db WHERE `num` = '$pro_num'");
		$PosterRow = mysql_fetch_assoc($PosterResult);

		$Headers = "Content-type: text/html; charset='big5'"."\r\n".
			"from: screw@lc.flld.ncku.edu.tw'"."\r\n";

		switch($PosterRow['classfi'])
		{
			case 1 : $MailContent = $poster.":(系統問題 流水號:".$pro_num.")".$PosterRow['content'].". <br>".$re_name."答覆: ".$re_content;
					 break;
			case 2 : $MailContent = $poster.":(題目問題 流水號:".$pro_num.")".$PosterRow['content'].". <br>".$re_name."答覆: ".$re_content;
					 break;
			case 3 : $MailContent = $poster.":(其它問題 流水號:".$pro_num.")".$PosterRow['content'].". <br>".$re_name."答覆: ".$re_content;
		}

		mail($List,"Re: ".$poster." SMwrite問題回報",$MailContent, $Headers);

	}

?>
<html>
<head>
<meta http-equiv="Content-type" Charset='big5'>	
<title>問題管理</title>
 <link type="text/css" rel="stylesheet" href="mainpage.css"> 
</head>
<body>
<center>
<div class="title">問題清單</div>
<br>
<form method='post' name='form' action="manager_fblist.php">

<label>選擇分類(a):</label><select id='theList' name='theList[]' size=5 multiple accesskey='s'>
	<option value="1">1.系統問題</option>
	<option value="2">2.題目問題</option>
	<option value="3">3.其它問題</option>
</select>
<input type="submit" value="查詢(q)" accesskey='q'>
</form>
<br>
<input type='button' onclick='listall()' value='分類全選(x)' accesskey='x'><br>

<table border = 1>
<tr>
	<td>流水號</td>
	<td>回報者</td>
	<td>問題類型</td>
	<td width='200px'>問題內容</td>
	<td>答覆者</td>
	<td width='200px'>答覆</td>
	<td>處理狀態</td>
</tr>
<?
	$qu_total = 0;
	$Listresult = $_POST['theList'];

	for($i=0;$i<count($Listresult);$i++){
		$ListQuery = mysql_query("SELECT * FROM $feedback_db WHERE `classfi` = '".$Listresult[$i]."' ORDER BY `num` DESC") or die(mysql_error());
		$ListRow = mysql_fetch_assoc($ListQuery) or die(mysql_error());
		while($ListRow != FALSE){
?>
<tr>

		<td><?echo $ListRow['num']; ?></td>
		<td><?echo $ListRow['name']; ?></td>
			<td><? 
			switch($ListRow['classfi']){
				case 1: echo "系統問題";break;
				case 2: echo "題目問題";break;
				case 3: echo "其它問題";break;
			}
		?></td>
		<td width='200px'><?echo $ListRow['content']; ?></td>
		<td><?echo $ListRow['re_name']; ?></td>
		<td width='200px'><?echo $ListRow['contentback']; ?></td>
		<td>
		<?switch($ListRow['done'])
			{
				case 0: echo "未處理";break;
				case 1: echo "已解決";break;
				case 2: echo "處理中";break;
			}

		?></td>
		<td><input type='button' name='GoDo' value='處理' onclick='GoDo(<?echo $ListRow['num']; ?>)'></td>

</tr>
<?			
		$ListRow = mysql_fetch_assoc($ListQuery);
		} // while($ListRow = FALSE){
	} //	for($i=0;$i<count($Listresult);$i++){
?>

</table>
</body>

</html>