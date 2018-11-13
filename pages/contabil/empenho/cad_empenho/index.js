func = new Funcoes();
url = "request.php";

$(document).ready(function (){
    
    $('body').find('select').select2({
        width: '100%'
    });

    $('.collapse').on('shown.bs.collapse', function(){
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
    
    carregaRemetente();
    
    $('body').on('click', '#btn-pesquisa', function (e) {
        carregaTabelaPedidos();
    });
    
    $('body').on('click', '.seleciona-pedido', function (e) {
        var pedido = $(this).data('pedido');
        carregaDadosParaPedido(pedido);
        $('#modalPedido').modal('hide');
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

    function carregaDadosParaPedido(dados){
        
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
                "acao": "retornaDadosDoPedido",
                "dados": dados

            },
            "success": function (response) {
                $(".pedido").html("");
                $(".pedido").append(response);
                
            }
        });
        
        /**
         * retornaItensDoPedido
         */

    }
});


