$(document).ready(function () {

    //*********************************************************************
    func = new Funcoes();
    // var tabela = $('#tabela').DataTable();
    
    
    $('body').on('click', '#grafico_pedido', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            location.href = "/pages/financeiro/necessidade_central/relatorios/tipo_administracao/";
            
        }
    });

    // Desativa todos os funcionários com o vínculo CEC
    // function killCecs() {
        // var kill = $('#doidoKill').val();
        // if (kill != "") {
        //
        // }
        // return;
    //     $('#modalKill').modal('show');
    // }
    // killCecs();
    //*************************************************

    function aniversario() {
        $.ajax({
            "url": "/model/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                acao: "aniversario"
            },
            "success": function (response) {
                $(".aniversario").html(response);
                setTimeout(function () {
                    $(".aniversario").html("");
                }, 15000); // O valor é representado em milisegundos.

            }
        });
    }
    aniversario();
    function formatReal(int)
    {
        var tmp = int + '';
        tmp = tmp.replace(/([0-9]{2})$/g, ",$1");
        if (tmp.length > 6)
            tmp = tmp.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");

        return tmp;
    }
    function listaUsuarios() {
        let dataSet = [];
        let valores = [];
        $.ajax({
            "url": "/model/request.php",
            "dataType": 'json',
            "data": {
                acao: "listaUsuariosJSON"
            },
            "success": function (response) {

                if ($.trim(response)) {
                    if (response.length) {
                        valores = response
                    }
                }

                $("#totalUsuarios").append(valores.length);
                for (var i = valores.length - 1; i >= 0; i--) {
                    let valor = [
                        valores[i]['nm_pessoa'],
                        valores[i]['nm_email']
                    ]
                    dataSet.push(valor)
                }
                $('#tabela').DataTable({
                    data: dataSet,
                    language: {
                        "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
                    },
                    columns: [
                        {title: "Nome"},
                        {title: "Email"}
                    ]
                });
            }
        });
    }
    listaUsuarios();


    function listaLiberacoes() {
        let dataSet = [];
        let valores = [];
        var $this = $(this);

        $.ajax({
            "url": "/model/request.php",
            "dataType": "json",
            "data": {
                "acao": "listarLiberacaoCentralJSON"

            },
            "success": function (response) {
                if ($.trim(response)) {
                    if (response.length) {
                        valores = response
                    }
                }

                $("#totalProgramasTrabalho").append(valores.length);
                for (var i = valores.length - 1; i >= 0; i--) {
                    let valor = [
                        valores[i]['cd_programa_trabalho'] + '-' + valores[i]['ds_programa_trabalho'],
                        valores[i]['nm_lotacao'],
                        valores[i]['cd_despesa_elemento'],
                        valores[i]['nr_fonte'],
                        valores[i]['nm_tipo_gasto'],
                        Number(valores[i]['valor']).toLocaleString('pt-br', {style: 'currency', currency: 'BRL'}),
                        Number(valores[i]['pedido']).toLocaleString('pt-br', {style: 'currency', currency: 'BRL'}),
                        Number(valores[i]['saldo']).toLocaleString('pt-br', {style: 'currency', currency: 'BRL'}),
                    ];
                    dataSet.push(valor)
                }
                $('#tabelaProgramaTrabalho').DataTable({
                    data: dataSet,
                    language: {
                        "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
                    },
                    columns: [
                        {title: "Funcional Programática"},
                        {title: "Central"},
                        {title: "Despesa"},
                        {title: "Fonte"},
                        {title: "Tipo gasto"},
                        {title: "Valor"},
                        {title: "Pedido"},
                        {title: "Saldo"}

                    ]
                });
            }
        });
    }

    listaLiberacoes();

    function listaContratos() {
        let dataSet = [];

        let valores = []

        $.ajax({
            "url": "/model/request.php",
            "dataType": "json",
            "data": {
                "acao": "listarContratos"
            },
            "success": function (response) {
                if ($.trim(response)) {
                    if (response.length) {
                        valores = response
                    }
                }
                $("#totalContratos").append(valores.length);
                for (var i = valores.length - 1; i >= 0; i--) {
                    let valor = [
                        valores[i]['nr_contrato'],
                        valores[i]['nm_objeto']
                    ];
                    dataSet.push(valor)
                }
                $('#tabelaContratos').DataTable({
                    data: dataSet,
                    language: {
                        "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
                    },
                    columns: [
                        {title: "Nº Contrato"},
                        {title: "Objeto"}
                    ]
                });
            }
        });
    }

    listaContratos();

    function listaLicitacoes() {
        let dataSet = [];

        let valores = []
        var $this = $(this);

        $.ajax({
            "url": "/model/request.php",
            "dataType": "json",
            "data": {
                "acao": "listarLicitacoes"
            },
            "success": function (response) {
                if ($.trim(response)) {
                    if (response.length) {
                        valores = response
                    }
                }
                $("#totalLicitacoes").append(valores.length);
                for (var i = valores.length - 1; i >= 0; i--) {
                    let total = Number(valores[i]['saldo'])
                    let valor = [
                        valores[i]['cd_pregao'],
                        valores[i]['nm_objeto'],
                        Number(valores[i]['vl_total_est']).toLocaleString('pt-br', {style: 'currency', currency: 'BRL'}),
                        Number(valores[i]['vl_total_hom']).toLocaleString('pt-br', {style: 'currency', currency: 'BRL'}),
                        valores[i]['nm_situacao'],
                    ]
                    dataSet.push(valor)
                }
                $('#tabelaLicitacoes').DataTable({
                    data: dataSet,
                    order: [[1, 'asc']],
                    language: {
                        "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
                    },
                    columns: [
                        {title: "Pregão"},
                        {title: "Objeto"},
                        {title: "Valor Estimado"},
                        {title: "Valor Homologado"},
                        {title: "Situação"}
                    ]
                });
            },
            "error": function (response) {
                console.log(response)
                $this.prop("disabled", false);
                func.modalAlert(func.msgErroPadrao, 'danger');
                return false;
            }
        });
    }

    listaLicitacoes()

    function listaEmpenhos() {
        let dataSet = [];

        let valores = []
        var $this = $(this);

        $.ajax({
            "url": "/model/request.php",
            "dataType": "json",
            "data": {
                "acao": "listarEmpenhos"
            },
            "success": function (response) {
                if ($.trim(response)) {
                    if (response.length) {
                        valores = response
                    }
                }
                $("#totalEmpenhos").append(valores.length);
                for (var i = valores.length - 1; i >= 0; i--) {
                    // ****** converta data do empenho no Sistema *******
                    // **** DATA *****
                    var auxSistemaData = valores[i]['dh_empenho_sistema'].split(':');
                    var data = auxSistemaData[0].split(' ');
                    var data1 = data[0].split('-');
                    var data2 = data1[2] + '/' + data1[1] + '/' + data1[0];
                    var dataSistema = data2.split(' ');

                    // **** HORA ****
                    var auxSistemaHora = valores[i]['dh_empenho_sistema'].split(' ');
                    var hora = auxSistemaHora[1];
                    var hora1 = hora.split('.');
                    var hora2 = hora1[0];
                    // *************************************************
                    // ****** converta data do empenho no Safira *******
                    var auxSafira = valores[i]['dt_empenho_safira'].split('-');
                    var dataSafira = auxSafira[2] + '/' + auxSafira[1] + '/' + auxSafira[0];
                    // *************************************************
                    let valor = [
                        valores[i]['nr_pedido'],
                        valores[i]['nm_lotacao'],
                        valores[i]['nm_tipo_gasto'],
                        valores[i]['nr_empenho'],
                        dataSistema +' - '+ hora2,
                        dataSafira,
                        Number(valores[i]['vl_empenho']).toLocaleString('pt-br', {style: 'currency', currency: 'BRL'})
                    ];
                    dataSet.push(valor)
                }
                $('#tabelaEmpenhos').DataTable({
                    lengthMenu: [[10, 25, 50, 10, -1], [10, 25, 50, 100, "Todos"]],
                    data: dataSet,
                    language: {
                        "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
                    },
                    responsive: true,
                    dom: 'Bfrtip',
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
                                    if ($.inArray(idx) < 0) {
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
                                    if ($.inArray(idx) < 0) {
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
                                    if ($.inArray(idx) < 0) {
                                        return true;
                                    } else {
                                        return false;
                                    }
                                }
                            }
                        }
                    ],
                    columns: [
                        {title: "Nº Pedido"},
                        {title: "Central de Demanda"},
                        {title: "Tipo de gasto"},
                        {title: "Nº Empenho"},
                        {title: "Data Empenho no Sistema"},
                        {title: "Data Empenho no Safira"},
                        {title: "Valor do Empenho"}
                    ]
                });
            },
            "error": function (response) {
                console.log(response);
                $this.prop("disabled", false);
                func.modalAlert(func.msgErroPadrao, 'danger');
                return false;
            }
        });
    }

    listaEmpenhos();

    function listaPedidos() {
        let dataSet = [];

        let valores = [];
        var $this = $(this);

        $.ajax({
            "url": "/model/request.php",
            "dataType": "json",
            "data": {
                "acao": "listarPedidos"
            },
            "success": function (response) {

                if ($.trim(response)) {
                    if (response.length) {
                        valores = response
                    }
                }
                $("#totalPedidos").append(valores.length);
                for (var i = valores.length - 1; i >= 0; i--) {
                    let valor = [
                        valores[i]['nr_pedido'],
                        valores[i]['nm_tipo_solicitacao'],
                        valores[i]['ds_pedido'],
                        valores[i]['dt_pedido'],
                        // valores[i]['st_pedido'],
                        Number(valores[i]['vl_pedido']).toLocaleString('pt-br', {style: 'currency', currency: 'BRL'})
                    ];
                    dataSet.push(valor)
                }
                $('#tabelaPedidos').DataTable({
                    data: dataSet,
                    language: {
                        "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
                    },
                    columns: [
                        {title: "Nº Pedido"},
                        {title: "Tipo de Solicitação"},
                        {title: "Descrição"},
                        {title: "Data do Pedido"},
                        {title: "Valor do Pedido"}
                    ]
                });
            },
            "error": function (response) {
                console.log(response);
                $this.prop("disabled", false);
                func.modalAlert(func.msgErroPadrao, 'danger');
                return false;
            }
        });
    }

    listaPedidos()

    function listaQuantidadePedidos() {
        let dataSet = []
        let dataLabels = []
        let valores = []
        let color = ['#059BFF', '#db1818', '#FFC233', '#76d343']
        var $this = $(this);

        $.ajax({
            "url": "/model/request.php",
            "dataType": "json",
            "data": {
                "acao": "listaQuantidadeSituacaoPedido"
            },
            "success": function (response) {
                if ($.trim(response)) {
                    if (response.length) {
                        valores = response
                    }
                }
                let i = 0;
                let informacoes = "";
                let total = 0;
                for (var index in valores) {
                    dataSet.push(parseInt(valores[index]['quantidade']))
                    total += parseInt(valores[index]['quantidade']);
                    dataLabels.push(valores[index]['situacao']);
                    informacoes += '' +
                            '<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">' +
                            '<p class=""><i class="fa fa-square" style="color:' + color[i] + '"></i> ' + valores[index]['situacao'] + ' </p>' +
                            '</div>' +
                            '<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">' +
                            '<p class="text-center">' + valores[index]['quantidade'] + '</p>' +
                            '</div>';
                    i++
                }
                informacoes += '' +
                        '<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">' +
                        '<p class="text-bold">Total</p>' +
                        '</div>' +
                        '<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">' +
                        '<p class="text-center">' + total + '</p>' +
                        '</div>';

                $("#table_pedido_info").find('tbody').find('.info_resultado').html(informacoes);

                var ctx = document.getElementById("donutChartPedidoSituacao");
                data = {
                    datasets: [{
                            data: dataSet,
                            backgroundColor: color

                        }],
                    labels: dataLabels
                };
                var meuDonutChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: data,
                    options: {legend: !1, responsive: !1}


                });

                return false;
            },
            "error": function (response) {
                console.log(response)
                $this.prop("disabled", false);
                func.modalAlert(func.msgErroPadrao, 'danger');
                return false;
            }
        });
    }

    listaQuantidadePedidos()

    function listaQuantidadeOrdem() {
        let dataSet = []
        let dataLabels = []
        let valores = []
        let color = ['#6312aa', '#003fff', '#FFC233', '#76d343']
        var $this = $(this);

        $.ajax({
            "url": "/model/request.php",
            "dataType": "json",
            "data": {
                "acao": "listaQuantidadeOrdem"
            },
            "success": function (response) {
//                console.log(response);
                if ($.trim(response)) {
                    if (response.length) {
                        valores = response
                    }
                }
                //console.log(valores);
                let i = 0;
                let informacoes = "";
                let total = 0;
                for (var index in valores) {
                    dataSet.push(parseInt(valores[index]['quantidade']))
                    total += valores[index]['quantidade'];
                    dataLabels.push(valores[index]['tipo']);
                    informacoes += '' +
                            '<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">' +
                            '<p class=""><i class="fa fa-square" style="color:' + color[i] + '"></i> ' + valores[index]['tipo'] + ' </p>' +
                            '</div>' +
                            '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">' +
                            '<p class="text-center">' + valores[index]['quantidade'] + '</p>' +
                            '</div>';
                    i++
                }
                informacoes += '' +
                        '<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">' +
                        '<p class="text-bold"> Total </p>' +
                        '</div>' +
                        '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">' +
                        '<p class="text-center">' + total + '</p>' +
                        '</div> ';

                $("#table_tipo_ordem_info").find('tbody').find('.info_resultado_tipo_ordem').html(informacoes);

                var ctx = document.getElementById("donutChartTipoOrdem");
                data = {
                    datasets: [{
                            data: dataSet,
                            backgroundColor: color

                        }],
                    labels: dataLabels
                };
                var meuDonutChart1 = new Chart(ctx, {
                    type: 'doughnut',
                    data: data,
                    options: {legend: !1, responsive: !1}


                });

                return false;
            },
            "error": function (response) {
                console.log(response)
                $this.prop("disabled", false);
                func.modalAlert(func.msgErroPadrao, 'danger');
                return false;
            }
        });
    }

    listaQuantidadeOrdem();
    //**********************************************************************************************************
    function listaVinculos() {
        var Dados = {
            dt_inicio: 0,
            dt_fim: 0,
            todos: 1
        };
        let dataSet = []
        let dataLabels = []
        let valores = []
        let color = ['#ce4848', '#00ff1d', '#FFC233', '#df22f4', '#ff7200']

        var $this = $(this);

        $.ajax({
            "url": "/model/request.php",
            "dataType": 'html',
            "method": 'POST',
            "data": {
                acao: "pesquisaGrafico1",
                dados: Dados
            },
            "success": function (response) {
                try {
                    valores = JSON.parse(response);
                } catch (e) {
                    console.log(response);
                    return false;
                }
                //console.log(valores);
                let i = 0;
                let informacoes = "";
                let total = 0;
                for (var index in valores) {
                    if (valores[index]['name'] == "Temporário") {
                        continue;
                    }
                    dataSet.push(parseInt(valores[index]['y']))
                    total += valores[index]['y'];
                    dataLabels.push(valores[index]['name']);
                    informacoes += '' +
                            '<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">' +
                            '<p class=""><i class="fa fa-square" style="color:' + color[i] + '"></i> ' + valores[index]['name'] + ' </p>' +
                            '</div>' +
                            '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">' +
                            '<p class="text-center">' + valores[index]['y'] + '</p>' +
                            '</div>';
                    i++
                }
                informacoes += '' +
                        '<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">' +
                        '<p class="text-bold"> Total </p>' +
                        '</div>' +
                        $("#table_tipo_vinculo_info").find('tbody').find('.info_resultado_vinculo').html(informacoes);

                var ctx = document.getElementById("donutChartVinculo");
                data = {
                    datasets: [{
                            data: dataSet,
                            backgroundColor: color

                        }],
                    labels: dataLabels
                };
                var meuDonutChart2 = new Chart(ctx, {
                    type: 'doughnut',
                    data: data,
                    options: {legend: !1, responsive: !1}


                });

                return false;
            },
            "error": function (response) {
                console.log(response)
                $this.prop("disabled", false);
                func.modalAlert(func.msgErroPadrao, 'danger');
                return false;
            }
        });
    }

    listaVinculos();

})
