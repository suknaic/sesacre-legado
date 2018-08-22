
//**********************************
$(document).ready(function () {
    //******************************************************************************************    
    function listaEscolaridadeFormacaoCombo() {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaEscolaridadeFormacaoOption"
            },
            "success": function (response) {
                //  console.log(response);
                $(".formacao").append(response);
                $(".formacao").select2({
                    width: " 100%"
                });
            }
        });
    }
    listaEscolaridadeFormacaoCombo();
//******************************************************************************************
    function listaVinculoCombo() {
        $.ajax({
            "url": "/model/rh/relatorios/request.php",
            "dataType": 'html',
            "method": 'POST',
            "data": {
                acao: "listaVinculoOption",
                id: 0
            },
            "success": function (response) {
                //console.log(response);
                $("#id_vinculo").append(response);
                $("#id_vinculo").select2({
                    width: " 100%"
                });
            }
        });
    }
    listaVinculoCombo();
//******************************************************************************************
    function listaLotacaoCombo() {
        $.ajax({
            "url": "/model/rh/relatorios/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaLotacaoOption",
                id: 0
            },
            "success": function (response) {
                // console.log(response);
                $("#id_lotacao").append(response);
                $("#id_lotacao").select2({
                    width: " 100%"
                });
            }
        });
    }
    listaLotacaoCombo();
//*********************************************************************
    function listaCargoCombo() {
        $.ajax({
            "url": "/model/rh/relatorios/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaCargoOption"
            },
            "success": function (response) {
                //console.log(response);
                $("#id_cargo").append(response);
                $("#id_cargo").select2({
                    width: " 100%"
                });
            }
        });
    }
    listaCargoCombo();
//******************************************************************************************
    function listaFuncaoCombo() {
        $.ajax({
            "url": "/model/rh/relatorios/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaFuncaoOption"
            },
            "success": function (response) {
                // console.log(response);
                $("#id_funcao").append(response);
                $("#id_funcao").select2({
                    width: " 100%"
                });
            }
        });
    }
    listaFuncaoCombo();
    //******************************************************************************************
    func = new Funcoes();
    //************************************
    $("#tipo").select2({
        width: " 100%"
    });
    //************************************
    $(".data").mask("99/99/9999");
    //datapiker, plugins para data
    
    $(".data").datepicker().on('changeDate', function () {
        $(".data").datepicker('hide');
    });
    $('body').on('keypress', '.data', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".data").datepicker('hide');
            //return false;
        }
    });
//******************************************************************************************
    $('body').on('click', '.btn-limpar', function (e) {
        top.location.reload();
    });
    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nome").focus();
    });
    //*****************************************
    $('body').on('click', '.btn-gerar', function () {
//        func.modalAlert(" Página em Construção");
//        return false;
        var tipo = $("#tipo").val();
        var cargo = $("#id_cargo").val();
        var funcao = $("#id_funcao").val();
        var vinculo = $("#id_vinculo").val();
        var lotacao = $("#id_lotacao").val();
        var dataIni = $.trim($("#dt_inicio").val());
        var dataFim = $.trim($("#dt_fim").val());
        var competencia = $.trim($("#id_competencia").val());
        //************************************************************************************************
        if (tipo == 0) {
            func.modalAlert(func.msgPreencherCampos + " <strong>(Tipo de Relatório)</strong>");
            return false;
        }
        //************************************************************************************************
        if (cargo == 0 && funcao == 0 && vinculo == 0 && lotacao == 0 && dataIni == "" && dataFim == "" && competencia == 0) {
//alert("É necessário informar no mínimo um filtro para imprimir");
//             func.modalAlert(" É necessário informar no mínimo um filtro para imprimir");
            func.modalAlert(func.msgPreencherCampos);
            return false;
        }
        if (dataIni.length == 10 && dataFim.length == 0) {
            // func.modalAlert(func.msgPreencherCampos + " Ao informar a Data Inicio é preciso também informar a Data Fim");
            func.modalAlert(func.msgPreencherCampos + ' <strong>(Data Inicio e Data Fim)</strong>');
            return false;
        }
//********data fim tem de ser inferior a data inicio**********************
        if ($("#dt_fim").val().length == 10) {
            if ($("#dt_inicio").val().length == 10) {
                var data1 = $("#dt_inicio").val();
                var data2 = $("#dt_fim").val();
                var x = data1.split("/")[2].toString() + "/" + data1.split("/")[1].toString() + "/" + data1.split("/")[0].toString();
                var y = data2.split("/")[2].toString() + "/" + data2.split("/")[1].toString() + "/" + data2.split("/")[0].toString();
                var dataInicial = new Date(x);
                var dataFinal = new Date(y);
                if (dataInicial > dataFinal) {
                    func.modalAlert("A data de Inicio Não Pode Ser Maior que a Data Fim");
                    return false;
                }
            } else {
                // func.modalAlert("Ao informar a Data Fim é preciso também informar a Data Inicio");
                func.modalAlert(func.msgPreencherCampos + ' <strong>(Data Inicio e Data Fim)</strong>');
                return false;
            }
        }
//********************************************************************
        if (dataIni == "") {
            dataIni = 0;
        }
        if (dataFim == "") {
            dataFim = 0;
        }

        var pesquisa = vinculo + "-" + lotacao + "-" + cargo + "-" + funcao + "-" + dataIni + "-" + dataFim;
        var w = window.btoa(pesquisa);
        switch (tipo) {
            case '1':
                window.open("/pages/rh/relatorios/relatorioCargoPdf.php?pesquisa=" + w, "_blank");
                break;
            case '2':
                window.open("/pages/rh/relatorios/relatorioEmpresaPdf.php?pesquisa=" + w, "_blank");
                break;
            case '3':
                window.open("/pages/rh/relatorios/relatorioFuncaoPdf.php?pesquisa=" + w, "_blank");
                break;
            case '4':
                window.open("/pages/rh/relatorios/relatorioLotacaoPdf.php?pesquisa=" + w, "_blank");
                break;
            case '5':
                window.open("/pages/rh/relatorios/relatorioVinculoPdf.php?pesquisa=" + w, "_blank");
                break;
            case '6':
                var y = window.btoa(competencia);
                window.open("/pages/rh/relatorios/relatorioCompetenciaPdf.php?pesquisa=" + y, "_blank");
                break;
            default:
                return false
        }


    });
    $('body').on('keypress', '.formRelatorio', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-gerar").trigger('click');
            return false;
        }
    }
    );
    $('body').on('change', '#tipo', function (e) {
        var tipo = $("#tipo").val();
        if (tipo == 0) {
            $(".quebres").hide();
            $(".competencia").hide();
        }
        if (tipo > 0 && tipo < 6) {
            $(".quebres").show();
            $(".competencia").hide();
        }
        if (tipo == 6) {
            $(".quebres").hide();
            $(".competencia").show();
        }

    });
});
