$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    //Mascara do sistema
    $('#emissao').mask("99/99/9999");
    $('#atesto').mask("99/99/9999");
    
    $('#competencia').mask("99/9999");
    //busca pedido
    $('#modalItem').on('shown.bs.modal', function () {
        $('#codItemPesquisa').focus();
    });
    
    $('body').find('select').select2({
        width: '100%'
    });
    
    //Masca para valor
    $("body").on("focus", ".valorRetEntrega", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
        });
    });

        /**
         * retornaDadosOrdem
         */
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaOrdemGdof",
                "dados": $("body").find("#idPedido").val()

            },
            "success": function (response) {                
                $("#selectOrdem").html(response);
            }
        });

    $("body").on("change", "#selectOrdem", function (e) {
        var idOrdem = $("body").find("#selectOrdem").val();     
        if(idOrdem == 0){
            return false;
        }
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaTipoValorOrdem",
                "dados": idOrdem

            },
            "success": function (response) {
                var infoOrdem = JSON.parse(response);
                $("body").find("#tipoOrdem").html(infoOrdem.tipo);
                $("body").find("#valorOrdem").html(infoOrdem.valor);
            }
        });


    });

    var infTabOrdem = {};

    $("body").on("click", ".addOrdens", function (e) {
        if($("#selectOrdem option:selected").val() == 0){
            return false;
        }
        array = {
            "id_ordem": $("#selectOrdem option:selected").val(),
            "nr_ordem": $("#selectOrdem option:selected").text(),
            "tipo_ordem": $("#tipoOrdem").text(),
            "valorOrdem": $("#valorOrdem").text()
        }

        $.each(infTabOrdem, function (index, value) {
            if (value.id_ordem == $("#selectOrdem option:selected").val()) {
                func.modalAlert("Essa ordem já foi adicionada.");
            }
        });

        infTabOrdem[$("#selectOrdem option:selected").val()] = array;

        $.ajax({
            "method": "POST",
            "url": "request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaTabelaOrdem",
                "dados": infTabOrdem

            },
            "success": function (response) {
                $("#tabelaOrdem").find("tbody").html(response);
            }
        });
        retornaOptionsDaEntrega(infTabOrdem);
    });
    
    $(".tabOrdem").each(function(){
        array = {
            "id_ordem": $(this).attr('id'),
            "nr_ordem": $(this).find("td:eq(0)").text(),
            "tipo_ordem": $(this).find("td:eq(1)").text(),
            "valorOrdem": $(this).find("td:eq(2)").text(),
            "id_documento_fiscal" : $("#idPedido").val()
        }
        infTabOrdem[$(this).attr('id')] = array;        
    });
    retornaOptionsDaEntrega(infTabOrdem);        
    
    
    //retorna options entrega
    function retornaOptionsDaEntrega(infTabOrdem) {      
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaOptionsDaEntrega",
                "dados": infTabOrdem

            },
            "success": function (response) {
                $("#selectEntrega").html(response);
            }
        });
    }    
    //excluir ordem 
    $("body").on("click", ".excluirOrdem", function (e) {
        var $this = $(this);
        var erro = 0;
        //verificar ser tem entregas vinculadas pertencente a ordem excluida 
        $(".trEntregas").each(function () {
            if ($this.val() == $(this).attr("ordem")) {
                erro++;

            }
        });
        if (erro > 0) {
            func.modalAlert("Exclua as entregas para exluir a ordem");
            return false;
        }

        $("#" + $this.val()).remove();
        infTabOrdem = {};

        //esse codigo abaixo foi realizado para atualiza o select das entregas
        infNovaOrdem = {};
        $(".tabOrdem").each(function () {
            infNovaOrdem[$(this).attr("id")] = {"id_ordem": $(this).attr("id")}

        });
        //fim

        retornaOptionsDaEntrega(infNovaOrdem);

    });

