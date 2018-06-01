$(document).ready(function () {
    
    func = new Funcoes();
    
    function lista() {
        $.ajax({
            "url": "/model/diarias/decreto_valor/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaTable"
            },
            "success": function (response) {            
                func.carregaTabelaPadrao('tabela', response, [2]);
            }
        });
    }
    lista();
    
    function decretoCombo(){
        $.ajax({
            "url": "/model/diarias/decreto_valor/request.php",
            "dataType": 'html',
            "data": {
                acao: "returnDecretoOption"
            },
            "success": function (response) {            
                $("#id_decreto").html(response);
            }
        });
    }
    
    decretoCombo();
    
    function listaClasseCombo(decreto) {
        $.ajax({
            "url": "/model/diarias/decreto_valor/request.php",
            "dataType": 'html',
            "data": {
                acao: "returnClasseOption",
                dados: decreto
            },
            "success":
                    function (response) {
                        $("#id_classe").html(response);
                    }
        });
    }
    
    $('body').find('select').select2({
    });
    
    $('#id_decreto').on('change', function(e){
        e.preventDefault();
        var decreto = $("#id_decreto").val();
        listaClasseCombo(decreto);
    });
});

