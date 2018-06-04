$(document).ready(function () {
//instacinado fucoes js
    func = new Funcoes();
    $("#dataRecebimento").mask("99/99/9999");
    function listaEntregas() {
        let dataSet = [];
        let valores = []

        $.ajax({
            "method": "GET",
            "url": "/model/financeiro/ordem/entrega/request.php",
            "dataType": "json",
            "data": {
                "acao": "listaEntregas",
                "idOrdem": $("#ordem").val()

            },
            "success": function (response) {
                if ($.trim(response)) {
                    if (response.length) {
                        valores = response
                    }
                }

                for (var i = valores.length - 1; i >= 0; i--) {
                    let valor = [
                        valores[i]['dh_recebimento_sistema'],
                        valores[i]['nr_entrega_confirmacao'],
                        valores[i]['nr_prazo_ordem'],
                        valores[i]['dt_entrega'],
                        valores[i]['dt_confirmacao'],
                        valores[i]['situacao'],
                        valores[i]['diasatrazo'],
                        '<a href="/pages/financeiro/ordem/entrega/cadEntrega.php?id=' + valores[i]['id_entrega_confirmacao'] + '&ordem=' + valores[i]['id_ordem'] +
                                '" title="lançar confirmação"><span class="fa fa-upload text-success"></span></a>'
                    ]
                    dataSet.push(valor)
                }
                $('#tabela').DataTable({
                    data: dataSet,
                    language: {
                        "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
                    },

                    columns: [
                        {title: "Data Do Aviso", className: "text-center"},
                        {title: "Quantidade De Entrega", className: "text-center"},
                        {title: "Prazo De Entrega", className: "text-center"},
                        {title: "Prazo Limite Para Entrega", className: "text-center"},
                        {title: "Entregue dia", className: "text-center"},
                        {title: "Situação", className: "text-center"},
                        {title: "Dias De Atraso", className: "text-center"},
                        {title: "Ação", className: "text-center"}

                    ]
                });
            }
        });
    }
    listaEntregas();
    $("body").on("click", ".btn-salvar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            //validação de campos js
            if ($("#nomeRepresentante").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#rgCpf").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#dataRecebida").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            var protocolo = {
                "ordem": $("#ordem").val(),
                "nomeRepresentante": $("#nomeRepresentante").val(),
                "rgCpf": $("#rgCpf").val(),
                "dataRecebimento": $("#dataRecebimento").val(),
                "email": $("#email").val(),
                "quantidade": $("#quantidade").val(),
                "obsProtocolo": $("#obsProtocolo").val()
            }
            $.ajax({
                "method": "POST",
                "url": "/model/financeiro/ordem/entrega/request.php",
                "dataType": 'html',
                "data": {
                    "acao": "salvaProtocolo",
                    "protocolo": protocolo
                },
                "success": function (response) {
                    console.log(response);
                    $this.prop("disabled", false);
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
                        func.modalAlert(response.msg, 'success');
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            location.reload();
                        });
                        return false;
                    } else {
                        console.log('Ultimo else');
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    }
                },
                "error": function (response) {
                    $this.prop("disabled", false);
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            });
        }
    });
});
