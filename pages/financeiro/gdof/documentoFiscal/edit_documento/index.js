$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    //Mascara do sistema
    $('#emissao').mask("99/99/9999");
    $('#atesto').mask("99/99/9999");
    //busca pedido
    $('#modalItem').on('shown.bs.modal', function () {
        $('#codItemPesquisa').focus();
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

    var infTabEntrega = [];
    $(".trEntregas").each(function(){
        infTabEntrega.push($(this).attr('identrega'));       
    });

    $("body").on("click", ".addEntrega", function (e) {        
        if($("#selectEntrega option:selected").val() == 0){
            return false;
        }
        infTabEntrega.push($("#selectEntrega option:selected").val());
        atualizaTabelaEntrega(infTabEntrega);
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
                $("#tabelaEntrega").find("tbody").html(response);
                $("#valorDocumentoFiscal").val($("body").find(".valorEntregaTotal").attr("valor"));
            }
        });
    }


    $("body").on("click", ".excluirEntrega", function (e) {
        var $this = $(this);
        $("#ent" + $this.val()).remove();
        infTabEntrega = [];
        var qtdEntrega = 0;
        $(".trEntregas").each(function () {
            infTabEntrega.push($(this).attr("identrega"));
            qtdEntrega++;
        });
        
        if (qtdEntrega > 0) {
            atualizaTabelaEntrega(infTabEntrega);
        }else{
            let valor = "0,0000";
            $("#tabelaEntrega").find(".valorEntregaTotal").attr("valor", valor);
            $("#tabelaEntrega").find(".valorEntregaTotal").text(valor);
            $("#valorDocumentoFiscal").val(valor);
        }
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

            $(".trEntregas").each(function () {
                entregas.push($(this).attr("identrega"));
            });

            if (entregas.length <= 0) {
                func.modalAlert("Nenhuma entrega foi adicionada.");
                return false;
            }

            var grp = "";

            if ($('input[name=grp_cod]:checked').val() === 1) {
                grp = $("#grp_sim").val();

            } else if ($('input[name=grp_cod]:checked').val() === 0) {
                grp = $("#grp_nao").val();

            }

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
                "grpNumero": $("#nr_grp").val()
            }

            $.ajax({
                "url": "request.php",
                "method": "POST",
                "dataType": "html",
                "data": {
                    "acao": "editarDocumentoFiscal",
                    "dados": dados,
                    "entrega": entregas
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


});
