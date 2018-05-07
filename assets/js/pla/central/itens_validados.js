$(document).ready(function () {

    func = new Funcoes();

    function listaTabelaItens() {
                
        if($("#central").val() == 0 || $("#ano").val() == 0){
            return;
        }
        
        $.ajax({
            "url": "/model/pla/central/request_itens_validados.php",
            "dataType": 'html',
            "data": {
                acao: "listaTbItens",
                central: $("#central").val(),
                ano: $("#ano").val()                
            },
            "success": function (response) {
                
             
                $(".tabelasItens").html(response);     
                return false;
                var colunaEscondida = [4];                
                var table = $('.tabela-itens-salvo').dataTable({
                    "lengthMenu": [[10, 25, 50, 10, -1], [10, 25, 50, 100, "Todos"]],
                    "ordering": false,                
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
                            exportOptions: {
                                columns: function ( idx ) {
                                            if($.inArray( idx, colunaEscondida ) < 0){
                                                return true;
                                            }else{
                                                return false;
                                            }    
                                        }
                            }
                        },     
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fa fa-file-pdf-o"></i> PDF',
                            exportOptions: {
                                columns: function ( idx ) {
                                            if($.inArray( idx, colunaEscondida ) < 0){
                                                return true;
                                            }else{
                                                return false;
                                            }    
                                        }
                            }
                        },                        
                        {
                            extend: 'print',
                            text: '<i class="fa fa-print"></i> Imprimir',                           
                            exportOptions: {
                                columns: function ( idx ) {                                        
                                            if($.inArray( idx, colunaEscondida ) < 0){
                                                return true;
                                            }else{
                                                return false;
                                            }                                            
                                        }                                    							
                                }                            
                        }
                    ]
                });
                $(".tabela-itens-salvo").show();
            }
        });
    }
    listaTabelaItens();           
       
       
    $('body').on('click', '.btn-informacoes', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);
            var Dados = {
                id : $this.val()
            }
            
            $.ajax({
                "url": "/model/pla/central/request_itens_validados.php",
                "dataType": 'html',
                "data": {
                    acao: "retornaInfoDoItem",
                    dados: Dados
                },
                "success": function (response) {           
                    $("#modalInformacoes").find('.modal-body').html(response);
                    $("#modalInformacoes").modal('show');

                }
            });                                      
        }
    });
    
 
    
       
});
