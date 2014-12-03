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
							恭喜你答對了!<br> \
							國語: "+data.Chinese+" 台語: "+data.Taiwanese+"<br> \
							拼音: "+data.Spell+" 英文: "+data.English+" \
						");
						/***  add check final keyFunctionion ***/
						break;
					case 0: // error not final
						var errorMeg;
						switch (errorNum){ 
							case 0: errorMeg = "答錯了!"; break;
							case 1: errorMeg = "不行不行!"; break;
							case 2: 
								errorMeg = "吼 ~ 偷偷提示你好了 "+data.Remind;
								_last = 1; // next time is the last time
								break;
							default: 
								errorMeg = "好啦好啦 答案是 "+data.Ans;
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

function checkFinal(_qid, _uid){

	 $.ajax({

		url: 'new_answer_check.php',
		type: 'post',
		data: { qid : _qid,  uid: _uid },
		dataType: 'json',
		success: function(data){		

			if(data.Final == 1){

				/* End */

			}else{

				/* next qustion */

			}

		},
		error: function(xhr){
			console.log(xhr.status);
		}



	 });

}

function nextQuestion(){


}



function keyFunction() {

	if (event.keyCode==81 && event.altKey) {
		$('#audioQuestion').play();	
	}else if(event.keyCode==32){

	}
}