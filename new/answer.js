function checkClosure(){

	var errorNum = 0;
	var _last = 0;

	function checkAnswer(_uid, _qid, _ans, _nowId) {

		$.ajax({
			url: 'new_answer_check.php',
			type: 'post',
			data: { qid : _qid, ans: _ans, uid: _uid, last: _last, error: errorNum},
			dataType: 'json',
			success: function(data){
				switch(data.Status){
					case 1:   // right
						$('#answer').html(" \
							���ߧA����F!<br> \
							��y: "+data.Chinese+" �x�y: "+data.Taiwanese+"<br> \
							����: "+data.Spell+" �^��: "+data.English+" \
						");
						checkFinal(_qid, _uid, _nowId);
						break;
					case 0: // error not final
						var errorMeg;
						switch (errorNum){ 
							case 0: errorMeg = "�����F!"; break;
							case 1: errorMeg = "���椣��!"; break;
							case 2: 
								if(data.Remind){
									errorMeg = "�q ~ �������ܧA�n�F "+data.Remind;
								}else {
									errorMeg = "�٬O����F�� ~ ";
								}
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

function checkFinal(_qid, _uid, _nowId){

	 $.ajax({

		url: 'answer_check_final.php',
		type: 'post',
		data: { qid : _qid,  uid: _uid },
		dataType: 'json',
		success: function(data){		

			if(data.Final == 1){

				/* End */
				endTest(_uid);

			}else{

				nextQuestion(_uid, _nowId);

			}

		},
		error: function(xhr){

			console.log(xhr.status);

		}


	 });

}

function nextQuestion(_uid, _nowId){

	/* Change Now num */
	$('#submitAnswer').html("�U�@�D").click(function(){
		_nowId = parseInt(_nowId);
		_nowId += 1;
		window.location.href="new_answer.php?nowNum="+_nowId;

	});

}

function endTest(_uid){

	$('#submitAnswer').html("���絲�G").click(function(){
		window.location.href="answer_result.php?uid="+_uid;
	});

}


