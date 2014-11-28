function checkClosure(){

	var errorNum = 0;
	var _last = 0;

	function checkAnswer(_uid, _qid, _ans) {

		$.ajax({
			url: 'new_answer_check.php',
			type: 'post',
			data: { qid : _qid, ans: _ans, uid: _uid, last: _last},
			dataType: 'json',
			success: function(data){		
				switch(data.Status){
					case 1:   // right
						$('#answer').html(" \
							���ߧA����F!<br> \
							��y: "+data.Chinese+" �x�y: "+data.Taiwanese+" \
							����: "+data.Spell+" �^��: "+data.English+" \
						");
						/***  add check final function ***/
						break;
					case 0: // error not final
						var errorMeg;
						switch (errorNum){ 
							case 0: errorMeg = "�����F!"; break;
							case 1: errorMeg = "���椣��!"; break;
							case 2: 
								errorMeg = "�q ~ �������ܧA�n�F "+data.Remind;
								_last = 1; // next time is the last time
								break;
							default: 
								errorMeg = "�n�զn�� ���׬O "+data.Ans;
						}
						$('#answer').html(errorMeg);
						errorNum++;

				}

			} ,
			error: function(xhr) {
				console.log(xhr.status);
			}		

		});
	}	

	return checkAnswer;

}


function keyFunction() {

	if (event.keyCode==81 && event.altKey) {
		$('#audioQuestion').play();	
	}else if(event.keyCode==32){

	}
}