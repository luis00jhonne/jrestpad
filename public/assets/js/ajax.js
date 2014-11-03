/**
  * Return a XmlHttpRequest
  */
function getXMLHttpRequest() {
    if (typeof(XMLHttpRequest) != 'undefined') {
        return new XMLHttpRequest();
    } else if (typeof(ActiveXObject) != 'undefined') {
        try {
            return new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            return new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
}
var NORMAL_STATE = 4;
var STATUS_OK = 200;

/**
 * Carrega uma url utilizando o XmlHttpRequest.
 * Callback é uma função que recebe 2 parâmetros: a resposta texto e um documento DOM
 * Este é o método principal
 */
function loadAjax ( tipo, url, conteudo, callback, async = true ) {
    var xmlHttpRequest = getXMLHttpRequest();
    //VERIFICA SE OBJETO XMLHTTPREQUEST FOI CRIADO
	if (!xmlHttpRequest) {
        alert("Seu browser não suporta este tipo de operação.\nPor favor, utilize o Firefox, Google Chrome, ou outro navegador em conformidade com o W3C.");
        return;
    }
	
    //var isPost = body != null; //Verifica se foi setado para post ou get
    //xmlHttpRequest.open(isPost ? "POST" : "GET", url, true); //Faz a requisão, propriamente falando
    xmlHttpRequest.open(tipo, url, true ); //Abre a conexão
    //xmlHttpRequest.open("POST", url, true ); //Requisição post
    if ( tipo == "POST" ) {
        xmlHttpRequest.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
    }
    
    //Função de callback
    var cb = function() {
        if (xmlHttpRequest.readyState == NORMAL_STATE) {
            if (xmlHttpRequest.status == STATUS_OK) {
                //REPONSÁVEL PELO RETORNO DA INFORMAÇÃO PARA A FUNCTION
            	callback(xmlHttpRequest.responseText, xmlHttpRequest.responseXML);
            } else {
                alert("Não houve resposta do servidor");
            }
        }
    };

    //Se for assíncrono, chama a função de callback quando estiver ready    
    if (async) {
    	xmlHttpRequest.onreadystatechange = cb;
    }
    xmlHttpRequest.send(conteudo);

    //Se for síncrono, aguarda o término da função de callback
    if (!async) {
    	cb();
    }
}
