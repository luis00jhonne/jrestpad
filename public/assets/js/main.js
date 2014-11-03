$(document).ready(function () {
    $("#enviar").click(
            function () {
                var content = $("#conteudo").val();
                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    data: {conteudo: content},
                    url: 'index.php',
                    async: true,
                    //context: jQuery('#enviar'),
                    success: function (retorno) {
                        $("#resultado").append(retorno);
                    },
                    error: function () {
                        alert('Erro ao realizar a requisição');
                    }

                });
            });
});