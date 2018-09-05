//instacinado fucoes js
func = new Funcoes();

$(document).ready(function () {
    
    retonaOptiosSituacao();
    
    $('body').find('select').select2({
        width: '100%'
    });


    $("body").on("click", ".btn-pesquisar", function () {
        lista();
    });

    $('body').on('click', '.ver-liquidacao', function (e) {
        var id = $(this).val();
        window.open("/pages/contabil/liquidacao/ver_liquidacao/index.php?&id=" + id);
    });
    
    $('body').on('click', '.editar-liquidacao', function (e) {
        var id = $(this).val();
        window.open("/pages/contabil/liquidacao/edit_liquidacao/index.php?&id=" + id);
    });


});


function lista() {
   
    $.ajax({
        "url": "request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaLiquidacoes"
        },
        "success": function (response) {
            func.carregaTabelaPadrao('tabela', response, [4], true);
        }
    });
}

function retonaOptiosSituacao(){
    $.ajax({
        "url": "request.php",
        "dataType": "html",
        "data": {
            "acao": "retornaOptionsSituacaoLiquidacao"
        },
        "success": function (response){
            $("#situacao").html(response);
        }
    });
}
