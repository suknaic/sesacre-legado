$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    //carrega os itens de um fornecedor
    function retornatrItensFornecedor() {
        var dados = {
            "id": $("#id").val()
        }

        $.ajax({
            "url": "/model/financeiro/preOrdem/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaTrFornecedor",
                "dados": dados
            },
            "success": function (response) {
                $("#tabela").find("tbody").html(response);
            }
        });
    }
    retornatrItensFornecedor();

    //Masca para quantidade
    $("body").on("focus", "#qtd", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
        });
    });
    //Masca para valor
    $("body").on("focus", "#vl", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
        });
    });

    //Cadastrar item
    $("body").on("click", ".btn-salvar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            var itens = [];
            var erro = false;
            // $this.prop("disabled", true);
            
            var id = $("body").find("#id").val();
            
            $(".itens").each(function () {
                var quantidade = $(this).find(".qtd").val();
                var valor = $(this).find(".vl").val();
                var idItem = $(this).data('id');
                var tp = $(this).data('tp-material');
                var flVariavel = $(this).data('fl-valor-variavel');
                
                if (!quantidade || quantidade == "0,0000") {
                    quantidade = 0;
                }
                
                if (!valor || valor == "0,0000") {
                    valor = 0;
                }
                
                var item = {
                    'id': id,
                    'idItem': idItem,
                    'tp': tp,
                    'qtd': quantidade,
                    'vl': valor
                }
                
                if ((item.tp == "C" || item.tp == "P") && item.qtd != 0 && flVariavel == "0") {
                    itens.push(item);
                }
                
                if ((item.tp == "S" || flVariavel == '1') && item.qtd != 0 && item.vl != 0) {
                    itens.push(item);
                }
                
                
//                if (($(this).find(".qtd").length) == 1 && ($(this).find(".vl").length) == 0) {
//                    if ($(this).find(".qtd").val() != '0,0000' && $(this).find(".qtd").val() != '') {
//                        itens.push({'qtd':item.find(".qtd").val(), 'idItem': $(this).find(".qtd").attr("itemId"),
//                            'id': id, 'tp': $(this).find(".qtd").attr("tp")});
//                    }
//                }
//
//                if (($(this).find(".qtd").length) == 1 && ($(this).find(".vl").length) == 1) {
//                    if ($(this).find(".vl").val() != '0,0000' && $(this).find(".vl").val() != '' &&
//                            $(this).find(".qtd").val() != '0,0000' && $(this).find(".qtd").val() != '') {
//                        itens.push({'qtd': $(this).find(".qtd").val(), 'vl': $(this).find(".vl").val(), 'idItem': $(this).find(".vl").attr("itemId"),
//                            'id': $("body").find("#id").val(), 'tp': $(this).find(".qtd").attr("tp")});
//                    }
//                }
            });
            
            if(itens.length === 0){
                 func.modalAlert(func.msgPreencherCampos);
                 return false;
            }
           
            var enc = JSON.stringify(itens);

            $.ajax({
                "type": "POST",
                "url": "/model/financeiro/preOrdem/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadatrarItemPreOrdem",
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
                            window.location.href = "/pages/financeiro/preOrdem/preOrdemItens.php?id=" + response.msg;
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
      