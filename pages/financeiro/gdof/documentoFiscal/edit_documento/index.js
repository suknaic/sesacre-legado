$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    //Mascara do sistema
    $('#vencimento').mask("99/99/9999");
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
    
    
    $("#valorDocumentoFiscal").priceFormat({
        centsLimit: 4,
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.',
    });
    

    /**
     * retornaDadosOrdem
     */

    $.ajax({
        "url": "request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaOrdemGdof",
            "dados": $("body").find("#id_pedido").val()

        },
        "success": function (response) {
            $("#selectOrdem").html(response);
            retornaOptionsDaEntrega();
        }
    });
    
    if($("#tipo_solicitacao").val() == 1){
        $("#panel-ordem").hide();
        $("#panel-entrega").hide();
        $("#valorDocumentoFiscal").prop("disabled", false)
    }


    $("body").on("click", ".addOrdens", function (e) {

        var id_ordem = $("#selectOrdem option:selected").val();

        //verifica se a ordem já está incluída
        $(".linha-ordem").each(function () {
            var linha = $(this);

            if (linha.data('id') == id_ordem) {
                func.modalAlert("Essa ordem já foi adicionada.");
                id_ordem = 0;
                return false
            }

        });

        if (id_ordem == 0) {
            return false;
        }


        $.ajax({
            "url": "/pages/financeiro/gdof/documentoFiscal/edit_documento/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaTipoValorOrdem",
                "dados": id_ordem

            },
            "success": function (response) {
                var ordem = JSON.parse(response);
                var trOrdem = `<tr class="linha-ordem" data-id=${ordem.id_ordem}>
                                    <td class="text-center">${ordem.ordem}</td>
                                    <td class="text-center">${ordem.tipo}</td>
                                    <td class="text-center">${ordem.valor}</td>
                                    <td class="text-center">${ordem.situacao}</td>
                                    <td class="text-center">
                                        <button type="button" title="Excluir ordem" class="excluirOrdem text-danger" value = "${ordem.id_ordem}">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </td>
                               </tr>`;
                $("#tabelaOrdem").find("tbody").append(trOrdem);
                retornaOptionsDaEntrega();
            }
        });
    });

     


    //retorna options entrega
    function retornaOptionsDaEntrega() {

        var ordens = [];
        //percorre as ordens inseridas
        $(".linha-ordem").each(function () {
            ordens.push($(this).data('id'));
        });

        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaOptionsDaEntrega",
                "dados": ordens

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

        $this.closest('tr').remove();

        retornaOptionsDaEntrega();

    });


    $("body").on("click", ".addEntrega", function (e) {

        var dados = {
            entrega: $("#selectEntrega option:selected").val(),
            documento: $("#idDocumentoFiscal").val(),
        }

        var erro = false;

        if (!dados.entrega) {
            return false;
        }

        $(".trEntregas").each(function () {
            if (dados.entrega == $(this).attr('identrega')) {
                func.modalAlert("Esta entrega já foi adicionada.");
                erro = true;
            }
        });

        if (!erro) {
            atualizaTabelaEntrega(dados);
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

            var erro_entrega = false;
            var tipo_solicitacao = $("#tipo_solicitacao").val()
            
            if(tipo_solicitacao == 2){

                $(".trEntregas").each(function () {

    //                var situacao = $(this).data('situacao');
    //                
    //                if(situacao){
                    //converte o valor informado para a entrega em formato inglês com 4 casas
                    var valor_entrega_ingles = func.converteValorIngFloat($(this).find("input[name=valorRetEntrega\\[\\]]").val());
                    valor_entrega_ingles = func.arrendondaValorParaQuatroCasas(valor_entrega_ingles);

                    //converte o valor do saldo para o formato inglês com 4 casas
                    var valor_saldo_ingles = $(this).data('saldo');
                    valor_saldo_ingles = func.arrendondaValorParaQuatroCasas(valor_saldo_ingles);

                    if (valor_entrega_ingles == 0) {
                        erro_entrega = true;
                    }

                    var entrega = {
                        id_entrega_documento: $(this).data("id"),
                        id_entrega_confirmacao: $(this).attr("identrega"),
                        vl_entrega_saldo: valor_saldo_ingles,
                        vl_entrega_documento: valor_entrega_ingles
                    }
                    entregas.push(entrega);
    //                }

                });
                
                if (entregas.length <= 0) {
                    $this.prop("disabled", false);
                    func.modalAlert("Nenhuma entrega foi adicionada.");
                    return false;
                }
                
            }

            if (erro_entrega) {
                $this.prop("disabled", false);
                func.modalAlert("O valor informado para a entrega deve ser maior que 0.");
                return false;
            }

            if (entregas.length <= 0) {
                entregas = null;
            }

            var grp = $('input[name=grp_cod]:checked').val();

            var dados = {
                "documento_fiscal": $("#idDocumentoFiscal").val(),
                "processoAdm": $("#processoAdm").val(),
                "nr_documento": $("#nr_documento").val(),
                "tpDocumento": $("#tpDocumento option:selected").val(),
                "competencia": $("#competencia").val(),
                "vencimento": $("#vencimento").val(),
                "emissao": $("#emissao").val(),
                "atesto": $("#atesto").val(),
                "valorDocumentoFiscal": $("#valorDocumentoFiscal").val(),
                "grp": grp,
                "grpNumero": $("#nr_grp").val(),
                "entregas": entregas,
                "tipo_solicitacao": $("#tipo_solicitacao").val(),
                "pedido": $("#pedido").val()
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

    function listaAnotacoes() {
        $.ajax({
            "url": "/pages/financeiro/gdof/documentoFiscal/anotacao_documento/request.php",
            "method": "POST",
            "dataType": "html",
            "data": {
                "acao": "listaAnotacoes",
                "documento_fiscal": $("#idDocumentoFiscal").val()
            },

            "success": function (response) {
                if (response.trim() === "SessaoExpirada") {
                    func.modalAlert(func.msgSemPermissao);
                    return false;
                }

                try {
                    response = JSON.parse(response);
                } catch (e) {
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }

                if (response.tipoMsg === "Erro") {
                    if (response.tipoExibicao === "console") {

                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    } else if (response.tipoExibicao === "alert") {
                        func.modalAlert(response.msg);
                        return false;
                    }
                } else if (response.tipoMsg === "ok") {

                    $(".anotacoes").html("");
                    $(".anotacoes").html(response.msg);
                    return false;
                } else {
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }
            },
            "error": function (response) {
                func.modalAlert(func.msgErroPadrao, 'danger');
                return false;
            }
        });
    }
    //lista as anotacoes 
    listaAnotacoes();

    $('body').on('click', '.btn-addAnotacao', function (e) {
        $('#adAnotacao').modal();

    });

    $('#adAnotacao').on('shown.bs.modal', function () {
        $('#anotacao').focus()
    })


    $('body').on('click', '.btn-enviarAnotacao', function (e) {
        var Dados = {
            documento_fiscal: $("#idDocumentoFiscal").val(),
            anotacao: $('#anotacao').val()
        };
        $.ajax({
            "url": "/pages/financeiro/gdof/documentoFiscal/anotacao_documento/request.php",
            "method": "POST",
            "dataType": "html",
            "data": {
                "acao": "salvaAnotacao",
                "dados": Dados
            },

            "success": function (response) {
                if (response.trim() === "SessaoExpirada") {
                    $("#adAnotacao").modal('hide');
                    func.modalAlert(func.msgSemPermissao);
                    return false;
                }

                try {
                    response = JSON.parse(response);
                } catch (e) {
                    $("#adAnotacao").modal('hide');
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }

                if (response.tipoMsg === "Erro") {
                    if (response.tipoExibicao === "console") {
                        $("#adAnotacao").modal('hide');
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    } else if (response.tipoExibicao === "alert") {
                        $("#adAnotacao").modal('hide');
                        func.modalAlert(response.msg);
                        return false;
                    }
                } else if (response.tipoMsg === "ok") {
                    $("#adAnotacao").modal('hide');
                    func.modalAlert(response.msg, 'success');
                    $('.modal-alert').on('hidden.bs.modal', function (e) {
                        listaAnotacoes();
                    });
                    return false;
                } else {
                    $("#adAnotacao").modal('hide');
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }
            },
            "error": function (response) {
                $("#adAnotacao").modal('hide');
                func.modalAlert(func.msgErroPadrao, 'danger');
                return false;
            }
        });

    });

});
