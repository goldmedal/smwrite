
function record(_user, _mode, _sp){

	$.ajax({
	
		url: "cgi-bin/	record.php",
		type: "get",
		dataType: "html",
		data: { user: _user, mode: _mode, sp: _sp },
		success: function(data){
		
			$('#child').html(data);
		
		},
		error: function(xhr){
		
			alert(xhr.status);
		
		}
	
	});

}