$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    
    url = 'request.php';

    $('body').find('select').select2({
        width: '100%'
    });
    
    $('select').change( function (){
        $(this).select2();
    });
    
    retornaOptionsEmpenhoAnulacaoSituacoes();
    
    $('body').on('click','.btn-pesquisar', function(){
        var dados = {
            'nr_empenho_anulacao': $("#nr_empenho_anulacao").val(),
            'nr_empenho': $("#nr_empenho").val(),
            'ano_empenho_anulacao': $("#ano_empenho_anulacao option:selected").val(),
            'fornecedor': $("#id_fornecedor option:selected").val(),
            'nr_pedido': $("#nr_pedido").val(),
            'nr_contrato': $("#nr_contrato").val(),
            'tipo_gasto': $("#tipo_gasto option:selected").val(),
            'situacao': $("#situacao option:selected").val(),
            'central_demanda': $("#id_central option:selected").val()
        }
        
        lista(dados);
    });
    
    $('body').on('click','.ver-anulacao-empenho',function(){
        var id = $(this).val();
        window.open("/pages/contabil/empenho/anulacao/ver/index.php?&id=" + id);
    });
    
});

function lista(dados) {
    $.ajax({
        "url": url,
        "dataType": 'html',
        "data": {
            "acao": "retornaAnulacoesEmpenho",
            "dados": dados
        },
        "success": function (response) {
            func.carregaTabelaPadrao('tabela', response, [9], true);
        }
    });
}

function retornaOptionsEmpenhoAnulacaoSituacoes(){
    $.ajax({
        "url": url,
        "dataType": 'html',
        "data": {
            "acao": "retornaOptionsEmpenhoAnulacaoSituacoes"
        },
        "success": function (response){
            console.log(response);
            $("#situacao").html("");
            $("#situacao").append(response);
        }
    });
}


