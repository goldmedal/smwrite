<?

/**************************************************************

 File Name : answer.php   date:20120801 
 Programmer : LKS
 Statement : 
 this file is used to play questions and give user block to input answer.
 It has two frame. one is itself, anotehr is answer_check.php which can check answer whether it's correct or not.

*****************************************************************/

	include("connect_db.php");
	include("header.php");
	include("db_name.php");
	$user = $_SESSION["sid"];
?>

<html>
<head>
<title>Screw - SMwrite�x�y�~�r�˴��t�� - ���礤 </title>
 <link type="text/css" rel="stylesheet" href="mainpage.css"> 
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <script src="Link.js"></script>
</head>
<body>
<div class='title'>Screw - SMwrite�x�y�~�r�˴��t�� - ���礤</div>
<fieldset class='remind'>
<legend>�в�ť��y�����A�D�ئb��y�������᭱</legend>
<pre>
1. �i�����S�i���N���~�r���̨ΡC
     ��J�Ҥl�J�ݧ� 
2. ���u��H�~�r���N�ɡA���n�ɦb�r�᭱�[�A���Щ������P��o���n�զӫD���աC
    ��J�Ҥl�J��(ging7) 
3. ���u��H���������ɡA���n�ɦb�᭱�[�A�������y�N�A�H��KŪ�̤F�ѫ����ҥN�����y�N�C
    ��J�Ҥl�Jmoh4���h(���U�h)  ue5(�������H���s��) 
4. �Y���~�r�i�K�����o���ɡA�᭱�[�A���g�W��Ķ�������N��C
    ��J�Ҥl�J�����H(�a�H)   �Z��(�]�\)	
</pre>
</fieldset>
<fieldset class='remind'>
<pre>
<legend>�i�H���ηƹ����D�ޥ��G</legend>
1. �� Alt+a ��ֳt��F���D��
2. �� Enter �^�����D
3. �� Space ���J�U�@�D or �ݵ��G ( �p�L�k�ϥ�Space�ֱ���, �й��ե�Ctrl+Space������J�k�Ҧ�, �A����space���D�� )
4. �� Alt+q �i�H�Ať�@���D��
</pre>
</fieldset>
<br><br>
<?

	$user_query = "SELECT * FROM $user_db WHERE id = '$user' AND end = '0'";/* select the new user record. 
										                                         the end is check whether this test end or not. */
	$user_result = mysql_query($user_query) or die(mysql_error());
	$user_row = mysql_fetch_array($user_result);

	echo "<center>���ժ�:".$user_row['id']."</center><br>";

	
	mysql_query("UPDATE $user_db SET qu_end = 0, false_time =0 WHERE id = '$user' AND end = '0'") or die(mysql_error());
																			//initial the qu_end and false each question start
	$question_num = $user_row["running"];
	$question_base = explode(",", $user_row['question']); 
	$total = count($question_base);
	if($question_num == ($total-1)){   // only the last question, set qu_end = 2 for entering another loop.
		mysql_query("UPDATE $user_db SET qu_end = 2 WHERE id = '$user' AND end = '0'");
	}
	$place = $question_num + 1; // running is start from 0;
	echo "<center>�� ".$place." �D / �@ $total �D</center>";

// select question by serial number

	$myquery = "SELECT * FROM $question_db WHERE id = '$question_base[$question_num]' ";  // 
	$result = mysql_query($myquery); 
	$row = mysql_fetch_assoc($result);
	$cl_query = "SELECT * FROM $classfi_db WHERE id =".$row['Class'];
	$cl_result = mysql_query($cl_query) or die(mysql_error());
	$cl_row = mysql_fetch_assoc($cl_result);

	if($question_num == 0){
		$time1 = date("H:i:s",mktime(date('H'),date('i'),date('s')));
		mysql_query("UPDATE $user_db SET time1 = '$time1' WHERE id = '$user' AND end = '0' ")or die(mysql_error());
	}

	switch($row['Level']){
			case 1: echo "<center>�D�w�N�X�G".$cl_row['title']."A-".$row['Num']."</center>";break;
			case 2: echo "<center>�D�w�N�X�G".$cl_row['title']."B-".$row['Num']."</center>";break;
			case 3: echo "<center>�D�w�N�X�G".$cl_row['title']."C-".$row['Num']."</center>";break;
			}
?>

	<center>
	<audio id="question" controls autoplay preload>
		<source src="<?echo $row['DataSource'];?>">
	</audio>
	</center> 

<script type="text/javascript">   //For audio's two loop

<!--
	var time = 0;

	document.getElementById("question").addEventListener('ended',function(){
		if(time==0){
			document.getElementById("question").play();
			time = 1;
			}
	}, false);

	function hi(){ // close the copy function
		alert("�ۤv��J��!!");
	}
	document.captureEvents(Event.KEYDOWN);

	

//-->

function keyFunction() {
	if (event.keyCode==81 && event.altKey) {
		document.getElementById("question").play();	
	}else if(event.keyCode==32){

		var frm = document.getElementById('SfMessCopyFrame');
		if(frm.contentDocument.nextqu.check.value == 1){
	        if(event.which==32){
				frm.contentDocument.nextqu.next.click();
			}
		}
	}

}
document.onkeydown=keyFunction;

</script>


<br>
<center>

<form action='answer_check.php' method='post' target='SfMessCopyFrame'>
<input type='hidden' name='id' value="<?echo $row['id'];?>"> <!-- tranfer question's num -->
<input type='hidden' name='total' value="<?echo $total;?>">
<label>�п�J����(a):</label><input type='text' name='user_answer' autofocuse autocomplete="off" onpaste="hi();return false" accesskey='a' /> 
<input type='submit' value='�e�X'>

</form></center>

</body>
</html>

<center><iframe id="SfMessCopyFrame" name="SfMessCopyFrame" src="answer_check.php" width="250" height="250" scrolling="no" frameborder="0" accesskey='q'></iframe></center>