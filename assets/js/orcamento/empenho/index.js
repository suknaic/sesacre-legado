$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    func.carregaTabelaPadrao('tabela', null, [7], false);

    $("body").on("click", ".btn-pesquisar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();

            var dados = {
                "central": $("#central").val(),
                "numero": $("#numero").val(),
                "ano": $("#ano").val()
            }

            $.ajax({
                "url": "/model/orcamento/empenho/request.php",
                "dataType": 'html',
                "data": {
                    acao: "retornaEmpenhos",
                    "dados": dados
                },
                "success": function (response) {
                    if (response.trim() == "SessaoExpirada") {
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        func.carregaTabelaPadrao('tabela', response.msg, [7], true);
                        return false;
                    } else {
                        console.log('Ultimo else');
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    }

                }
            });
        }
    });
});
      