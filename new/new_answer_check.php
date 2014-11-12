<?

/*
	1. check answer. 
	2. if right, return information.
	3. if error and not final, return error meg and count user's and question's error num.
	4. if error and final, return remind 
*/

	require "C:\AppServ\www\screw\smwrite\funcAnsUser.php";
	require "funcAnsUser.php"

	$user = $_POST['uid'];
	$userAns = $_POST['ans'];
	$qid = $_POST['qid'];
	$final = $_POST['final'];

	// check ans

	$qrow = getQuesInformation($qid);
	if(strcasecmp($userAns, $qrow['ANS']) == 0){  // right

		return json_encode(array('Status' => 1, 'Chinese' => $qrow['Chinese'], 'Taiwanese' => $qrow['Ans'], 'Spell' => $qrow['Spell'], 'English' => $qrow['English']));

	}else if($final != 1) {  // error and not final

		recordError($user, $qid);
		return json_encode(array('Status' => 0));

	} else { // error and final

		return json_encode(array('Status' => 0, 'Ans' => $qrow['ANS']));

	}

?>