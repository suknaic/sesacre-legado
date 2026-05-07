$(document).ready(function () {

    func = new Funcoes();

    function listaUnidadeTipoGastoMaterial() {
        
        
        if($("#lotacao").val() == 0){
            return;
        }
        
        $.ajax({
            "url": "/model/pla/central/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaUnidadeParaValidao",
                lotacao: $("#lotacao").val()
            },
            "success": function (response) {             
                func.carregaTabelaPadrao('tabela', response, [4], true);
            }
        });
    }
    listaUnidadeTipoGastoMaterial();
       
    $('body').on('change', '#selectLotacao', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);            
            $("#lotacao").val( $this.val());   
            mostraMenu();
            listaUnidadeTipoGastoMaterial();
        }
    });
    
    $('body').on('click', '#itens_validados', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();                        
            var $this = $(this);
            $("#modalAno").modal('show');
            //window.location.href = "pas.php?token="+Dados.lotacao;            
        }
    });
    
    $('body').on('click', '#avancar', function (e) {
                     
        var ano = $(".anoSelect option:selected").val();        
        if(ano == 0){
            $("#modalAno").modal('hide');
            return false;
        }

        window.location.href = "itens_validados.php?token="+$("#lotacao").val()+"&tokenA="+ano;                                                   
    });
       
    function mostraMenu(){        
        if($("#lotacao").val() != 0){
            $("#divMenu").show();
        }
    }
    mostraMenu();
       
       
});
