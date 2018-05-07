$(document).ready(function () {

    func = new Funcoes();
  
    function lista() {
        
        var Dados = {
            ano : $("#ano option:selected").val(),
            lotacao : $("#lotacao option:selected").val()
        }                
        $.ajax({
            "url": "/model/pla/pas/request.php",
            "dataType": 'html',
            "data": {
                acao: "pesquisaLotacaoAno",
                dados: Dados
            },
            "success": function (response) {                
                func.carregaTabelaPadrao('tabela', response, [4], true);
            }
        });
    }
    lista();
    
    $('body').on('click', '.btn-pesquisar', function(e){
        lista();        
    });   


    $('body').on('click', '.btn-cad-pas', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            var id = $this.val();
            
            var combo = $('#lotacao').closest('.panel-body').clone();
            
            
            combo.find('#lotacao').attr("id", "lotacao_escolhida");
            
            var msg = combo;
            
           
            bootbox.confirm({
                title: 'Caixa de Seleção',
                message: msg,
                buttons: {
                    'cancel': {
                        label: 'Fechar',
                        className: 'btn-default btn-rounded'
                    },
                    'confirm': {
                        label: 'Avançar',
                        className: 'btn-primary btn-rounded'
                    }
                },
                callback: function (result) {
                    if (result) {
                        var lotacao = $("#lotacao_escolhida option:selected").val();                        
                        window.location.href = "pas.php?token="+lotacao;
                    }
                }
            });
        }

    });


});
