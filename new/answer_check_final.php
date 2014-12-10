<?

	// check final question

	require_once("../db_name.php");
	require_once("funcAnsUser.php");

	$qid = $_POST['qid'];
	$user = $_POST['uid'];

	$row = getUserInformation($user);
	$qList = explode(",", $row['question']);
	$last = count($qList);
	if($last == $qList[$last]){

		echo json_encode(array('Final' => 1));

		/* record end time */
		$time2 = date("H:i:s",mktime(date('H'),date('i'),date('s')));
		mysql_query("UPDATE $user_db SET time2 = '$time2' WHERE id = '$user' AND end = '0' ")or die(mysql_error());		

	}else{

		echo json_encode(array('Final' => 0));

	}

?>