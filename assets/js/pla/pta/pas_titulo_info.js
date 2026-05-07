$(document).ready(function () {

    func = new Funcoes();
    
    function lista() {
        
        var Dados = {            
            pta_titulo : $("#pta_titulo").val()
        }                
        $.ajax({
            "url": "/model/pla/pta/request_pta_titulo_info.php",
            "dataType": 'html',
            "data": {
                acao: "retornaDadosAcoes",
                dados: Dados
            },
            "success": function (response) { 
                $("#acoes").html(response);                
            }
        });
    }
    lista();
    
    function listaGraficoColunaFonte() {
        
        var Dados = {            
            pta_titulo : $("#pta_titulo").val()
        }                
        $.ajax({
            "url": "/model/pla/pta/request_pta_titulo_info.php",
            "dataType": 'json',
            "data": {
                acao: "retornaGraficoColunaFonte",
                dados: Dados
            },
            "success": function (response) {
                if(response.tipoMsg == "erro"){
                    console.log('Não retornou Nada.');
                }else{                    
                    gerarGraficoColuna(response);                             
                }                
            }
        });
    }
    listaGraficoColunaFonte();
        


    function gerarGraficoColuna(Dados){
                  
        var valores = [];
        var categorias = [];
        $.each( Dados.msg, function( key, value ) {                
            valores.push(parseFloat(value.valor));
            categorias.push(value.nr_fonte);                
        });                         
            
        $(function () {

            var chart;
            Highcharts.setOptions({
                lang: {
                    decimalPoint: ',',
                    thousandsSep: '.'                            
                }
            });
                    
            chart =  Highcharts.chart('primeiro', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'column'
                },
                title: {
                    text: 'Valores Por Fontes'
                },
                xAxis: {
                    categories: categorias,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Valor (R$)'
                    }
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>R$ {point.y:,.2f}</b>'
                },
                plotOptions: {
                    column: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: 'R$ {point.y:,.2f} ',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    name: 'Fontes',        
                    data: valores
                }]
            });
        });                
    }     
    
    
    function listaGraficoPizzaCategoriaEconomica() {
        
        var Dados = {            
            pta_titulo : $("#pta_titulo").val()
        }                
        $.ajax({
            "url": "/model/pla/pta/request_pta_titulo_info.php",
            "dataType": 'json',
            "data": {
                acao: "retornaPizzaCategoriaEconomica",
                dados: Dados
            },
            "success": function (response) {                                
                
                if(response.tipoMsg == "erro"){
                    console.log('Não retornou Nada.');
                }else{                    
                    gerarGraficoPizza(response);                             
                }                
            }
        });
    }
    listaGraficoPizzaCategoriaEconomica();
    
    
    function gerarGraficoPizza(Dados){        
        var despesas = {};
        despesas.dados = [];        
        var c = "";
        $.each( Dados.msg, function( key, value ) {                
            c = {name:value.ds_despesa_categoria, y: parseFloat(value.valor)};
            despesas.dados.push(c);                                 
        });                         
                    
        $(function () {

            var chart;
            Highcharts.setOptions({
                lang: {
                    decimalPoint: ',',
                    thousandsSep: '.'                            
                }
            });
                    
            chart =  Highcharts.chart('segundo', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Valores Pela Categoria Econômica da Despesa'
                },                
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Valor (R$)'
                    }
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>R$ {point.y:,.2f}</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: 'R$ {point.y:,.2f} ',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    name: 'Valor',
                    colorByPoint: true,
                    data: despesas.dados
                }]
            });
        });                
    }     
    

});
