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

	 // header('refresh: 3;url="question_list.php"'); // �۰ʨ�s

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
			case 1 : $MailContent = $poster.":(�t�ΰ��D �y����:".$pro_num.")".$PosterRow['content'].". <br>".$re_name."����: ".$re_content;
					 break;
			case 2 : $MailContent = $poster.":(�D�ذ��D �y����:".$pro_num.")".$PosterRow['content'].". <br>".$re_name."����: ".$re_content;
					 break;
			case 3 : $MailContent = $poster.":(�䥦���D �y����:".$pro_num.")".$PosterRow['content'].". <br>".$re_name."����: ".$re_content;
		}

		mail($List,"Re: ".$poster." SMwrite���D�^��",$MailContent, $Headers);

	}

?>
<html>
<head>
<meta http-equiv="Content-type" Charset='big5'>	
<title>���D�޲z</title>
 <link type="text/css" rel="stylesheet" href="mainpage.css"> 
</head>
<body>
<center>
<div class="title">���D�M��</div>
<br>
<form method='post' name='form' action="manager_fblist.php">

<label>��ܤ���(a):</label><select id='theList' name='theList[]' size=5 multiple accesskey='s'>
	<option value="1">1.�t�ΰ��D</option>
	<option value="2">2.�D�ذ��D</option>
	<option value="3">3.�䥦���D</option>
</select>
<input type="submit" value="�d��(q)" accesskey='q'>
</form>
<br>
<input type='button' onclick='listall()' value='��������(x)' accesskey='x'><br>

<table border = 1>
<tr>
	<td>�y����</td>
	<td>�^����</td>
	<td>���D����</td>
	<td width='200px'>���D���e</td>
	<td>���Ъ�</td>
	<td width='200px'>����</td>
	<td>�B�z���A</td>
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
				case 1: echo "�t�ΰ��D";break;
				case 2: echo "�D�ذ��D";break;
				case 3: echo "�䥦���D";break;
			}
		?></td>
		<td width='200px'><?echo $ListRow['content']; ?></td>
		<td><?echo $ListRow['re_name']; ?></td>
		<td width='200px'><?echo $ListRow['contentback']; ?></td>
		<td>
		<?switch($ListRow['done'])
			{
				case 0: echo "���B�z";break;
				case 1: echo "�w�ѨM";break;
				case 2: echo "�B�z��";break;
			}

		?></td>
		<td><input type='button' name='GoDo' value='�B�z' onclick='GoDo(<?echo $ListRow['num']; ?>)'></td>

</tr>
<?			
		$ListRow = mysql_fetch_assoc($ListQuery);
		} // while($ListRow = FALSE){
	} //	for($i=0;$i<count($Listresult);$i++){
?>

</table>
</body>

</html>