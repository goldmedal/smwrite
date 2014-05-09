$(document).ready( function() {

	document.onkeydown = keyFunction;
	

}

function keyFunction() {
	if (event.keyCode==81 && event.altKey) {
		$('#audioQuestion').play();	
	}else if(event.keyCode==32){

	}

}