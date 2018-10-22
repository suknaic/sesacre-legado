$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    
    var url = "request.php";
    
    $('#dt_empenho_anulacao').mask("99/99/9999");
    
    //select2
    $('body').find('select').select2({
        width: '100%'
    });
    
    $.ajax({
        "url": url,
        "dataType": 'html',
        "data": {
            "acao": "retornaTipoRemetenteERemetente"
        },
        "success": function(response){
            $("#id_remetente").html("");
            $("#id_remetente").append(response);
        }
    });

    $("body").on("click", ".btn-deferir", function (e) {
        var $this = $(this);
        var dados = {
            "deferir": $this.val(),
            "pagamento": $("#pagamento").val(),
            "nr_anulacao": $("#nr_empenho_anulacao").val(),
            "dt_anulacao": $("#dt_empenho_anulacao").val(),
            "idLotacao": $("#id_remetente option:selected").data('lotacao'),
            "idDocTipoLotacao": $("#id_remetente option:selected").data('tipo-lotacao')
        }
        
        if (dados.deferir == 2) {
            if (dados.nr_anulacao == "" || dados.dt_anulacao == "") {
                func.modalAlert("Por favor preencha as informações obrigatórias.");
                $this.prop("disabled", false);
                return false;
            }
        }
        
        $.ajax({
            "type": "POST",
            "url": "/pages/contabil/empenho/anulacao/ver_autorizacao/request.php",
            "dataType": "html",
            "data": {
                "acao": "cadastrarAnulacao",
                "dados": dados
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
                        console.log(response);
                        console.log('Console Mensagem');
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    } else if (response.tipoExibicao === "alert") {
                        func.modalAlert(response.msg);
                        return false;
                    }
                } else if (response.tipoMsg === "ok") {
                    func.modalAlert('Itens cadastros com Sucesso', 'success');
                    $('.modal-alert').on('hidden.bs.modal', function (e) {
                        window.location.href = "/pages/contabil/empenho/anulacao/autorizacao/index.php";
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

    });

});




