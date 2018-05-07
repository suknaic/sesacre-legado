$(document).ready(function () {

    func = new Funcoes();
    
    function listaItens(){
                        
        var Dados = {            
            pas : $("#pas").val()            
        }
        
        $.ajax({
            "url": "/model/pla/pta/request_validacao_central.php",
            "dataType": 'html',
            "data": {
                acao: "retornaItens",
                dados: Dados
            },
            "success": function (response) {                                                                              
             
                $(".tabelasItens").html(response);     
                
                var colunaEscondida = [3];                
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
    
    listaItens();
    
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
            "url": "/model/pla/pta/request_validacao_central.php",
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
    
    $('body').on('click', '.btn-envio-central', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {             
            e.preventDefault();                        
            var $this = $(this);
            $(".btn-enviar-central").val($this.val());
            $(".modalTipoGastoCategoria").text($this.attr('tipo')+" - "+$this.attr('central'));
            $("#modalEnvio").modal('show');
            
        }
    });
    
    
    $('#modalEnvio').on('hidden.bs.modal', function (e) {                            
        $(".modalMsgEnvioCentral").val(" ");
    });
    
    $('body').on('click', '.btn-enviar-central', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();                        
            var $this = $(this);
            $this.prop("disabled", true);
            var Dados = {
                pas : $("#pas").val(),
                mensagem: $('.modalMsgEnvioCentral').val(),
                id: $this.val()                
            }
            
            if(Dados.pas == 0 || Dados.id == 0){
                $('#modalEnvio').modal('hide');
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;                
            }
                        
            $.ajax({
                "url": "/model/pla/pta/request_validacao_central.php",
                "dataType": "html",
                "data": {
                    "acao": "enviarCentral",
                    "dados": Dados
                },
                "success": function (response) {                 
                    
                    if (response.trim() == "SessaoExpirada") {
                        $('#modalEnvio').modal('hide');
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        $('#modalEnvio').modal('hide');
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        console.log(response);
                        $this.prop("disabled", false);
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
                            console.log(response);
                            $('#modalEnvio').modal('hide');
                            func.modalAlert(func.msgErroPadrao);
                            $this.prop("disabled", false);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $('#modalEnvio').modal('hide');
                            func.modalAlert(response.msg);
                            $this.prop("disabled", false);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        $('#modalEnvio').modal('hide');
                        func.modalAlert(response.msg, 'primary');
                        func.fechaModalReload();
                        $this.prop("disabled", false);
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        $('#modalEnvio').modal('hide');
                        func.modalAlert(func.msgErroPadrao);
                        $this.prop("disabled", false);
                        return false;
                    }
                },
                "error": function (response) {
                    console.log(response);
                    $('#modalEnvio').modal('hide');
                    func.modalAlert(func.msgErroPadrao);
                    $this.prop("disabled", false);
                    return false;
                }
            });            
            $this.prop("disabled", false);            
        }
    });
        

    
   
    


});
