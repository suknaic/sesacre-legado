
//**********************************
$(document).ready(function () {
//******************************************************************************************    
    function carregaTabela(nomeTabela, response, destroi = false) {
        if (destroi == true) {
            var oTable = $('#' + nomeTabela).dataTable();
            oTable.fnDestroy();
        }

        $("#" + nomeTabela).find("tbody").html(response);
        var colunaEscondida = []
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
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o"></i> Excel',
                    footer: true,
                    exportOptions: {
                        columns: function (idx) {
                            if ($.inArray(idx, colunaEscondida) < 0) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'TABLOID',
                    text: '<i class="fa fa-file-pdf-o"></i> PDF',
                    footer: true,
                    exportOptions: {
                        columns: function (idx) {
                            if ($.inArray(idx, colunaEscondida) < 0) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> Imprimir',
                    footer: true,
                    exportOptions: {
                        columns: function (idx) {
                            if ($.inArray(idx, colunaEscondida) < 0) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                }
            ]
        });
        $("#" + nomeTabela).html();
    }

    //************************************
    func = new Funcoes();
    carregaTabela('tabela', null, false);
        
    var Dados = {
        dt_inicio: 0,
        dt_fim: 0,
        todos: 1
    };
    var title = "Pedidos de Necessidade por Tipo de Solicitação";
    //************************************************************************************************
    $.ajax({
        "url": "request.php",
        "dataType": 'html',
        "method": 'GET',
        "data": {
            acao: "pesquisaTipoDeSolicitacao",
            dados: Dados
        },
        "success": function (response) {            
            try {
                response = JSON.parse(response);
            } catch (e) {
                console.log(response);
                return false;
            }           
            graficoSolicitacaoHig(title, response)
            $(".panelTipoSolicitacao").show();
            $(".panelSituacao").hide();
            $(".panelCentral").hide();
            $(".panelPedidos").hide();
        }
    });
  

    //**********************************************************************************************
    function graficoSolicitacaoHig(title, response) {
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
        Highcharts.chart('graficoSolicitacao', {
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
                pointFormat: '<b>{point.y}</b> Pedidos ≃ <b>{point.percentage:.1f}%</b>'
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
                                graficoSituacao(this.id, this.name)                                
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
    function graficoSituacao(idTipoSolicitacao, nmTipoSolicitacao) {
        //************************************************************************************************
                      
        var title = "";
        var Dados = {            
            idTipoSolicitacao: idTipoSolicitacao
        };
        title = "Pedidos de Necessidade do Tipo de Solicitação <b>" + nmTipoSolicitacao + "</b> por Situação";
       
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "method": 'GET',
            "data": {
                acao: "pesquisaSituacaoPorTipoDeSolicitacao",
                dados: Dados
            },
            "success": function (response) {                
                try {
                    response = JSON.parse(response);
                } catch (e) {
                    console.log(response);
                    return false;
                }              
                graficoSituacaoHig(title, response, idTipoSolicitacao, nmTipoSolicitacao)
                $(".panelTipoSolicitacao").show();
                $(".panelSituacao").show();
                $(".panelCentral").hide();
                $(".panelPedidos").hide();
                carregaTabela('tabela', null, true);                
            }
        });
    }
    //********************************************************************************************************************************************************
    function graficoSituacaoHig(title, response, idTipoSolicitacao, nmTipoSolicitacao) {
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
        Highcharts.chart('graficoSituacao', {
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
                pointFormat: '<b>{point.y}</b> Pedidos ≃ <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    innerSize: 100,
                    depth: 45,
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function () {                                
                                graficoCentral(this.id, this.name, idTipoSolicitacao, nmTipoSolicitacao);                                
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
    function graficoCentral(idSituacao, nmSituacao, idTipoSolicitacao, nmTipoSolicitacao) {
        //************************************************************************************************
                      
        var title = "";
        var Dados = {            
            idSituacao: idSituacao,
            idTipoSolicitacao: idTipoSolicitacao
        };
        title = "Pedidos de Necessidade do Tipo de Solicitação <b>" + nmTipoSolicitacao + "</b> com a Situação <b>"+nmSituacao+ "</b> por Central de Demanda";        
       
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "method": 'GET',
            "data": {
                acao: "pesquisaCentralPorTipoDeSolicitacaoSituacao",
                dados: Dados
            },
            "success": function (response) {                
                try {
                    response = JSON.parse(response);
                } catch (e) {
                    console.log(response);
                    return false;
                }              
                graficoCentralHig(title, response, idSituacao, idTipoSolicitacao, nmTipoSolicitacao, nmSituacao)
                $(".panelTipoSolicitacao").show();
                $(".panelSituacao").show();
                $(".panelCentral").show();
                $(".panelPedidos").hide();
                carregaTabela('tabela', null, true);                
            }
        });
    }
    
    //********************************************************************************************************************************************************
    function graficoCentralHig(title, response, idSituacao, idTipoSolicitacao, nmTipoSolicitacao, nmSituacao) {
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
        Highcharts.chart('graficoCentral', {
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
                pointFormat: '<b>{point.y}</b> Pedidos ≃ <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    innerSize: 100,
                    depth: 45,
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function () {                                
                                graficoFuncionario(this.id, this.name, idSituacao, idTipoSolicitacao, nmTipoSolicitacao, nmSituacao);                                
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
    function graficoFuncionario(idLotacao, nmLotacao, idSituacao, idTipoSolicitacao, nmTipoSolicitacao, nmSituacao) {

        //************************************************************************************************
       
        var title = "";
       
        var Dados = {        
            idLotacao: idLotacao,
            idSituacao: idSituacao,
            idTipoSolicitacao: idTipoSolicitacao
        };        
        title = "Central de Demanda "+ nmLotacao;
        
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "method": 'GET',
            "data": {
                acao: "pesquisaPedidos",
                dados: Dados
            },
            "success": function (response) {                
                $(".panelPedidos").show();
                $(".titulo").text(title);                
                carregaTabela('tabela', response, true);
            }
        });
    }
    //********************************************************************************************************************************************************


});
