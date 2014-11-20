$(document).ready( function (){
	$("#enviar").click(function(){
		var content = $("#url").val();
		if ( content == '' || content == null ){
			alert('Informe a URL!');
			return false;
		} else {
			$.ajax({
				data: {sala:content },
				url: document.location,
		        contentType: "application/x-www-form-urlencoded;charset=UTF-8",
		        type: "PUT",
		        dataType: 'json',
		        success: function(result) {
		        	$(location).attr('href', result['novaUrl'] );
		        }
			});
		}
	});
});
