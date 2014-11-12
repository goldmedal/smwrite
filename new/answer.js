function checkAnswer(_uid, _qid, _ans, _final) {

	$.ajax({
		url: 'new_answer_check.php',
		type: 'post',
		data: { qid : _qid, ans: _ans },
		success: {  },
		error: { },		


	});
}	


}


function keyFunction() {

	if (event.keyCode==81 && event.altKey) {
		$('#audioQuestion').play();	
	}else if(event.keyCode==32){


}