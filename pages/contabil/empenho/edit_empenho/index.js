func = new Funcoes();

$(document).ready(function (){
    
    $('body').find('select').select2({
        width: '100%'
    });
    
    $('.collapse').on('shown.bs.collapse', function(){
        $(this).parent().find(".glyphicon-chevron-down").removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-up");
    }).on('hidden.bs.collapse', function(){
        $(this).parent().find(".glyphicon-chevron-up").removeClass("glyphicon-chevron-up").addClass("glyphicon-chevron-down");
    }); 
    
    //Masca para valor
    $("body").on("focus", "#vl_empenho", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
        });
    });
    
    $("body").on("click", ".btn-salvar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            
            var dados = {
                "idEmpenho": $("#id_empenho").val(),
                "idPedido": $("#id_pedido").val(),
                "nrEmpenho": $("#nr_empenho").val(),
                "tpEmpenho": $("#id_tipo_empenho").val(),
                "dtEmpenho": $("#dt_empenho").val(),
                "vlEmpenho": $("#vl_empenho").val(),
                "dsEmpenho": $("#ds_empenho").val()
            }
            
            if (!dados.nrEmpenho || !dados.tpEmpenho || !dados.dtEmpenho || !dados.vlEmpenho || dados.vlEmpenho == '0,0000') {
                func.modalAlert("Por favor preencha as informações obrigatórias.");
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "request.php",
                "method": "POST",
                "dataType": "html",
                "data": {
                    "acao": "atualizaEmpenho",
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
                            console.log('Console Mensagem');
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
