$(document).ready(function () {

    func = new Funcoes();
    //func.carregaTabelaPadrao('tabela', "", []);
    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);            
            
            var Dados = {
                ano: $("#ano option:selected").val(),
                lotacao: $("#lotacao option:selected").val()
            }
            
            if(Dados.ano == 0){
                func.modalAlert("Necessário Selecionar no mínimo um Ano.");
                return false;
            }
           
            $.ajax({
                "url": "/model/pla/relatorios/val_proj_ati_ppa/request.php",
                "dataType": 'json',
                "data": {
                    acao: "pesquisa",
                    dados: Dados
                },
                "success": function (response) {                                                 
                    func.carregaTabelaPadraoFoot('tabela', response.msg[0], response.msg[1], [], true);
                }
            });
                                   
        }
    });
           
           
   
       
});
