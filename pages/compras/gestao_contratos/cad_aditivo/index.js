
$(document).ready(function () {      
    
    //instacinado fucoes js
    func = new Funcoes();
    var url = "request.php";

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
    
    $("body").on("focus", "#n_indice_correcao", function () {
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
        "url": url,
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
                let qtd = parseInt($(".aditivo_quantidade").attr('quantidade'))+1;            
                $("#n_numero_aditivo").val(qtd+"º Termo Aditivo ao contrato "+$("#con_contrato").find("p").text());
                $("#numero_novo_aditivo").val(qtd);
                $("#panel-novo-atitivo").show();
            }            
        }
    });
    
    $('body').on('click', '.add-pessoa', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();                        
            let $this = $(this);            
            
            let select = $this.closest(".input-group").clone();
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
            let $this = $(this);            
            $this.closest(".input-group").remove();
        }
    });

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
    //função para pesquisa licitacao do gcon
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
                "acao": "pesquisaContrato",
                "dados": dados
            },
            "success": function (response) {                
                func.carregaTabelaPadrao('tabelaItens', response, [], true);
            }
        });
    });

    $('body').on('click', '.selecionaItem', function (e) {        
        let contrato = $(this).data('contrato');        
        preencheCamposContrato(contrato);                                       
        $('#modalItem').modal('hide');
        //Busca se esse Contrato possui Aditivo
        buscaExisteAditivos(contrato.id_contrato); 
        buscaItensDoContrato(contrato.id_contrato);
        buscaGestoresDoContrato();
        $("#panel-novo-atitivo").hide();
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
        if(contrato.fl_servico_continuado == "S"){
            $("#con_servico").find("p").html("Serviço Continuado");
        }else{
            $("#con_servico").find("p").html("Serviço Não Continuado");
        }                
    }
    
    function buscaExisteAditivos(idContrato){        
        $.ajax({
            "url": url,
            "dataType": 'html',
            "method": "get",
            "data": {
                "acao": "retornaAditivosDoContrato",
                "dados": idContrato
            },
            "success": function (response) {
                $("#panel-aditivos").find('.panel-body').html(response);  
                if($(".aditivo_quantidade").attr('quantidade') > 0){
                    $(".btn-historico-itens").show();
                }                
            }
        });
    }
    
    function buscaItensDoContrato(){        
        $.ajax({
            "url": url,
            "dataType": 'html',
            "method": "get",
            "data": {
                "acao": "pesquisaItens",
                "id": $("#id_contrato").val()
            },
            "success": function (response) {                                                     
                $("#tabelaFu").find('tbody').html(response);
            }
        });  
    }
    
    function buscaGestoresDoContrato(){     
        $.ajax({
            "url": url,
            "dataType": 'json',
            "method": "get",
            "data": {
                "acao": "retornaGestoresDoContrato",
                "id": $("#id_contrato").val()
            },
            "success": function (response) {                                                     
                if(response.tipoMsg == "ok"){
                    let dados = response.msg
                    alimentaComboBoxGestores(dados);                                                            
                }
            },            
            "error": function(response){
                console.log(response.responseText)
            }                        
        });  
    }
    
    
    
    
    //========================================================================================================
    
        
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();                        
            var $this = $(this);              
            $this.prop("disabled", true);
            
            var arrayDados = {
                dados : '',
                itens: new Array(),
                gestor_titular : new Array(),
                gestor_substituto : new Array(),
                fiscal : new Array(),
                fiscal_substituto : new Array(),
                sub_fiscal : new Array(),
                sub_fiscal_substituto : new Array()
            }
            
            var itens = [];
            
            $(".qtd_aditivo").each(function(){    
                var valor_informado = func.converteValorIngFloat($(this).val());                  
                if( !(valor_informado == 0 || isNaN(valor_informado) ) ){
                    itens.push({
                        id: $(this).closest("tr").data("id"),
                        valor_aditivado : valor_informado
                    })                    
                }
            });
            
            arrayDados['itens'] = itens;
          
            arrayDados['dados'] = {
                contrato: $("#id_contrato").val(),
                numero_novo_aditivo: $("#numero_novo_aditivo").val(),
                motivo : $("#motivo").val(),
                finalidade: $("#n_finalidade option:selected").val(),
                instrumento: $("#n_instrumento option:selected").val(),
                unidade_calculo: $("#n_unidade_calculo").val(),
                base_calculo: $("#n_base_calculo option:selected").val(),
                tipo_aquisicao: $("#n_tipo_aquisicao option:selected").val(),
                percentual: $("#n_percentual").val(),
                indice_correcao: $("#n_indice_correcao").val(),
                periodo_inicial: $("#n_periodo_inicial").val(),
                periodo_final: $("#n_periodo_final").val(),
                data_publicacao: $("#n_data_publicacao").val(),
                data_vigencia_inicial: $("#n_vigencia_inicial").val(),
                data_vigencia_final: $("#n_vigencia_final").val(),
                data_assinatura : $("#n_data_assinatura").val(),
                justificativa: $("#n_justificativa").val()
            };          
                  
            $(".n_gestor_titular option:selected").each(function(){                
                if($(this).val() != 0){
                    arrayDados.gestor_titular.push($(this).val())
                }
            });
            $(".n_gestor_sub option:selected").each(function(){                
                if($(this).val() != 0){
                    arrayDados.gestor_substituto.push($(this).val())
                }
            });            
            $(".n_fiscal option:selected").each(function(){                
                if($(this).val() != 0){
                    arrayDados.fiscal.push($(this).val())
                }
            });
            $(".n_fiscal_sub option:selected").each(function(){                
                if($(this).val() != 0){
                    arrayDados.fiscal_substituto.push($(this).val())
                }
            });
            $(".n_sub_fiscal option:selected").each(function(){                
                if($(this).val() != 0){
                    arrayDados.sub_fiscal.push($(this).val())
                }
            });
            $(".n_sub_fiscal_sub option:selected").each(function(){                
                if($(this).val() != 0){
                    arrayDados.sub_fiscal_substituto.push($(this).val())
                }
            });                                                                        
            
            $.ajax({
                "url": url,
                "dataType": "html",
                "method": "post",
                "data": {
                    "acao": "salvar",
                    "dados": arrayDados
                },
                "success": function (response) {
                    
                    if (response.trim() === "SessaoExpirada") {
                        func.modalAlert(func.msgSemPermissao);
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            top.location = "/pages/index.php";
                        });
                        return false;
                    }
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        console.log(response);
                        return false;
                    }
                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
                            console.log(response);
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        func.modalAlert(response.msg, 'success');
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            location.reload();
                        });
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    }
                },
                "error": function (response) {
                    $this.prop("disabled", false);
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }
            });
            $this.prop("disabled", false);                                               
        }
    });
    
    
    $('body').on('click', '.btn-remover', function (e) {

        var $this = $(this);
        var id = $this.val();
        var item = $this.closest('td').find('.btn-edit').attr("nome");

        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem Certeza que deseja continuar com a Exclusão do Item <span class="text-danger">' + item + '</span>?',
            buttons: {
                'cancel': {
                    label: 'Não',
                    className: 'btn-default btn-rounded'
                },
                'confirm': {
                    label: 'Sim',
                    className: 'btn-primary btn-rounded'
                }
            },
            callback: function (result) {
                if (result) {
                    var Dados = {
                        id: id
                    }

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    
                    $.ajax({
                        "url": url,
                        "dataType": "html",
                        "method": "post",
                        "data": {
                            "acao": "removerAditivo",
                            "dados": Dados
                        },
                        "success": function (response) {
                                                        
                            if (response.trim() == "SessaoExpirada") {
                                func.modalAlert(func.msgSemPermissao);
                                return false;
                            }

                            try {
                                response = JSON.parse(response);
                            } catch (e) {
                                func.modalAlert(func.msgErroPadrao);                                
                                return false;
                            }

                            if (response.tipoMsg === "Erro") {
                                if (response.tipoExibicao === "console") {                                    
                                    func.modalAlert(func.msgErroPadrao);
                                    return false;
                                } else if (response.tipoExibicao === "alert") {
                                    func.modalAlert(response.msg);
                                    return false;
                                }
                            } else if (response.tipoMsg === "ok") {
                                func.modalAlert(response.msg, 'success');
                                $('.modal-alert').on('hidden.bs.modal', function (e){
                                    location.reload();
                                });
                                return false;
                            } else {                                
                                func.modalAlert(func.msgErroPadrao);
                                return false;
                            }
                        },
                        "error": function (response) {                            
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        }
                    });
                }
            }
        });
    });
    
    
    
    
    $('body').on('click', '.btn-open-modal', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);          
            $.ajax({
                "url": url,
                "dataType": 'html',
                "method": "get",
                "data": {
                    "acao": "buscaInformacoesAditivo",
                    "id": $this.val()
                },
                "success": function (response) {       
                    //console.log(response)
                    $("#modalDetalhes").find('.modal-body').html(response);
                    $("#modalDetalhes").modal('show')
                }
            });                                                 
        }
    });
    
    
    $('body').on('click', '.btn-historico-itens', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);          
            $.ajax({
                "url": url,
                "dataType": 'html',
                "method": "get",
                "data": {
                    "acao": "buscaHistoricoDosItens",
                    "id": $("#id_contrato").val()
                },
                "success": function (response) {       
                    //console.log(response)
                    $("#modalDetalhes").find('.modal-body').html(response);
                    $("#modalDetalhes").modal('show')
                }
            });                                                 
        }
    });
    
    
    
    
    
    
    
    
    //================================================================================================================
          
    
    //Controle da Tela, Campos habilitados ou não
    //O Campo Percentual, ficará escondido até que a Regra para o tipo dele seja selecionado pelo usuário
    $("#div_percentual").hide();
    $("#div_indice_correcao").hide();      
    $('#n_unidade_calculo option').filter(function() {      
        return $(this).val() != 0;
    }).attr("disabled", "");
    $("#div_periodo_inicial").hide();
    $("#div_periodo_final").hide();
    
    
    if($("#motivo").val() == 1){
       $("#div_vigencia_inicial").hide();
        $("#div_vigencia_final").hide(); 
    }
    
    if($("#motivo").val() == 2){
        $("#div_finalidade").hide();
        $("#div_instrumento").hide();
        $("#div_base_calculo").hide();
        $("#div_unidade_calculo").hide();
        $("#div_tipo_aquisicao").hide();
        $("#div_indice_correcao").hide();
        $("#div_percentual").hide();
        $("#div_valor_aditivo").hide();
        $("#div_periodo_inicial").hide();
        $("#div_periodo_final").hide();                    
    }
    
    
    $('body').on('change', '#n_instrumento', function (e) {
                
        $('#n_base_calculo').val(0).trigger('change');                        
        $("#div_periodo_inicial").hide();
        $("#div_periodo_final").hide();
        
        //Tipo de Aquisição somente será habilitado se o Instrumento de Equilibrio
        //For Revisão
        $("#n_tipo_aquisicao").val(0).attr("disabled", "");
        if($("#n_instrumento option:selected").val() == 1){
            $("#n_tipo_aquisicao").removeAttr("disabled");
            //Quando o Instrumento for Reajuste, então deverá ser habilitado os campos de Periodo Inicial e Final
        }else if($("#n_instrumento option:selected").val() == 2){
            $("#div_periodo_inicial").show();
            $("#div_periodo_final").show();
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
        //$("#btn_itens_abrir_modal").hide();
        //Sempre que a Base de Calculo for Valor Unitario, então irá habilitar o Botão Itens ao lado do Valor Aditivo
        //if($("#n_base_calculo option:selected").val() == 2){
            //$("#btn_itens_abrir_modal").show();
        //} 
        $("#n_unidade_calculo").trigger('change');
    });
        
    $('body').on('change', '#n_unidade_calculo', function (e){
        $("#div_percentual").hide();
        $("#n_percentual").val("");
        $("#div_indice_correcao").hide();
        $("#n_indice_correcao").val("");
        zerarDadosItensEValor();
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
        //Os Campos para serem digitados ficaram readonly
        //Somente se unidade de cálculo for Moeda ou Quantidade que 
        //irá habilitar o campo para ser preenchido pelo usuário
        $('.qtd_aditivo').prop('readonly', true);
        if($("#n_unidade_calculo option:selected").val() == 3
                || $("#n_unidade_calculo option:selected").val() == 4){
            $('.qtd_aditivo').prop('readonly', false);
        }
    });
    
    
  
    
    $('body').on('change', '#n_finalidade', function (e) {
       //Se a Finalidade for Adição, teremos que fazer alguma Verificação com relação ao máximo de percentual
       if($("#n_finalidade option:selected").val() == 1
               && ( $("#n_unidade_calculo option:selected").val() == 1
                    || $("#n_unidade_calculo option:selected").val() == 4 
                    ) 
            ){
            let valor = $("#n_percentual").val().replace(",", ".");
            //Se Tipo de Aquisicao for Obras, Serviços ou Compras, o Valor Percentual máximo será de 25%
            if($("#n_tipo_aquisicao option:selected").val() == 1){
                if(valor > 25.0000){          
                    $("#n_percentual").val("25,0000").change();
                }
            }
            //Se Tipo de Aquisicao for Reforma de Edifício, o Valor Percentual máximo será de 50%
            if($("#n_tipo_aquisicao option:selected").val() == 2){
                if(valor > 50.0000){                  
                    $("#n_percentual").val("50,0000").change();
                }
            }            
        }
    });
    
    //Sempre que a Aquisicao for modificada, teremos que ver a Regra para a finalidade, por causa do percentual
    $('body').on('change', '#n_tipo_aquisicao', function (e) {
        $("#n_finalidade").trigger("change");
    });
    //Percentual sempre leva em consideração a regra da finalidade
    //para calcular os Valores quando ele informar no Campo
    $("body").on("change keydown keyup", "#n_percentual", function (){        
        $("#n_finalidade").trigger("change");
        calculoPercentualDosItens($(this));
    });
    //Indice de Correção, para calcular os Valores quando ele informar no Campo
    $("body").on("change keydown keyup", "#n_indice_correcao", function (){                
        calculoPercentualDosItens($(this));
    });        
    
    $('body').on('click', '#btn_itens_abrir_modal', function (e){
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();    
            
            if($("#n_unidade_calculo").val() == 0){
                func.modalAlert("É Necessário Escolher uma Unidade de Cálculo.");
                return false;
            }           
            
            if($("#n_instrumento option:selected").val() == 1 
                    && $("#n_tipo_aquisicao option:selected").val() == 0){
                func.modalAlert("É Necessário Escolher um Tipo de Aquisição.");
                return false;
            }
            
            //Quando a unidade de cálculo for Moeda ou Indice de Correção
            //Então o usuário deverá informar o Valor Unitário Aditivada
            if($("#n_unidade_calculo").val() == 3 || $("#n_unidade_calculo").val() == 2){
                $(".label-aditivo").text("Valor Unit. Aditivado");
            //Se por acaso for Quantidade ou Percentual, então deverá ser informado a Quantidade Aditivada
            }else if($("#n_unidade_calculo").val() == 4 || $("#n_unidade_calculo").val() == 1){
                $(".label-aditivo").text("Qtd. Aditivada");
            }else{
                $(".label-aditivo").text("Sem Opção de Texto");
            }            
            $("#myModalFu").modal('show');                                                                      
        }
    });
    
  
       
    
    //Calculo da Tabela dos Itens
    function calculaValorTotal(elemento){
        let valor = "0";
        let qtd = "0"; 
        //Quando a unidade de cálculo for Moeda
        //Então iremos calcular pegando a Quantidade X Valor Informado pelo usuário 
        if($("#n_unidade_calculo").val() == 3 || $("#n_unidade_calculo").val() == 2){
            valor = $(elemento).closest("tr").find(".qtd_aditivo").val();
            qtd = $(elemento).closest("tr").find(".td_quantidade").text();
        //Quando a unidade de cálculo for Quantidade
        //Então iremos calcular pegando o Valor Unitário X Quantidade Informado pelo usuário 
        }else if($("#n_unidade_calculo").val() == 4 || $("#n_unidade_calculo").val() == 1){
            valor = $(elemento).closest("tr").find(".td_valor_unitario").text();
            qtd = $(elemento).closest("tr").find(".qtd_aditivo").val();
        }else{
            
        }
       
        valor = func.converteValorIngFloat(valor);   
        qtd = func.converteValorIngFloat(qtd);       

        $(elemento).closest("tr").find(".td_total").text(func.arrendondaValorParaQuatroCasas(qtd*valor));
        $(elemento).closest("tr").find(".td_total").priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
            centsLimit: 4
        });
    }     
    
    
       
    
    //Quando a Unidade de Cálculo for Percentual ou Indice de Correção
    //Os Itens serão calculados de acordo com os Dados da % fornecida pelo usuario
    function calculoPercentualDosItens(elemento){
        let percentual = func.converteValorIngFloat($(elemento).val());
        let valorAditivo = 0;
        if($("#n_unidade_calculo option:selected").val() == 1){
            $(".td_quantidade").each(function(index){         
                let quantidade = func.converteValorIngFloat($(this).text());           
                valorAditivo = quantidade * (percentual/100);               
                $(this).closest('tr').find('.qtd_aditivo').val(func.arrendondaValorParaQuatroCasas(valorAditivo));                
                $(this).closest('tr').find('.qtd_aditivo').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.',
                    centsLimit: 4
                });           
                
                calculaValorTotal($(this).closest('tr').find('.qtd_aditivo'));            
            });
        }else if($("#n_unidade_calculo option:selected").val() == 2){
            $(".td_valor_unitario").each(function(index){         
                let quantidade = func.converteValorIngFloat($(this).text());           
                valorAditivo = quantidade * (percentual/100);
                $(this).closest('tr').find('.qtd_aditivo').val(func.arrendondaValorParaQuatroCasas(valorAditivo));
                $(this).closest('tr').find('.qtd_aditivo').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.',
                    centsLimit: 4
                }); 
                calculaValorTotal($(this).closest('tr').find('.qtd_aditivo'));            
            });
        }
        calculoValorAditivo();        
    }    
    $('body').on('keyup', '.qtd_aditivo', function(){
        calculaValorTotal(this);
    });      
  
    //Calculo do Valor do Aditivo
    function calculoValorAditivo(){
        let valorAditivo = 0;
        $(".td_total").each(function(index){            
            let valorInformado = func.converteValorIngFloat($(this).text());            
            valorAditivo = valorAditivo + valorInformado;
        });
        $("#n_valor_aditivo").val(func.arrendondaValorParaQuatroCasas(valorAditivo));
        $("#n_valor_aditivo").priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
            centsLimit: 4
        });        
    }
   
    $('#myModalFu').on('hidden.bs.modal', function (e) {
        calculoValorAditivo();         
    });
  
  
    function zerarDadosItensEValor(){
        $(".qtd_aditivo").val("0,0000");
        $(".td_total").text("0,0000");
        $("#n_valor_aditivo").val("0,0000");        
    }
  
  
    
    function alimentaComboBoxGestores(dados){
        let l = dados.length;        
        var quantidadePorTipo = {
            n_gestor_titular: {'quantidade': 0, 'itens': new Array()  },
            n_gestor_sub: {'quantidade': 0, 'itens': new Array()  },
            n_fiscal: {'quantidade': 0, 'itens': new Array()  },
            n_fiscal_sub: {'quantidade': 0, 'itens': new Array()  },
            n_sub_fiscal: {'quantidade': 0, 'itens': new Array()  },
            n_sub_fiscal_sub: {'quantidade': 0, 'itens': new Array()  }
            
        }
        
        for (var i = 0; i < l; i++) {
            if(dados[i]['tabela'] == "gestor" 
                    && dados[i]['tipo'] == '1'){
                quantidadePorTipo.n_gestor_titular.quantidade += 1; 
                quantidadePorTipo.n_gestor_titular.itens.push(dados[i]['id_pessoa'])
                continue;
            }
            if(dados[i]['tabela'] == "gestor" 
                    && dados[i]['tipo'] == '2'){
                quantidadePorTipo.n_gestor_sub.quantidade += 1;
                quantidadePorTipo.n_gestor_sub.itens.push(dados[i]['id_pessoa'])
                continue;
            }
            if(dados[i]['tabela'] == "fiscal" 
                    && dados[i]['tipo'] == '1'){
                quantidadePorTipo.n_fiscal.quantidade += 1; 
                quantidadePorTipo.n_fiscal.itens.push(dados[i]['id_pessoa'])
                continue;
            }
            if(dados[i]['tabela'] == "fiscal" 
                    && dados[i]['tipo'] == '2'){
                quantidadePorTipo.n_fiscal_sub.quantidade += 1;
                quantidadePorTipo.n_fiscal_sub.itens.push(dados[i]['id_pessoa'])
                continue;
            }
            if(dados[i]['tabela'] == "sub_fiscal" 
                    && dados[i]['tipo'] == '1'){
                quantidadePorTipo.n_sub_fiscal.quantidade += 1; 
                quantidadePorTipo.n_sub_fiscal.itens.push(dados[i]['id_pessoa'])
                continue;
            }
            if(dados[i]['tabela'] == "sub_fiscal" 
                    && dados[i]['tipo'] == '2'){
                quantidadePorTipo.n_sub_fiscal_sub.quantidade += 1;
                quantidadePorTipo.n_sub_fiscal_sub.itens.push(dados[i]['id_pessoa'])
                continue;
            }
        }                
        //Adiciona a quantidade de Selects necessários para os elementos, gestores.
        for (x in quantidadePorTipo) {         
            for (var i = 0, max = quantidadePorTipo[x].quantidade; i < max; i++) {                                 
                if(i != 0) {
                    $("."+x).closest(".input-group").find('.add-pessoa').trigger('click');
                }                                
            }                        
        }
        //Alimenta os Val dos campos
        for (x in quantidadePorTipo) {
            for (var i = 0, max = quantidadePorTipo[x].quantidade; i < max; i++) {                  
                if(i == 0){
                    $('.'+x).val(quantidadePorTipo[x].itens[0]).trigger('change');                    
                    continue;
                }                
                if(i != 0) {
                    $("."+x).filter(function(index) {      
                        return index == i;                    
                    }).val(quantidadePorTipo[x].itens[i]).trigger('change');
                }                                
            } 
        }                             
    }
  
  
  
  
  
  
  
  
  
  
  
  /*** TESTE ***/
  
        $.ajax({
            "url": url,
            "dataType": 'html',
            "data": {
                "acao": "pesquisaContrato",
                "dados": '261'
            },
            "success": function (response) {                
                func.carregaTabelaPadrao('tabelaItens', response, [], true);
                $(".selecionaItem").first().trigger('click');
                //$(".btn-add-aditivo").trigger('click');  
                //carregaDadosEdicao();                
            }            
        });  

        function carregaDadosEdicao(){
            $("#n_finalidade").val(1).change();
            $("#n_instrumento").val(1).change();
            $("#n_base_calculo").val(1).change();
            $("#n_unidade_calculo").val(1).change();
            $("#n_tipo_aquisicao").val(1).change();
            $("#numero_novo_aditivo").val(1);
            $("#n_data_publicacao").val("01/01/2019");
            $("#n_data_assinatura").val("02/02/2019");
            $('.select_funcionarios').val(1).trigger('change');
            
            $(".add-pessoa").trigger('click');
            $('.select_funcionarios').val(1).trigger('change');
            $("#n_justificativa").val("Justificação");
            
        }

});
