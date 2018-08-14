
$(document).ready(function () {      
                
    //instacinado fucoes js
    func = new Funcoes();
    var url = "request.php";
              
    $('body').on('keypress', '#codItemPesquisa', function (e) {
        let key = e.which;
        if (key == 13){
            $("#btn-pesquisa").trigger('click');
            return false;
        }
    });
    
    //busca produtos
    $('#modalItem').on('shown.bs.modal', function () {
        $('#codItemPesquisa').focus();
    });
    
    $('body').on('click', '#btn-pesquisa', function (e) {
        let dados = $("#codItemPesquisa").val();
        if (dados == "" || dados.length < 2 || dados == " ") {
            alert("Pesquisa do Item precisa ter no mínimo 2 caracteres");
            return;
        }
        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "pesquisaProduto",
                "dados": dados
            },
            "success": function (response) {                      
                func.carregaTabelaPadrao('tabelaItens', response, [], true);
            }
        });
    });

    $('body').on('click', '.selecionaItem', function (e){
        let item = $(this).data('item') 
        let info = $(this).data('info')        
        preencheCamposItem(info);                                       
        $('#modalItem').modal('hide');     
        buscaExisteContrato(info.id_material);        
    });
    
    function preencheCamposItem(item){            
        $("#item_codigo").find("p").html(item.cd_desc_material);
        $("#item_descricao").find("p").html(item.nm_desc_material);
        $("#item_item").find("p").html(item.nm_material);
        $("#item_grupo").find("p").html(item.nm_grupo);
        $("#item_sub_grupo").find("p").html(item.nm_sub_grupo);
        $("#item_tipo").find("p").html(item.tp_material);
        $("#item_elemento").find("p").html(item.cd_elemento_despesa);              
        
    }
    
    function buscaExisteContrato(idMaterial){        
        $.ajax({
            "url": url,
            "dataType": 'html',
            "method": "get",
            "data": {
                "acao": "retornaContratos",
                "dados": idMaterial
            },
            "success": function (response) {                 
                $("#informacoes").html(response);                  
            }
        });
    }
                        
   
    
    
  
  
  });
