$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    
    var url = "request.php";
    
    //select2
    $('body').find('select').select2({
        width: '100%'
    });
    
    $('#dt_anulacao').mask("99/99/9999");

    //busca pedido
    $('#modalItem').on('shown.bs.modal', function () {
        $('#codItemPesquisa').focus();
    });
    
    //Masca para valor
    $("body").on("focus", "#vl_anulacao", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
        });
    });
    
    $("body").on("focus", ".qtd_anulacao", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
        });
    });
    
    $("body").on("focus", ".vl_anulacao", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
        });
    });
                        
    
    //$('.docFis').hide();
    
    //função para pesquisa licitacao do gcon
    $('body').on('click', '#btn-pesquisa', function (e) {
        var dados = $("#codItemPesquisa").val();
        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "retornaEmpenho",
                "dados": dados

            },
            "success": function (response) {
                func.carregaTabelaPadrao('tabelaItens', response, [], true);
            }
        });
    });
    
    $('body').on('keypress', '#codItemPesquisa', function (e) {
        let key = e.which;
        if (key == 13){
            $("#btn-pesquisa").trigger('click');
            return false;
        }
    });
    
    
    $('body').on('click', '.selecionaItem', function (e) {
        var $this = $(this);
        var dados = {
            "nr_pedido": $("body").find(".selecionaItem").attr("nrpedido"),
            "id_pedido": $("body").find(".selecionaItem").attr("pedido"),
            "id_empenho": $("body").find(".selecionaItem").attr("idEmpenho"),
        }
        
        carregaDadosParaEmpenho(dados)
        
        $('#modalItem').modal('hide');
    });
    
    function carregaDadosParaEmpenho(dados){
        
        limpaCampos();
        /**
         * retornaContratosPedido
         */
        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "retornaContratosLiquidacao",
                "dados": dados

            },
            "success": function (response) {
                $(".contratos").html("");
                $(".contratos").append(response);
            }
        });
        /**
         * retornaDadosPedido
         */
        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "retornaPedidoLiquidacao",
                "dados": dados

            },
            "success": function (response) {
                $(".pedido").html("");
                $(".pedido").append(response);
                
            }
        });
        /**
         * retornaDadosEmpenho
         */
        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "retornaEmpenhoLiquidacao",
                "dados": dados

            },
            "success": function (response) {
                $(".empenho").html("");
                $(".empenho").append(response);
            }
        });
        
        /**
         * retornaItensPedido
         */
        

        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "retornaItensPedido",
                "dados": dados
            },
            "success": function (response){
                $("#tabelaItensPedido tbody").html("");
                $("#tabelaItensPedido tbody").html(response);    
                $(".qtd_anulacao").val(0)
                $(".vl_anulacao").val(0)
                
                $(".qtd_anulacao").priceFormat({
                    centsLimit: 4,
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.',
                });
                $(".vl_anulacao").priceFormat({
                    centsLimit: 4,
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.',
                });
            }
        });
    }
    
    
    
    $('body').on('keyup', '.qtd_anulacao', function(){
        calculaValorTotal(this);
    });  
    $('body').on('keyup', '.vl_anulacao', function(){
        calculaValorTotal(this);
    });  
           
    //Calculo da Tabela dos Itens
    function calculaValorTotal(elemento){
        let valor = "0";
        let qtd = "0"; 
        
        qtd = $(elemento).closest("tr").find('.qtd_anulacao').val();
        
        if($(elemento).closest("tr").find('.vl_anulacao').length > 0){
            valor = $(elemento).closest("tr").find('.vl_anulacao').val();
            valor = func.converteValorIngFloat(valor);   
        }else{
            valor = $(elemento).closest("tr").find('.qtd_anulacao').attr('valor_unitario');
        }                               
        qtd = func.converteValorIngFloat(qtd);                       
        console.log(`Quantidade: ${qtd} ... Valor Unitário: ${valor}`)                           
        $(elemento).closest("tr").find(".valor_total_itens").text(func.arrendondaValorParaQuatroCasas(qtd*valor));
        $(elemento).closest("tr").find(".valor_total_itens").priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
            centsLimit: 4
        });
        
        let valorTotal = 0;
        $(".valor_total_itens").each(function(index){            
            let valorInformado = func.converteValorIngFloat($(this).text());            
            valorTotal = valorTotal + valorInformado;
        });
        $("#vl_anulacao").val(func.arrendondaValorParaQuatroCasas(valorTotal));
        $("#vl_anulacao").priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
            centsLimit: 4
        });
        
        
    }
            
    
    $('body').on('click', '.ver-documento', function (e) {
        var id = $(this).val();
        window.open("/pages/financeiro/gdof/documentoFiscal/ver_documento/index.php?&id=" + id);
    });
    
    
    $('body').on('click', '.remover-documento', function (e) {
        $(this).closest("tr").remove();
        atualizaValorLiquidacao();
    });
                
    
    $("body").on("click", ".btn-salvar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);                        
            var itens = [];            
            $(".itens").each(function(){   
                let qtd = $(this).closest("tr").find('.qtd_anulacao').val();
                qtd = func.converteValorIngFloat(qtd);  
                let valor = 0;
                if($(this).closest("tr").find('.vl_anulacao').length > 0){
                    valor = $(this).closest("tr").find('.vl_anulacao').val();
                    valor = func.converteValorIngFloat(valor);
                    if((valor == 0 || isNaN(valor))){
                        qtd = 0;
                        valor = 0; 
                    }
                }
                if( !(qtd == 0 || isNaN(qtd) ) ){
                    itens.push({
                        id: $(this).closest("tr").find('.qtd_anulacao').attr('idpreordem'),
                        quantidade : qtd,
                        valor: valor
                    })                    
                }
            });                                                
                        
            var dados = {
                "idEmpenho": $("#id_empenho").val(),                
                "nrAnulacao": $("#nr_anulacao").val(),
                "vlAnulacao": $("#vl_anulacao").val(),
                "dtAnulacao": $("#dt_anulacao").val(),
                "anotacoes": $("#anotacoes").val(),
                "itens": itens
            }
            
            if (!(dados.idEmpenho && dados.nrAnulacao && dados.vlAnulacao 
                    && dados.dtAnulacao )) {
                func.modalAlert("Por favor preencha as informações obrigatórias.");
                $this.prop("disabled", false);
                return false;
            }                        
            
            if (dados.itens.length <= 0) {
                func.modalAlert("É Necessário que ao menos um Item do Pedido tenha os Valores de Anulação informado.");
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "request.php",
                "method": "POST",
                "dataType": "html",
                "data": {
                    "acao": "cadastrarAnulacao",
                    "dados": dados
                },
                "success": function (response) {
                    console.log(response);
                    //$this.prop("disabled", false);
                    //return false;
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
                            //window.location.href = "/pages/contabil/liquidacao/cad_liquidacao/";
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

function atualizaValorLiquidacao(){
    var vl_liquidacao = 0;
    $("tr.documentoFiscal").each(function() {
        let documento = $(this).data('objeto'); 
        vl_liquidacao = func.converteValorIngFloat(documento.vl_documento) + vl_liquidacao;
    });
    
    $("#vl_liquidacao").val(valorComMascara(vl_liquidacao));
}

function valorComMascara(valor) { 
    var valor = Number(valor).toFixed(4);
    var valorStr = valor.toString();
    valorStr = valorStr.split('.');
    valorStr[0] = valorStr[0].split(/(?=(?:...)*$)/).join('.');
    return valorStr.join(',');
}


//COMO AS INFORMAÇÕES NÃO ESTÃO DENTRO DE UM 'FORM' FOI NECESSÁRIO LIMPAR OS CAMPOS MANUALMENTE
function limpaCampos(){
    $("#nr_pagamento").val("");
    $("#dt_pagamento").val("");
    $("#vl_pagamento").val("");
    $("#desc_pagamento").val("");
    $("#id_remetente").val("0").trigger('change');
}