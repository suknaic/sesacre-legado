
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
        
    var Dados = {
        dt_inicio: 0,
        dt_fim: 0,
        todos: 1
    };
    var title = "Todos os Pedidos de Necessidade da SESACRE Cadastrados no Sistema";
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
            $(".panelFuncionario").hide();
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
        title = "Pedidos de Necessidade do Tipo de Solicitação: " + nmTipoSolicitacao;
       
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
                graficoSituacaoHig(title, response, idTipoSolicitacao)
                $(".panelTipoSolicitacao").show();
                $(".panelSituacao").show();
                $(".panelCentral").hide();
                $(".panelFuncionario").hide();
                carregaTabela('tabela', null, true);                
            }
        });
    }
    //********************************************************************************************************************************************************
    function graficoSituacaoHig(title, response, idTipoSolicitacao) {
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
                                graficoCentral(this.id, this.name, idTipoSolicitacao);                                
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
    function graficoCentral(idSituacao, nmSituacao, idTipoSolicitacao) {
        //************************************************************************************************
                      
        var title = "";
        var Dados = {            
            idSituacao: idSituacao,
            idTipoSolicitacao: idTipoSolicitacao
        };
        title = "Pedidos de Necessidade com a Situação: " + nmSituacao;
       
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "method": 'GET',
            "data": {
                acao: "pesquisaCentralPorTipoDeSolicitacaoSituacao",
                dados: Dados
            },
            "success": function (response) {
                console.log(response);
                console.log('graficoCentral')
                try {
                    response = JSON.parse(response);
                } catch (e) {
                    console.log(response);
                    return false;
                }              
                graficoCentralHig(title, response, idSituacao, idTipoSolicitacao)
                $(".panelTipoSolicitacao").show();
                $(".panelSituacao").show();
                $(".panelCentral").show();
                $(".panelFuncionario").hide();
                carregaTabela('tabela', null, true);                
            }
        });
    }
    
    //********************************************************************************************************************************************************
    function graficoCentralHig(title, response, idSituacao, idTipoSolicitacao) {
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
                                graficoFuncionario(this.id, this.name, idSituacao, idTipoSolicitacao);                                
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
    function graficoFuncionario(idLotacao, nmLotacao, idSituacao, idTipoSolicitacao) {

        //************************************************************************************************
       
        var title = "";
       
        var Dados = {
            dt_inicio: 0,
            dt_fim: 0,
            todos: 1,
            idVinculo: idVinculo,
            idLotacao: idLotacao
        };
        title = "Pedidos de Necessidade na Lotação: " + nmLotacao;
        
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
