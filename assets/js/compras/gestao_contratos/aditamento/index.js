
$(document).ready(function () {       
    
    //instacinado fucoes js
    func = new Funcoes();
    
    

    
    $('.data').mask("99/99/9999")
    $("body").on("focus", "#n_valor_aditivo", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
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
            
            console.log(select);
        }
    });

    $('body').on('keypress', '#codItemPesquisa', function (e) {
        var key = e.which;
        if (key == 13) {
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
        $("#id_contrato").val("R$ "+contrato.id_contrato);
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
    
        
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);            
            var arrayDados = {
                'dados' : {
                    
                },
                'gestor_titular' :{
                    
                }
            }
            
            $(".n_gestor_titular option:selected").each(function(){
                console.log($(this).val());
                arrayDados.gestor_titular.push($(this).val())
            });
            console.log(arrayDados)
            
            
            $("select[name=subFiscais\\[\\]]").each(function () {
                //subFiscais.push($(this).val());
            });
        }
    });
  

});
