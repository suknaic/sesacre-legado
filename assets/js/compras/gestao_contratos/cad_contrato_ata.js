$(document).ready(function() {
    //instacinado fucoes js
    func = new Funcoes();
    //Mascara do sistema

    $(".select").select2({
        width: " 100%"
    });

    //carrega os itens de uma ata
    function retornatrItensAtaContrato(){
        var dados = {
            "id": $("#id").val()
        }

        $.ajax({
            "url": "/model/compras/itens/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornatrItensAtaContrato",
                "dados": dados
            },
            "success": function(response) {
                $("#tabela").find("tbody").html(response);
            }
        });    
    }
    retornatrItensAtaContrato();
    //fim
    
    //Masca para valor
    $("body").on("focus", "#qtd", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
        });
    });

    $("body").on("focus", "#vl", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
        });
    });

    //Cadastrar item
    $("body").on("click", ".btn-salvar", function(e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            var itens = [];
           // $this.prop("disabled", true);
           $(".itens").each(function () {
            if (($(this).find(".qtd").length) == 1 && ($(this).find(".vl").length) == 0 ) {
                if ($(this).find(".qtd").val() != '0,00' && $(this).find(".qtd").val() != '') {
                    itens.push({'qtd': $(this).find(".qtd").val(), 'idItem': $(this).find(".qtd").attr("itemId"),
                        'id': $("body").find("#id").val(), 'tp': $(this).find(".qtd").attr("tp")});
                }
            }

            if (($(this).find(".qtd").length) == 1 && ($(this).find(".vl").length) == 1 ) {
                if ($(this).find(".vl").val() != '0,00' && $(this).find(".vl").val() != '' &&
                    $(this).find(".qtd").val() != '0,00' && $(this).find(".qtd").val() != '') {
                    itens.push({'qtd': $(this).find(".qtd").val(), 'vl': $(this).find(".vl").val(), 'idItem': $(this).find(".vl").attr("itemId"),
                        'id': $("body").find("#id").val(), 'tp': $(this).find(".qtd").attr("tp")});
                }
            }
        });
           var enc = JSON.stringify(itens);

           $.ajax({
            "type": "POST",
            "url": "/model/compras/itens/request.php",
            "dataType": "html",
            "data": {
                "acao": "cadastroItemAtaContrato",
                "itens": enc
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
                        window.location.href = "/pages/compras/gestao_contratos/cad_item_contrato_ata.php?tipo=contrato&&id="+response.msg;
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

           $this.prop("disabled", false);
       }
   });
    //fim
});
