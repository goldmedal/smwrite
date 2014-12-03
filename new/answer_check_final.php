<?

	// check final question

	require_once("../db_name.php");
	require_once("funcAnsUser.php");

	$qid = $_POST['qid'];
	$user = $_POST['id'];

	$row = getUserInformation($user);
	$qList = explode(",", $row['question']);

?>