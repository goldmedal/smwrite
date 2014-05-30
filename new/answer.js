$(document).ready( function() {

	document.onkeydown = keyFunction;
	
}

function nextQuestion(_qid) {

	$.ajax({
		url: 'answer_check.php',
		type: 'post',
		data: { qid : _qid },
		success: { },
		error: { },		


	});
}	


}


function keyFunction() {

	if (event.keyCode==81 && event.altKey) {
		$('#audioQuestion').play();	
	}else if(event.keyCode==32){


}