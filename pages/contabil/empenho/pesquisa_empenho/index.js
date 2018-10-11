$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    $('body').find('select').select2({
        width: '100%'
    });
    
    lista();
});

function lista() {
    
    $.ajax({
        "url": "request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaEmpenhos"
        },
        "success": function (response) {
            func.carregaTabelaPadrao('tabela', response, [4], true);
        }
    });
}