//    var infTabEntrega = [];
//    $(".trEntregas").each(function(){
//        infTabEntrega.push($(this).attr('identrega'));       
//    });

    $("body").on("click", ".addEntrega", function (e) {   
        var entrega = $("#selectEntrega option:selected").val();
        var erro = false;
        
        if(!entrega){
            return false;
        }
        
        $(".trEntregas").each(function(){
            if (entrega == $(this).attr('identrega')) {
                func.modalAlert("Esta entrega já foi adicionada.");
                erro = true;
            } 
        });
        
        if (!erro) {
            var infTabEntrega = [];
        
            infTabEntrega.push(entrega);
            atualizaTabelaEntrega(infTabEntrega);
        }
        
    });


    function atualizaTabelaEntrega(infTabEntrega) {

        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaTabelaEntrega",
                "dados": infTabEntrega

            },
            "success": function (response) {
                $("#tabelaEntrega").find("tbody").append(response);
                calculaValorDocumento();
            }
        });
    }


    $("body").on("click", ".excluirEntrega", function (e) {
        var $this = $(this);
        $this.closest('tr').remove();
        calculaValorDocumento();
    });


    /*QUANDO CLICAR NO BOTAO NÃO ESCONDER OS CAMPOS DO NUMERO DO GRP*/

    $("body").on('click', '#grp_nao', function () {
        $(".divNumeroGrp").hide();
        $("#nr_grp").val("");
    });

    $("body").on('click', '#grp_sim', function () {
        $(".divNumeroGrp").show();
    });
    /****/
    $("body").on("click", ".btn-salvar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var entregas = [];

            $(".trEntregas").each(function (){
                
                var situacao = $(this).data('situacao');
                
                if(situacao){
                    //converte o valor informado para a entrega em formato inglês com 4 casas
                    var valor_entrega_ingles = func.converteValorIngFloat($(this).find("input[name=valorRetEntrega\\[\\]]").val());
                    valor_entrega_ingles = func.arrendondaValorParaQuatroCasas(valor_entrega_ingles);

                    //converte o valor do saldo para o formato inglês com 4 casas
                    var valor_saldo_ingles = $(this).data('saldo');
                    valor_saldo_ingles = func.arrendondaValorParaQuatroCasas(valor_saldo_ingles);

                    var entrega = {
                        id_entrega_documento: $(this).data("id"),
                        id_entrega_confirmacao: $(this).attr("identrega"),
                        vl_entrega_saldo: valor_saldo_ingles,
                        vl_entrega_documento: valor_entrega_ingles
                    }
                    entregas.push(entrega);
                }

            });
            
            if (entregas.length <= 0){
                $this.prop("disabled", false);
                func.modalAlert("Nenhuma entrega foi adicionada.");
                return false;
            }

            var grp = $('input[name=grp_cod]:checked').val();          
            
            var dados = {
                "documento_fiscal": $("#idPedido").val(),
                "processoAdm": $("#processoAdm").val(),
                "nr_documento": $("#nr_documento").val(),
                "tpDocumento": $("#tpDocumento option:selected").val(),
                "competencia": $("#competencia").val(),
                "emissao": $("#emissao").val(),
                "atesto": $("#atesto").val(),
                "valorDocumentoFiscal": $("#valorDocumentoFiscal").val(),
                "grp": grp,
                "grpNumero": $("#nr_grp").val(),
                "entregas": entregas
            }
            
            $.ajax({
                "url": "request.php",
                "method": "POST",
                "dataType": "html",
                "data": {
                    "acao": "editarDocumentoFiscal",
                    "dados": dados
//                    "entrega": entregas
                },
                "success": function (response) {
                    console.log(response);
                    $this.prop("disabled", false);
                    if (response.trim() == "SessaoExpirada") {
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
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
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    }
                },
                "error": function (response) {
                    $this.prop("disabled", false);
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            });
        }
    });

    //Script para atualizar o valor total do documento a medida que o usuário insere valores das entregas
    $("body").on("keyup", ".valorRetEntrega", function (e) {
        calculaValorDocumento();
    });
    
    function calculaValorDocumento() {
        let valoresRetirados = 0;
        $("input[name=valorRetEntrega\\[\\]]").each(function () {
            valoresRetirados = (parseFloat(func.tranformaStringEmValorCalculavel($(this).val())) + valoresRetirados);

            if (valoresRetirados > '999999999.9999') {
                func.modalAlert("Valor do documento fiscal ultrapassa o valor máximo permitido");
                $(this).prop("disabled", true);
                return false;
            }
        });




        let valorDocumentoFiscal = func.converteValorBrDecimal(valoresRetirados, 4);
        $("#valorDocumentoFiscal").val(valorDocumentoFiscal);
        $(".valorDocumentoTotal").text(valorDocumentoFiscal);
    }

});
