$(document).ready(function () {
    
    func = new Funcoes();
    
    
    
    function listaOrdens() {
                
        if($("#lotacao").val() == 0){
            return;
        }
        
        $.ajax({
            "url": "/model/pla/ordem_entrega/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaOrdens",
                lotacao: $("#lotacao").val()
            },
            "success": function (response) {   
                console.log(response);
                //func.carregaTabelaPadrao('tabela', response, [5], true);
            }
        });
    }
    
    
    
    
    function abreModalLotacao(){
        
        var panel = $('.selecaoLotacao').clone();
        
        panel.show();
       
        bootbox.confirm({
            title: 'Caixa de Seleção',
            message: panel,
            buttons: {
                'cancel': {
                    label: 'Fechar',
                    className: 'btn-default btn-rounded'
                },
                'confirm': {
                    label: 'Avançar',
                    className: 'btn-primary btn-rounded'
                }
            },
            callback: function (result) {
                if (result) {
                    var lotacao = $(".bootbox").find('.lotacaoSelect option:selected').val();                                                                                 
                    window.location.href = "index.php?token="+lotacao;
                }
            }
        });                
    }
    if($("#lotacao").val() == 0){
        abreModalLotacao();
    }else{
        listaOrdens();
    }           

    function listaUnidadeTipoGastoMaterial() {
        
        
        $("#tabela").find("tbody").html();
        var colunaEscondida = [];
        var table = $('#tabela').dataTable({
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
        $("#tabela").show();
    }
    listaUnidadeTipoGastoMaterial();                              
       
});
