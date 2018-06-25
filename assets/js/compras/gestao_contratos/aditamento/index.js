
$(document).ready(function () {       
    
    //instacinado fucoes js
    func = new Funcoes();
    /*
    var arrayDados = {
        'dados' : new Array(),
        'gestor_titular' : new Array()
    }
    var teste = new Array();
    teste.push(1)
    teste.push(2)
    console.log(teste)    
    arrayDados.dados['nome'] = 'Marcel';
    arrayDados.dados['sobrenome'] = 'Melo';
    arrayDados['teste'] = ({id:100,nome:'fff',idade:30});
    arrayDados.gestor_titular.push(1);
    arrayDados.gestor_titular.push(2);
    arrayDados.gestor_titular.push(2323);        
    console.log(arrayDados.gestor_titular)    
    console.log(arrayDados)
*/
    
    $('.data').mask("99/99/9999")
    $("body").on("focus", ".quatro_casas", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',            
        });
    });
    
    $("body").on("focus", "#n_percentual", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',            
            centsSeparator: ',',
            thousandsSeparator: '.',
            limit: 7
        });
    });
        
    
    
    $(".select").select2({
        width: " 100%"
    });    
    $(".select_funcionarios").select2();  

    //Carrega Gestores, Fiscais, Sub-Fiscais
    $.ajax({
        "url": "/model/compras/gestaoContratos/aditamento/request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaOptionsGestores"
        },
        "success": function (response) {
            $("body").find(".select_funcionarios").html(response);
        }
    });
    //fim
    //Página terá o Panel de Novo aditivo escondido até ser clicar no botão "Adicionar Aditivo"
    $("#panel-novo-atitivo").hide();
    
    $('body').on('click', '.btn-add-aditivo', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            if($("#id_contrato").val() != 0){
                var qtd = parseInt($(".aditivo_quantidade").attr('quantidade')+1);
                //$numeroAditivo = $sequencialUltimoAditivo."º Termo Aditivo ao Contrato ".$contrato;
                $("#n_numero_aditivo").val(qtd+"º Termo Aditivo ao contrato "+$("#con_contrato").find("p").text());
                $("#panel-novo-atitivo").show();
            }            
        }
    });
    
    $('body').on('click', '.add-pessoa', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);            
            
            var select = $this.closest(".input-group").clone();
            select.find(".add-pessoa").find('i').addClass('fa-minus-circle').removeClass('fa-plus-circle');
            select.find(".add-pessoa").addClass('remove-pessoa btn-danger').removeClass('add-pessoa btn-primary');            
            select.css("margin-top", "5px");
            $this.closest(".input-group").after(select);
            $this.closest(".col-sm-6").find('.remove-pessoa').first().closest('.input-group').find('.select2-selection--single').remove();
            $this.closest(".col-sm-6").find('.remove-pessoa').first().closest('.input-group').find('.select2-container').remove();           
            $this.closest(".col-sm-6").find('.remove-pessoa').first().closest('.input-group').find('.select_funcionarios').select2({width: "100%"});            
                        
        }
    });
    
    $('body').on('click', '.remove-pessoa', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();                        
            var $this = $(this);            
            $this.closest(".input-group").remove();
        }
    });

    $('body').on('keypress', '#codItemPesquisa', function (e) {
        var key = e.which;
        if (key == 13){
            $("#btn-pesquisa").trigger('click');
            return false;
        }
    });

    //busca produtos
    $('#modalItem').on('shown.bs.modal', function () {
        $('#codItemPesquisa').focus();
    });
    //função para pesquisa licitacao do gcon
    $('body').on('click', '#btn-pesquisa', function (e) {
        var dados = $("#codItemPesquisa").val();
        if (dados == "" || dados.length < 2 || dados == " ") {
            alert("Pesquisa do Item precisa ter no mínimo 2 caracteres");
            return;
        }
        $.ajax({
            "url": "/model/compras/gestaoContratos/aditamento/request.php",
            "dataType": 'html',
            "data": {
                "acao": "pesquisaContrato",
                "dados": dados
            },
            "success": function (response) {                
                func.carregaTabelaPadrao('tabelaItens', response, [], true);
            }
        });
    });

    $('body').on('click', '.selecionaItem', function (e) {        
        var contrato = $(this).data('contrato');        
        preencheCamposContrato(contrato);                                       
        $('#modalItem').modal('hide');
        //Busca se esse Contrato possui Aditivo
        buscaExisteAditivos(contrato.id_contrato); 
        buscaItensDoContrato(contrato.id_contrato);
    });
    
    function preencheCamposContrato(contrato){
        $("#con_contrato").find("p").html(contrato.nr_contrato);
        $("#con_licitacao").find("p").html(contrato.cd_pregao);
        $("#con_tipo_gasto").find("p").html(contrato.nm_tipo_gasto);
        $("#con_objeto").find("p").html(contrato.nm_objeto);
        $("#con_modalidade").find("p").html(contrato.nm_modalidade);
        $("#con_assinatura").find("p").html(contrato.dt_assinatura);
        $("#con_publicacao").find("p").html(contrato.dt_publicacao);
        $("#con_vigencia").find("p").html(contrato.dt_ini_vigencia_contrato+ " - "+contrato.dt_fim_vigencia_contrato);
        $("#con_descricao_objeto").find("p").html(contrato.ds_objeto);
        $("#con_fornecedor").find("p").html(contrato.nm_pessoa);
        $("#con_valor").find("p").html(contrato.valor);
        $("#id_contrato").val(contrato.id_contrato);
    }
    
    function buscaExisteAditivos(idContrato){        
        $.ajax({
            "url": "/model/compras/gestaoContratos/aditamento/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaAditivosDoContrato",
                "dados": idContrato
            },
            "success": function (response) {
                $("#panel-aditivos").find('.panel-body').html(response);                        
            }
        });
    }
    
    function buscaItensDoContrato(){        
        $.ajax({
            "url": "/model/compras/gestaoContratos/aditamento/request.php",
            "dataType": 'html',
            "data": {
                "acao": "pesquisaItens",
                "id": $("#id_contrato").val()
            },
            "success": function (response) {                                                     
                $("#tabelaFu").find('tbody').html(response);
            }
        });  
    }
    
        
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();                        
            var $this = $(this);          
            var arrayDados = {
                dados : new Array(),
                gestor_titular : new Array(),
                gestor_substituto : new Array(),
                fiscal : new Array(),
                fiscal_substituto : new Array(),
                fiscal_sub : new Array(),
                fiscal_sub_substituto : new Array()
            }
            
          
