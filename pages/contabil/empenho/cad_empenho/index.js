func = new Funcoes();
url = "request.php";

$(document).ready(function (){
    
    $('body').find('select').select2({
        width: '100%'
    });

    $('.collapse').on('shown.bs.collapse', function(){
        console.log('teste');
        $(this).parent().find(".glyphicon-chevron-down").removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-up");
    }).on('hidden.bs.collapse', function(){
        $(this).parent().find(".glyphicon-chevron-up").removeClass("glyphicon-chevron-up").addClass("glyphicon-chevron-down");
    }); 
    
    //busca pedido
    $('#modalPedido').on('shown.bs.modal', function () {
        $('#codPedidoPesquisa').focus();
    });
    
    $('body').on('keypress', '#codPedidoPesquisa', function (e) {
        let key = e.which;
        if (key == 13){
            $("#btn-pesquisa").trigger('click');
            return false;
        }
    });
    
    $("#nr_empenho").mask("9999999999/9999");
    
    $('#dt_empenho').mask("99/99/9999");
    
    carregaRemetente();
    
    $('body').on('click', '#btn-pesquisa', function (e) {
        carregaTabelaPedidos();
    });
    
    $('body').on('click', '.seleciona-pedido', function (e) {
        var pedido = $(this).data('pedido');
        carregaDadosParaEmpenho(pedido);
        $('#modalPedido').modal('hide');
    });
    
    
    $("body").on("click", ".btn-salvar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            
            var dados = {
                "idPedido": $("#id_pedido").val(),
                "idLotacao": $("#id_remetente option:selected").data('lotacao'),
                "idDocTipoLotacao": $("#id_remetente option:selected").data('tipo-lotacao'),
                "nrEmpenho": $("#nr_empenho").val(),
                "tpEmpenho": $("#id_tipo_empenho").val(),
                "dtEmpenho": $("#dt_empenho").val(),
                "vlEmpenho": $("#vl_empenho").val(),
                "anotacoes": $("#anotacoes").val()
            }
            
            if (!dados.nrEmpenho || !dados.tpEmpenho || !dados.dtEmpenho || !dados.vlEmpenho || dados.vlEmpenho == '0,0000' || !dados.idLotacao || !dados.idDocTipoLotacao) {
                func.modalAlert("Por favor preencha as informações obrigatórias.");
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "request.php",
                "method": "POST",
                "dataType": "html",
                "data": {
                    "acao": "cadastraEmpenho",
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
    
    function carregaRemetente(){
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
    }

    function carregaTabelaPedidos(){
        var dados = $("#codPedidoPesquisa").val();
        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "retornaPedido",
                "dados": dados
            },
            "success": function (response) {
                func.carregaTabelaPadrao('tabelaPedidos', response, [], true);
            }
        });
    }

    function carregaDadosParaEmpenho(dados){
        $("#dadosContrato").html("");
        $("#dadosPedido").html("");
        $("#dadosItens").html("");
        $("#dadosDiarias").html("");
        /**
         * retornaContratosPedido
         */
        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "retornaContrato",
                "dados": dados

            },
            "success": function (response) {
                $("#dadosContrato").append(response);
            }
        });
        /**
         * retornaDadosPedido
         */
        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "retornaDadosPedido",
                "dados": dados

            },
            "success": function (response) {
                $("#dadosPedido").append(response);
                $("#vl_empenho").val($("#vl_pedido").val());
            }
        });
        
        /***
         *  retornaDadosDiaria
         */
        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "retornaDadosDiaria",
                "dados": dados
            },
            "success": function (response){
                $("#dadosDiarias").append(response);
            }
        });
        
        /**
         * retornaItensDoPedido
         */
        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "retornaItensPedido",
                "dados": dados
            },
            "success": function (response) {
                $("#dadosItens").append(response);
            }
        });

    }
    
    if($("#pedido_get").val() != 0){
        carregaPedidoPesquisa();
    }
    
    //Carrega a Parte de Contrato, Dados, Aditivos se já existir um Contrato para ser usado
    function carregaPedidoPesquisa(){
        if($("#pedido_get").val() == 0){
            return false;
        }
        var pedido = $("#pedido_get").val();
        carregaDadosParaEmpenho(pedido);       
    }
});


