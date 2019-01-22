
//**********************************
$(document).ready(function () {
//******************************************************************************************    
    function carregaTabela(nomeTabela, response, destroi = false) {
        if (destroi == true) {
            var oTable = $('#' + nomeTabela).dataTable();
            oTable.fnDestroy();
        }

        $("#" + nomeTabela).find("tbody").html(response);
        var table = $('#' + nomeTabela).dataTable({
            "lengthMenu": [[10, 25, 50, 10, -1], [10, 25, 50, 100, "Todos"]],
            "order": [],
            "language": {
                "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
            },
            responsive: true,
            dom: 'Bfrtip',
            "scrollX": true,
            buttons: [
                {
                    extend: 'pageLength'
                }
            ]
        });
        $("#" + nomeTabela).html();
    }

    //************************************
    func = new Funcoes();
    carregaTabela('tabela', null, false);
    //***********************************
    $(".data").mask("99/99/9999");
    //datapiker, plugins para data
    $('.data').datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR"
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
//*****************************************
    $('body').on('click', '.btn-gerar', function () {
        var dataIni = $.trim($("#dt_inicio").val());
        var dataFim = $.trim($("#dt_fim").val());
        var x = $(".todos").is(":checked");
        var title = "";
        if (x) {
            var Dados = {
                dt_inicio: 0,
                dt_fim: 0,
                todos: 1
            };
            title = "Todos os Funcionários da SESACRE Cadastrados no Sistema";
        } else {
            if (dataIni == "" && dataFim == "") {
                func.modalAlert(func.msgPreencherCampos + '<strong>(Data Início)</strong>');
                return false;
            }
            if (dataIni.length == 10 && dataFim.length == 0) {
                func.modalAlert(func.msgPreencherCampos + '<strong>(Data Fim)</strong>');
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
                        func.modalAlert("A Data Início Não Pode Ser Maior que a Data Fim.");
                        return false;
                    }
                    title = "Funcionários da SESACRE com Data de Admissão de: " + data1 + " até " + data2;
                } else {
                    func.modalAlert("Ao informar a Data Fim é preciso também informar a Data Inicio.");
                    return false;
                }
            }
            //********************************************************************
            var Dados = {
                dt_inicio: dataIni,
                dt_fim: dataFim,
                todos: 0
            };
        }
        //************************************************************************************************
        $.ajax({
            "url": "/model/rh/relatorios/request.php",
            "dataType": 'html',
            "method": 'POST',
            "data": {
                acao: "pesquisaGrafico1",
                dados: Dados
            },
            "success": function (response) {
                try {
                    response = JSON.parse(response);
                    erro = false;
                } catch (e) {
                    if (response === 'maior') {
                        erro = true;
                    } else if (response === 'invalida'){
                        console.log(response);
                        erro = true;
                        func.modalAlert('Data Início ou Data Fim São Inválidas.');
                        return false;
                    }else {
                        console.log(response);
                        erro = true;
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    }
                }

                if (erro == true) {
                    func.modalAlert('Data Início ou Data Fim São Maior(es) que a Data Atual.');
                    return false;
                } else {
                    graficoVinculoHig(title, response);
                    $(".panelVinculo").show();
                    $(".panelLotacao").hide();
                    $(".panelFuncionario").hide();
                }
            }
        });
    });
    //*********************************************************
    $('body').on('click', '.todos', function (e) {
        $(".data").val("");
        var x = $(".todos").is(":checked");
        if (x) {
            $(".data").prop("disabled", true);
        } else {
            $(".data").prop("disabled", false);
        }
    });
    //**********************************************************************************************
    function graficoVinculoHig(title, response) {
        //**************************************
        $max = parseInt(response[1]['y']);
        $.each(response, function (key, value) {
            if (parseInt(value['y']) > $max) {
                $max = parseInt(value['y']);
            }
        });
        //**************************************
        var dados = {};
        dados.a = [];
        $.each(response, function (key, value) {
            if (parseInt(value['y']) == $max) {
                $sliced = true;
                $selected = true;
            } else {
                $sliced = false;
                $selected = false;
            }
            var c = {
                name: value['name'],
                y: value['y'],
                sliced: $sliced,
                selected: $selected,
                id: key
            };
            dados.a.push(c);
        });
        //console.log(dados.a);
        //***********************************
        Highcharts.chart('graficoVinculo', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45,
                    beta: 0
                }
            },
            title: {
                text: title
            },
            tooltip: {
                pointFormat: '<b>{point.y}</b> Funcionários ≃ <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    depth: 35,
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}'
                    },
                    point: {
                        events: {
                            click: function () {
                                //alert(this.id);
                                graficoLotacao(this.id, this.name)
                                //$(".panelFuncionario").hide();
                            },
                        }
                    }
                }
            },
            series: [{
                    type: 'pie',
                    name: 'Browser share',
                    data:
                            dados.a

                }]
        });
    }
    //********************************************************************************************************************************************************
    function graficoLotacao(idVinculo, nmVinculo) {
        //************************************************************************************************
        var x = $(".todos").is(":checked");
        var title = "";
        if (x) {
            var Dados = {
                dt_inicio: 0,
                dt_fim: 0,
                todos: 1,
                idVinculo: idVinculo
            };
            title = "Funcionários da SESACRE Cadastrados no Sistema do Vinculo " + nmVinculo;
        } else {
            var dataIni = $.trim($("#dt_inicio").val());
            var dataFim = $.trim($("#dt_fim").val());
            var Dados = {
                dt_inicio: dataIni,
                dt_fim: dataFim,
                todos: 0,
                idVinculo: idVinculo
            };
            title = "Funcionários da SESACRE com Data de Admissão de: " + dataIni + " até " + dataFim + " do Vinculo " + nmVinculo;
        }
        $.ajax({
            "url": "/model/rh/relatorios/request.php",
            "dataType": 'html',
            "method": 'POST',
            "data": {
                acao: "pesquisaGrafico2",
                dados: Dados
            },
            "success": function (response) {
                try {
                    response = JSON.parse(response);
                } catch (e) {
                    console.log(response);
                    return false;
                }
                //      console.log(response, idVinculo);
                graficoLotacaoHig(title, response, idVinculo);
                $(".panelVinculo").show();
                $(".panelLotacao").show();
                $(".panelFuncionario").hide();
                carregaTabela('tabela', null, true);
            }
        });
    }
    //********************************************************************************************************************************************************
    function graficoLotacaoHig(title, response, idVinculo) {
        //*********************************************
        var dados = {};
        dados.a = [];
        $.each(response, function (key, value) {
            var c = {
                name: value['name'],
                y: value['y'],
                id: key
            };
            dados.a.push(c);
        });
        //**********************************************
        Highcharts.chart('graficoLotacao', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45
                }
            },
            title: {
                text: '<h1>' + title + '</h1>'
            },
            tooltip: {
                pointFormat: '<b>{point.y}</b> Funcionários ≃ <b>{point.percentage:.1f}%</b>'
            },
            subtitle: {
                text: 'Fonte: Banco de Dados da Sesacre'
            },
            plotOptions: {
                pie: {
                    innerSize: 100,
                    depth: 45,
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function () {
                                graficoFuncionario(this.id, this.name, idVinculo);
                            },
                        }
                    }
                }
            },
            series: [{
                    name: 'Funcionário da Lotação',
                    data: dados.a
                }]
        });

    }

    //********************************************************************************************************************************************************
    function graficoFuncionario(idLotacao, nmLotacao, idVinculo) {

        //************************************************************************************************
        var x = $(".todos").is(":checked");
        var title = "";
        if (x) {
            var Dados = {
                dt_inicio: 0,
                dt_fim: 0,
                todos: 1,
                idVinculo: idVinculo,
                idLotacao: idLotacao
            };
            title = "Funcionários da SESACRE Cadastrados na Lotação: " + nmLotacao;
        } else {
            var dataIni = $.trim($("#dt_inicio").val());
            var dataFim = $.trim($("#dt_fim").val());
            var Dados = {
                dt_inicio: dataIni,
                dt_fim: dataFim,
                todos: 0,
                idVinculo: idVinculo,
                idLotacao: idLotacao
            };
            title = "Funcionários da SESACRE com Data de Admissão de: " + dataIni + " até " + dataFim + ", da Lotação: " + nmLotacao;
        }
        $.ajax({
            "url": "/model/rh/relatorios/request.php",
            "dataType": 'html',
            "method": 'POST',
            "data": {
                acao: "pesquisaGraficoFuncionario",
                dados: Dados
            },
            "success": function (response) {
                $(".panelFuncionario").show();
                $(".titulo").text(title);
                carregaTabela('tabela', response, true);

            }
        });
    }
    //********************************************************************************************************************************************************


});