//            arrayDados.dados['nome'] = 'Marcel';
//            arrayDados.dados['sobrenome'] = 'Melo';
//            arrayDados['teste'] = ({id:100,nome:'fff',idade:30});
//            arrayDados.gestor_titular.push(1);
//            arrayDados.gestor_titular.push(2);
//            arrayDados.gestor_titular.push(2323);        
//            console.log(arrayDados.gestor_titular)    
//            console.log(arrayDados)
//            
            $(".n_gestor_titular option:selected").each(function(){                
                if($(this).val() != 0){
                    arrayDados.gestor_titular.push($(this).val())
                }
            });
            console.log(arrayDados)
            
            
            $("select[name=subFiscais\\[\\]]").each(function () {
                //subFiscais.push($(this).val());
            });
        }
    });
    
          
    
    //Controle da Tela, Campos habilitados ou não
    //O Campo Percentual, ficará escondido até que a Regra para o tipo dele seja selecionado pelo usuário
    $("#div_percentual").hide();
    $("#div_indice_correcao").hide();
    $("#btn_itens_abrir_modal").hide();
    
    $('body').on('change', '#n_instrumento', function (e) {
                
        $('#n_base_calculo').val(0).trigger('change');                        
        
        //Tipo de Aquisição somente será habilitado se o Instrumento de Equilibrio
        //For Revisão
        $("#n_tipo_aquisicao").val(0).attr("disabled", "");
        if($("#n_instrumento option:selected").val() == 1){
            $("#n_tipo_aquisicao").removeAttr("disabled");
        }     
    });
    
    
    $('body').on('change', '#n_base_calculo', function (e) {
        
        //Regras para a Unidade de Cálculo
        $('#n_unidade_calculo option').filter(function() {      
            return $(this).val() != 0;
        }).attr("disabled", "");
        $('#n_unidade_calculo').val(0).trigger('change');
        
        //Se o Instrumento for Revisão
        if($("#n_instrumento option:selected").val() == 1){
            //Se a Base de Cálculo For Global 
            //Somente será liberado Unidade de Calculo Percentual            
            if($("#n_base_calculo option:selected").val() == 1){
                $('#n_unidade_calculo option[value=1]').removeAttr("disabled");

            //Se a Base de Cálculo For Unitário 
            //Somente será liberado Unidade de Calculo Moeda e Quantidade            
            }else if($("#n_base_calculo option:selected").val() == 2){
                $('#n_unidade_calculo option[value=3]').removeAttr("disabled");
                $('#n_unidade_calculo option[value=4]').removeAttr("disabled");
            }                         
        //Se o Instrumento for Reajuste
        }else if($("#n_instrumento option:selected").val() == 2){
            //Se a Base de Cálculo for Global
            //somente será liberado Unidade de Cálculo Índice de Correção
            if($("#n_base_calculo option:selected").val() == 1){
                $('#n_unidade_calculo option[value=2]').removeAttr("disabled");
            //Se a Base de Cálculo For Unitário 
            //Somente será liberado Unidade de Calculo Moeda
            }else if($("#n_base_calculo option:selected").val() == 2){
                $('#n_unidade_calculo option[value=3]').removeAttr("disabled");
            }
        }                                                                                    
        $("#btn_itens_abrir_modal").hide();
        //Sempre que a Base de Calculo for Valor Unitario, então irá habilitar o Botão Itens ao lado do Valor Aditivo
        if($("#n_base_calculo option:selected").val() == 2){
            $("#btn_itens_abrir_modal").show();
        } 
        $("#n_unidade_calculo").trigger('change');
    });
        
    $('body').on('change', '#n_unidade_calculo', function (e){
        $("#div_percentual").hide();
        $("#n_percentual").val("");
        $("#div_indice_correcao").hide();
        $("#n_indice_correcao").val("");
        //Se a Unidade de Calculo for Percentual e a Base de Cálculo for Global
        //Então o Campo Percentual deverá Aparecer
        if($("#n_unidade_calculo option:selected").val() == 1
                && $("#n_base_calculo option:selected").val() == 1 ){
            $("#div_percentual").show();
        } 
        //Se a Unidade de Calculo for Indice de Correção e a Base de Cálculo for Global
        //Então o Campo Indice de correção deverá Aparecer
        if($("#n_unidade_calculo option:selected").val() == 2
                && $("#n_base_calculo option:selected").val() == 1 ){
            $("#div_indice_correcao").show();
        } 
    });
    
    
  
    
    $('body').on('change', '#n_finalidade', function (e) {
       //Se a Finalidade for Adição, teremos que fazer alguma Verificação com relação ao máximo de percentual
       if($("#n_finalidade option:selected").val() == 1){
           var valor = $("#n_percentual").val().replace(",", ".");
           //Se Tipo de Aquisicao for Obras, Serviços ou Compras, o Valor Percentual máximo será de 25%
            if($("#n_tipo_aquisicao option:selected").val() == 1){
                if(valor > 25.0000){          
                    $("#n_percentual").val("25,0000");
                }
            }
            //Se Tipo de Aquisicao for Reforma de Edifício, o Valor Percentual máximo será de 50%
            if($("#n_tipo_aquisicao option:selected").val() == 2){
                if(valor > 50.0000){                  
                    $("#n_percentual").val("50,0000");
                }
            }            
        }
    });
    
    //Sempre que a Aquisicao for modificada, teremos que ver a Regra para a finalidade, por causa do percentual
    $('body').on('change', '#n_tipo_aquisicao', function (e) {
        $("#n_finalidade").trigger("change");
    });
    //Percentual sempre leva em consideração a regra da finalidade
    $("body").on("change keydown keyup", "#n_percentual", function (){        
        $("#n_finalidade").trigger("change");
    });
    
    //$("#n_base_calculo").val(2).change();
    
    $('body').on('click', '#btn_itens_abrir_modal', function (e){
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                
            if($("#n_unidade_calculo").val() != 3
                    && $("#n_unidade_calculo").val() != 4){
                func.modalAlert("É Necessário Escolher Uma Unidade de Cálculo Quantidade ou Moeda.");
                return false;
            }            
            if($("#n_unidade_calculo").val() == 0){
                func.modalAlert("É Necessário Escolher um Tipo de Aquisição.");
                return false;
            }               
            //Quando a unidade de cálculo for Moeda
            //Então o usuário deverá informar o Valor Unitário Aditivada
            if($("#n_unidade_calculo").val() == 3){
                $(".label-aditivo").text("Valor Unit. Aditivado");
            //Se por acaso for Quantidade, então deverá ser informado a Quantidade Aditivada
            }else if($("#n_unidade_calculo").val() == 4){
                $(".label-aditivo").text("Qtd. Aditivada");
            }else{
                $(".label-aditivo").text("Sem Opção de Texto");
            }            
            $("#myModalFu").modal('show');                                                                      
        }
    });
    
    
    
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  /*** TESTE ***/
  
        $.ajax({
            "url": "/model/compras/gestaoContratos/aditamento/request.php",
            "dataType": 'html',
            "data": {
                "acao": "pesquisaContrato",
                "dados": '261'
            },
            "success": function (response) {                
                func.carregaTabelaPadrao('tabelaItens', response, [], true);
                $(".selecionaItem").first().trigger('click');
                $(".btn-add-aditivo").trigger('click');                
            }            
        });  

});
