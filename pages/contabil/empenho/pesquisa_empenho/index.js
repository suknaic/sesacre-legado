$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    $('body').find('select').select2({
        width: '100%'
    });
    
    $('body').on('click','.btn-pesquisar', function(){
        var dados = {
            'nr_empenho': $("#nr_empenho").val(),
            'ano_exercicio': $("#ano_exercicio option:selected").val(),
            'fornecedor': $("#fornecedor option:selected").val(),
            'nr_pedido': $("#nr_pedido").val(),
            'nr_contrato': $("#nr_contrato").val(),
            'tipo_gasto': $("#tipo_gasto option:selected").val(),
            'situacao': $("#situacao option:selected").val(),
            'central': $("#central option:selected").val()
        }
        
        lista(dados);
    });
    
    
});

function lista(dados) {
    $.ajax({
        "url": "request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaEmpenhos",
            "dados": dados
        },
        "success": function (response) {
//            console.log(response);
            func.carregaTabelaPadrao('tabela', response, [9], true);
        }
    });
}