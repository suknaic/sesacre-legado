$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    $(".select").select2({
        width: " 100%"
    });
    //mascara do ada
    // $("#ada").mask("99-99-9999999");
    //fim
    
    //Esconde a informação da seleção da diária
    $("#diaria").hide();

    //Masca para valor
    $("body").on("focus", "#valor", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
        });
    });

    //carrega options de lotacao do usuario
    function carregaLotacao() {
        var tpSolicitacao = $("#tipoSolicitacao option:selected").val();
        
        if (tpSolicitacao == "" || tpSolicitacao == "0") {
            $("body").find("#central").html('<option value="0">Selecione uma Central</option>');
            $(".select").select2({
            });
        } else {
            $.ajax({
                "url": "/model/financeiro/necessidade_central/requestPedido.php",
                "dataType": 'html',
                "data": {
                    "acao": "carregaLotacao",
                    "dados": tpSolicitacao
                },
                "success": function (response) {
                    $("body").find("#central").html(response);
                    $(".select").select2({
                    });
                }
            });
        }
    }
//    carregaLotacao();
    //fim

    //carrega tipo de solicitacao
    $.ajax({
        "url": "/model/financeiro/necessidade_central/requestPedido.php",
        "dataType": 'html',
        "data": {
            "acao": "carregaSolicitacao",
        },
        "success": function (response) {
            $("body").find("#tipoSolicitacao").html(response);
            $(".select").select2({
            });
        }
    });
    //fim

    //carrega tipo de gasto
    $.ajax({
        "url": "/model/financeiro/necessidade_central/requestPedido.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaTipoGasto",
        },
        "success": function (response) {
            $("body").find("#tipoDeGasto").html(response);
            $(".select").select2({
            });
        }
    });
    //fim

    $("body").on("change", "#tipoSolicitacao", function (e) {
        if ($("#tipoSolicitacao").val() == '1') {
            $(".campoForneceor").hide();
            $(".campoValor").removeClass("hidden");
            $("#tipoDeGasto").val(0).trigger('change');
            //Controle da diaria
            $("#id_diaria").val("");
            $("#diaria").hide();
            $("#valor").prop("disabled",false);
            $("#valor").val("");
        }

        if ($("#tipoSolicitacao").val() == '2') {
            $(".campoForneceor").show();
            $(".campoValor").addClass("hidden");
            $("#tipoDeGasto").val(0).trigger('change');
            //Controle da diaria
            $("#id_diaria").val("");
            $("#diaria").hide();
            $("#valor").prop("disabled",false);
            $("#valor").val("");
        }

        if ($("#tipoSolicitacao").val() == '3') {
            $(".campoForneceor").hide();
            $(".campoValor").removeClass("hidden");
            
            $("#tipoDeGasto").val(13).trigger('change');
            $("#valor").prop("disabled",true);
            $("#diaria").show();
            
        }

        if ($("#tipoSolicitacao").val() == '4') {
            $(".campoForneceor").hide();
            $(".campoValor").removeClass("hidden");
            $("#tipoDeGasto").val(0).trigger('change');
            //Controle da diaria
            $("#id_diaria").val("");
            $("#diaria").hide();
            $("#valor").prop("disabled",false);
            $("#valor").val("");
        }
        
        carregaLotacao();
    });
    
    //-------------------Regras diaria-----------------------
    $("body").on("change","#id_diaria", function(e){
        $("#valor").val($("#id_diaria option:selected").data('valor'));
    });
    //-------------------------------------------------------

    $("body").on("change","#central", function(e){
        var tipoSolicitacao = $("#tipoSolicitacao option:selected").val();

        var dados = {
            lotacao: $("#central option:selected").val()
        }
        
        if (tipoSolicitacao == 3) {
            $.ajax({
                "url": "/model/financeiro/necessidade_central/requestPedido.php",
                "dataType": 'html',
                "data": {
                    "acao": "retornaOptionsDiaria",
                    "dados": dados
                },
                "success": function(response){
                    $("body").find("#id_diaria").html(response);
//                    $(".select").select2({
//                        width: '100%'
//                    });
                }
            });
        }
    });

    $("body").on("change", "#tipoDeGasto", function (e) {
        var tipo = 'contrato'
        
        var tipoDeGasto = $("#tipoDeGasto").val();

        if ($("input[name='contratado']:checked").val() == 1) {
            tipo = 'ata';
        }
        var dados = {
            "tipo": tipo,
            "tipoGasto": tipoDeGasto
        }

        $.ajax({
            "url": "/model/financeiro/necessidade_central/requestPedido.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaOptionsAtaContrato",
                "dados": dados

            },
            "success": function (response) {
                $("body").find("#contratada").html(response);
                $(".select").select2({
                });
            }
        });
        
    });


    //carrega fonte
    $.ajax({
        "url": "/model/financeiro/necessidade_central/requestPedido.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaFonte"
        },
        "success": function (response) {
            $("body").find("#fonte").append(response);
            $(".select").select2({
            });
        }
    });
    //fim


    //carrega ano
    $("body").on("change", "#fonte", function () {
        $.ajax({
            "url": "/model/financeiro/necessidade_central/requestPedido.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaAno"
            },
            "success": function (response) {
                $("body").find("#ano").html(response);
                $(".select").select2({
                });
            }
        });

    });

    //Carrega dados da diaria no modal
    $('body').on('change',"#id_diaria",function(e){
       var idDiaria = $("#id_diaria option:selected").val();
       
        if (idDiaria > 0) {
            $.ajax({
               "url": "/model/financeiro/necessidade_central/requestPedido.php",
               "dataType": 'html',
               "data": {
                   "acao": "retornaDadosDiaria",
                   "dados": idDiaria
               },
               "success": function(response){
                   $("body").find("#diaria_dados").html(response);
               }
            });
        }
    });

    //carrega programa de trabalho
    $("body").on("change", "#ano", function () {
        var dados = {
            "ano": $("#ano").val(),
            "fonte": $("#fonte").val()
        }
        $.ajax({
            "url": "/model/financeiro/necessidade_central/requestPedido.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaProgramaTrabalho",
                "dados": dados
            },
            "success": function (response) {
                $("body").find("#Programa").html(response);
                $(".select").select2({
                });
            }
        });

    });
    //fim

    //carrega elemento de despesa
    $("body").on("change", "#Programa", function () {
        var dados = {
            "programa": $("#Programa").val(),
            "fonte": $("#fonte").val()
        }
        $.ajax({
            "url": "/model/financeiro/necessidade_central/requestPedido.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaDespesa",
                "dados": dados
            },
            "success": function (response) {
                $("body").find("#despesa").html(response);
                $(".select").select2({
                });
            }
        });

    });
    //fim

    //carrega SubElemento de despesa
    $("body").on("change", "#despesa", function () {
        var dados = {
            "despesa": $("#despesa").val()
        }
        $.ajax({
            "url": "/model/financeiro/necessidade_central/requestPedido.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaSubElemento",
                "dados": dados
            },
            "success": function (response) {
                $("body").find("#subElemento").html(response);
            }
        });

    });
    //fim



    $("body").on("click", '#ata', function () {
        var tipo = 'contrato'

        if ($("input[name='contratado']:checked").val() == 1) {
            tipo = 'ata';
        }
        var dados = {
            "tipo": tipo,
            "tipoGasto": $("#tipoDeGasto").val()
        }

        $.ajax({
            "url": "/model/financeiro/necessidade_central/requestPedido.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaOptionsAtaContrato",
                "dados": dados

            },
            "success": function (response) {
                $("body").find("#contratada").html(response);
            }
        });
    });

    $("body").on("click", '#contrato', function () {
        var tipo = 'contrato'

        if ($("input[name='contratado']:checked").val() == 1) {
            tipo = 'ata';
        }
        var dados = {
            "tipo": tipo,
            "tipoGasto": $("#tipoDeGasto").val()
        }

        $.ajax({
            "url": "/model/financeiro/necessidade_central/requestPedido.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaOptionsAtaContrato",
                "dados": dados

            },
            "success": function (response) {
                $("body").find("#contratada").html(response);
            }
        });
    });


    $("body").on("click", ".btn-salvar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            //validação de campos js

            //Validação da Diaria
            if ($("#tipoSolicitacao").val() == 3 && $("#id_diaria").val() == ""){
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#tipoSolicitacao").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#tipoDeGasto").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#fonte").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#ano").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#Programa").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#despesa").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#subElemento").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#desc_objeto").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            var dados = {
                "tipoSolicitacao": $("#tipoSolicitacao").val(),
                "contratado": $("input[name='contratado']:checked").val(),
                "contratada": $("#contratada").val(),
                "fonte": $("#fonte").val(),
                "ano": $("#ano").val(),
                "programa": $("#Programa").val(),
                "subElemento": $("#subElemento").val(),
                "despesa": $("#despesa").val(),
                "tipoDeGasto": $("#tipoDeGasto").val(),
                "idLotacao": $("#central").val(),
                "descPedido": $("#desc_pedido").val(),
                "valor": $("#valor").val(),
                "idDiaria": $("#id_diaria").val()
            }


            if ($("#tipoSolicitacao").val() == 1 || $("#tipoSolicitacao").val() == 3 || $("#tipoSolicitacao").val() == 4) {
                $.ajax({
                    "url": "/model/financeiro/necessidade_central/requestPedido.php",
                    "dataType": "html",
                    "data": {
                        "acao": "cadastrarPedidoSemFornecedor",
                        "dados": dados
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
                            func.modalAlert("Solicitação de Necessidade Realizada com Sucesso.", 'success');
                            $('.modal-alert').on('hidden.bs.modal', function (e) {
                                if (response.tipoExibicao === "pre") {
                                    window.location.href = "/pages/financeiro/preOrdem/index.php?&id=" + response.msg;
                                } else {
                                    window.location.href = "/pages/index.php";
                                }

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
            } else {

                $.ajax({
                    "url": "/model/financeiro/necessidade_central/requestPedido.php",
                    "dataType": "html",
                    "data": {
                        "acao": "cadastrarPedido",
                        "dados": dados
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
                            func.modalAlert("Solicitação de Necessidade Realizada com Sucesso.", 'success');
                            $('.modal-alert').on('hidden.bs.modal', function (e) {
                                if (response.tipoExibicao === "pre") {
                                    window.location.href = "/pages/financeiro/preOrdem/index.php?&id=" + response.msg;
                                } else {
                                    window.location.href = "/pages/index.php";
                                }

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


            $this.prop("disabled", false);
        }
    });

});
