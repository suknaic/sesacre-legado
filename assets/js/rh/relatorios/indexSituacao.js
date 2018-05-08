
//**********************************
$(document).ready(function () {
   //******************************************************************************************    
    function listaAnoSitucaoCombo() {
        $.ajax({
            "url": "/model/rh/relatorios/request.php",
            "dataType": 'html',
            "method": 'POST',
            "data": {
                acao: "listaAnoSituacaoOption",
                id: 0
            },
            "success": function (response) {
                //console.log(response);
                $("#ano").append(response);
                $("#ano").select2({
                    width: " 100%"
                });
            }
        });
    }
    listaAnoSitucaoCombo();
//******************************************************************************************    
    function listaSituacaoCombo() {
        $.ajax({
            "url": "/model/rh/funcionario/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaSituacaoOption"
            },
            "success": function (response) {
                //console.log(response);
                $("#id_situacao").append(response);
                $("#id_situacao").select2({
                    width: " 100%"
                });
            }
        });
    }
    listaSituacaoCombo();
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
//******************************************************************************************
    func = new Funcoes();
    //************************************
    $("#tipo").select2({
        width: " 100%"
    });
    $("#mes").select2({
        width: " 100%"
    });
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
        var vinculo = $("#id_vinculo").val();
        var lotacao = $("#id_lotacao").val();
        var situacao = $("#id_situacao").val();
        var mes = $.trim($("#mes").val());
        var ano = $.trim($("#ano").val());
        //************************************************************************************************
        if (tipo == 0) {
            func.modalAlert(" É necessário informar o tipo de Relatório");
            return false;
        }
//************************************************************************************************
        if (ano == 0 && mes == 0 && vinculo == 0 && lotacao == 0 && situacao == 0) {
        //alert("É necessário informar no mínimo um filtro para imprimir");
            func.modalAlert(" É necessário informar no mínimo um filtro para imprimir");
            return false;
        }
        if (mes != 0 && ano == 0) {
            func.modalAlert("Selecione o Ano");
            return false;
        }

//********************************************************************

        var pesquisa = vinculo + "-" + lotacao + "-" + situacao + "-" + mes + "-" + ano;
        var w = window.btoa(pesquisa);
        switch (tipo) {
            case '1':
                window.open("/pages/rh/relatorios/relatorioLotacaoSitPdf.php?pesquisa=" + w, "_blank");
                break;
            case '2':
                window.open("/pages/rh/relatorios/relatorioSituacaoPdf.php?pesquisa=" + w, "_blank");
                break;
            case '3':
                window.open("/pages/rh/relatorios/relatorioVinculoSitPdf.php?pesquisa=" + w, "_blank");
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

    });
});
