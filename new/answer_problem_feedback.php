<?

	include("../connect_db.php");
	include("../db_name.php");
	include("funcAnsUser.php");
	
	$name = $_POST['uid'];
	$classfi = 1;
	$qid = $_POST['qid'];

	$urow = getUserInformation($name);
	$content = "測驗編號: ".$urow['num'].", 題目編號: ".$qid." 測驗卡住了. ";
	$today = date('Ymd');
	
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
				//$List = $List.", tsaim@mail.ncku.edu.tw";
			//	$List = $List.",".$ManMail['email'];
			
				$ListRow = mysql_fetch_assoc($ListResult);
			}
			$List = "liugs963@gmail.com";
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
	}
	
?>