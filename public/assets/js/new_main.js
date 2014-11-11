function loadDoc( conteudo ){
   // var conteudo = document.getElementById("resultado").value;
    
    loadAjax ( "POST", "index.php", "conteudo="+conteudo, resposta, true );
}

$(document).ready( function (){
	$("#resultado").keypress(function(e){
		
		var conteudo = this.value;
		
		if ( e.which == 8 ){
			//alert('Backspace');
		}
		
		if ( e.which == 13 ){ // Se for enter
			if ( conteudo == '' ){ //Se não existe conteúdo
				e.preventDefault();
			} else {
				loadDoc( conteudo );
			}
		}
	});
});
function deleta(){
	
	
	
}

function resposta( texto, xml ){
	document.getElementById('resultado').innerHTML = texto; //Adiciona o resultado à página 
}