<?

/*
	1. check answer. 
	2. if right, return information.
	3. if error, return error meg and count user's and question's error num.
*/

	require "C:\AppServ\www\screw\smwrite\funcAnsUser.php";
	require "funcAnsUser.php"

	$user = $_POST['uid'];
	$userAns = $_POST['ans'];
	$qid = $_POST['qid'];

	// check ans

	$qrow = getQuesInformation($qid);
	if(strcasecmp($userAns, $qrow['ANs']) == 0){  // right

		return json_encode(array('Status' => 0, 'Chinese' => $qrow['Chinese'], 'Taiwanese' => $qrow['Ans'], 'Spell' => $qrow['Spell'], 'English' => $qrow['English']));

	}else {



	}

?>