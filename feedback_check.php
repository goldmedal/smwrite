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
	
	if($content == '在此輸入問題(50字以內)' || empty($content)){
		echo "並無輸入任合問題喔!";
		echo "<br><input type='button' onclick='javascript:history.back(1)' value='回上一頁(r)' accesskey='r'>";
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
				case 1 : $MailContent = $name.":(系統問題 流水號:".$Num.")".$content.". 請相關人員盡速處理!";
						 break;
				case 2 : $MailContent = $name.":(題目問題 流水號:".$Num.")".$content.". 請相關人員盡速處理!";
						 break;
				case 3 : $MailContent = $name.":(其它問題 流水號:".$Num.")".$content.". 請相關人員盡速處理!";
			}

			mail($List,$name."SMwrite問題回報",$MailContent, $Headers);

			echo "感謝你的回報, 我們盡快解決這個問題!";
			echo "<br><a href='main.php' accesskey='r'>回清單(r)</a>";

		}
	}

?>
</html>