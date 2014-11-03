function loadDoc()
{
    var conteudo = document.getElementById("conteudo").value;
    loadAjax ( "POST", "index.php", "conteudo="+conteudo, resposta, true );
}

function resposta( texto, xml ){
	document.getElementById('resultado').innerHTML = texto; //Adiciona o resultado à página 
	document.getElementById("conteudo").value = ''; //Limpa o conteúdo enviado
}
