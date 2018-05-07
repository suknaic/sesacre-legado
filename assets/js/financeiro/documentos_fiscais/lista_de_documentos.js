$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    $('#tabela').DataTable({
        "lengthMenu": [[10, 25, 50, 10, -1], [10, 25, 50, 100, "Todos"]],
        "language": {
            "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
        },
        responsive: true
    });

    function listaDocumentos() {
        $.ajax({
            "url": "/model/financeiro/document_fiscais/unidades/request.php",
            "dataType": "html",
            "data": {
                "acao": "listaDocumento"
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
                        console.log('Console Mensagem');
                        func.modalAlert(func.msgErroPadrao);

                        return false;

                    } else if (response.tipoExibicao === "alert") {
                        $("body").find("#campoEmpenho").html("");
                        func.modalAlert(response.msg);

                        return false;
                    }

                } else if (response.tipoMsg === "ok") {
                    //criando o datable novamente
                    $("#tabela").find('tbody').append(response.msg);
//                    $('#tabela').DataTable({
//                        "lengthMenu": [[10, 25, 50, 10, -1], [10, 25, 50, 100, "Todos"]],
//                        "language": {
//                            "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
//                        },
//                        responsive: true
//                    });

                    return false;
                } else {
                    console.log('Ultimo else');
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            },
            "error": function (response) {
                func.modalAlert(func.msgErroPadrao);
                return false;
            }
        });
    }
    listaDocumentos();
});


