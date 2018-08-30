$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    
    var url = "request.php";
    
    //select2
    $('body').find('select').select2({
        width: '100%'
    });
    
    $('#data_liquidacao').mask("99/99/9999");

    //busca pedido
    $('#modalItem').on('shown.bs.modal', function () {
        $('#codItemPesquisa').focus();
    });

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
         * retornaDocumentosEmpenho
         */
        

        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "retornaDocFiscaisLiquidacao",
                "dados": dados
            },
            "success": function (response){
                $("#selectDocumentoFiscal").html("");
                $("#selectDocumentoFiscal").append(response);
            }
        });
        
        $('#modalItem').modal('hide');
    });
    
    $('body').on('click','.addDocumento', function(e){
       var documento = $("#selectDocumentoFiscal option:selected").data('objeto');
       var linhaTabela = `<tr>
                            <td class="text-center">${documento.nr_documento_fiscal}</td>
                            <td class="text-center">${documento.nm_tipo_documento}</td>
                            <td class="text-center">${documento.competencia}</td>
                            <td class="text-center">${documento.dt_emissao}</td>
                            <td class="text-center">${documento.dt_atesto}</td>
                            <td class="text-center">${documento.vl_documento}</td>
                            <td class="text-center">${documento.vl_documento}</td>
                            <td class="text-center">${documento.nm_situacao}</td>
                            <td class="text-center"></td>
                         </tr>`;
        
        $('#tabelaDocumentos tbody').append(linhaTabela);
    });

});
