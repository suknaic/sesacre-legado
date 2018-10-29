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
                "acao": "retornaEmpenhoAnulacao",
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
                
                $(".qtd_anulacao").priceFormat({
                    centsLimit: 4,
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.',
                });
                //mudaLabelQuantidadeValor();
            }
        });
    }
    
    
    
    $('body').on('keyup', '.qtd_anulacao', function(){
        calculaValorTotal(this);
    });  
    
           
    //Calculo da Tabela dos Itens
    function calculaValorTotal(elemento){
        let valor = "0";
        let qtd = "0"; 
        
        qtd = $(elemento).closest("tr").find('.qtd_anulacao').val();
        
        valor = $(elemento).closest("tr").find('.qtd_anulacao').attr('valor_unitario');
        
        if($(elemento).closest("tr").find('.qtd_anulacao').attr('tp') == "S"
                || $(elemento).closest("tr").find('.qtd_anulacao').attr('fl_valor_variavel') == 1){                                    
            valor = 1;
        }

        qtd = func.converteValorIngFloat(qtd);
        
        
        
        //console.log(`Quantidade: ${qtd} ... Valor Unitário: ${valor}`)                           
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

                if( !(qtd == 0 || isNaN(qtd) ) ){
                    itens.push({
                        id: $(this).closest("tr").find('.qtd_anulacao').attr('idpreordem'),
                        quantidade : qtd
                        //valor: valor
                    })                    
                }
            });                                                
                        
            var dados = {
                "idEmpenho": $("#id_empenho").val(),                
                "vlAnulacao": $("#vl_anulacao").val(),
                "anotacoes": $("#anotacoes").val(),
                "idLotacao": $("#id_remetente option:selected").data('lotacao'),
                "idDocTipoLotacao": $("#id_remetente option:selected").data('tipo-lotacao'),
                "itens": itens,
                "justificativa": "",
                "saldo_empenho": $("#saldo_empenho").val()
                
            }
            
            if(dados.idLotacao == 0 || dados.idLotacao == undefined){
                func.modalAlert("É Necessário informar um Remetente");
                $this.prop("disabled", false);
                return false;
            }         
            
            if (!(dados.idEmpenho && dados.vlAnulacao )) {
                func.modalAlert("Por favor preencha as informações obrigatórias.");
                $this.prop("disabled", false);
                return false;
            }                        
            
            
            
            
            if (dados.itens.length <= 0) {
                func.modalAlert("É Necessário que ao menos um Item do Pedido tenha os Valores de Anulação informado.");
                $this.prop("disabled", false);
                return false;
            }

            $this.prop("disabled", false);
            bootbox.confirm({
                title: 'Anulação do Empenho',
                message: 'Você tem Certeza que deseja continuar com o \n\
                    Anulação do Empenho <span class="text-danger">' + $("#numero_empenho").val() + '</span>?\n\
                    <br> \n\
                    <div class="form-group"> \n\
                        <label for="rem_justificativa">Justificativa: <span class="text-danger">*</span></label> \n\
                        <div class="input-group"> \n\
                            <span class="input-group-addon"> \n\
                                <p class="fa fa-list inputPFa"></p> \n\
                            </span> \n\
                            <textarea id="rem_justificativa" class="form-control"></textarea>\n\
                        </div> \n\
                    </div>',           
                buttons: {
                    'cancel': {
                        label: 'Não',
                        className: 'btn-default btn-rounded'
                    },
                    'confirm': {
                        label: 'Sim',
                        className: 'btn-primary btn-rounded'
                    }
                },

                callback: function (result) {                

                    if (result) {                                                            
                        if($("#rem_justificativa").val() == ""){
                            func.modalAlert("É Necessário Informar um Justificativa.");                        
                            return true;
                        }
                            
                        dados.justificativa = $("#rem_justificativa").val();                       

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
                }
            });            
        }
    });
});

function mudaLabelQuantidadeValor(){
    $("#tabelaItensPedido tbody tr .tipo").each(function(){
        var tipoMaterial = $(this).html();
        var cabecalho = $("#tabelaItensPedido > thead > tr");
        if (tipoMaterial == 'S' || $(this).attr('fl_valor_variavel') == 1) {
            cabecalho.find('.quantidade-valor').html('Valor da Anulação');
        } else {
            cabecalho.find('.quantidade-valor').html('Qtd. da Anulação');
        }
        return false;
    });
}

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