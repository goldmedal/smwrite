<html>
<head>
<meta http-equiv='Content-type' Charset='Big5'>
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
 <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script src="jquery.hotkeys.js"></script>	
 <script src="Link.js"></script>
</head>
<?

	include("connect_db.php");
	include("db_name.php");
	
	$name = $_POST['name'];
	$classfi = $_POST['classfi'];
	$content = $_POST['content'];
	$today = date('Ymd');
	
	if($content == '�b����J���D(50�r�H��)' || empty($content)){
		echo "�õL��J���X���D��!";
		echo "<br><input type='button' onclick='javascript:history.back(1)' value='�^�W�@��(r)' accesskey='r'>";
	}else{

	$query = mysql_query("INSERT INTO smwrite_feedback(name, classfi, content, question_date) VALUES('$name', '$classfi', '$content', '$today')");

	if(!($query)){

		echo mysql_error();

	}else{

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

			$ReResult = mysql_query("SELECT `email` FROM `assistant` WHERE id = '$name'") or die(mysql_error());
			$ReMail = mysql_fetch_assoc($ReResult);
			$List = $List.",".$ReMail['email'];
			$Num = mysql_insert_id();

			$Headers = 'From: screw@lc.flld.ncku.edu.tw' . "\r\n";

			switch($classfi)
			{
				case 1 : $MailContent = $name.":(�t�ΰ��D �y����:".$Num.")".$content.". �Ь����H���ɳt�B�z!";
						 break;
				case 2 : $MailContent = $name.":(�D�ذ��D �y����:".$Num.")".$content.". �Ь����H���ɳt�B�z!";
						 break;
				case 3 : $MailContent = $name.":(�䥦���D �y����:".$Num.")".$content.". �Ь����H���ɳt�B�z!";
			}

			mail($List,$name."SMwrite���D�^��",$MailContent, $Headers);

			echo "�P�§A���^��, �ڭ̺ɧָѨM�o�Ӱ��D!";
			echo "<br><a href='main.php' accesskey='r'>�^�M��(r)</a>";

		}
	}

?>
</html>