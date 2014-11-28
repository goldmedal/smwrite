<?php

/*
	1. check answer. 
	2. if right, return information.
	3. if error and not final, return error meg and count user's and question's error num.
	4. if error and final, return remind 
*/

//	require "C:\AppServ\www\screw\smwrite\funcAnsUser.php";
	require_once "funcAnsUser.php";

	$user = $_POST['uid'];
	$userAns = $_POST['ans'];
	$qid = $_POST['qid'];
	$last = $_POST['last'];

	// check ans

	$qrow = getQuesInformation($qid);
	if(strcasecmp($userAns, $qrow['Ans']) == 0){  // right

		echo json_encode(array(
			'Status' => 1, 'Chinese' => $qrow['Chinese'], 
			'Taiwanese' => $qrow['Ans'], 'Spell' => $qrow['Spell'], 
			'English' => $qrow['English']
			));

	}else if($last != 1) {  // error and not final

		countError($user,$qid);
		recordError($user, $qid);
		echo json_encode(array('Status' => 0, 
			'Remind' => $qrow['remind']
			));

	} else { // error and final

		echo json_encode(array('Status' => 0, 
			'Ans' => $qrow['Ans']
			));

	}

?>