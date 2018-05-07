$(document).ready(function () {

    func = new Funcoes();

    function listaTabelaTipoGastoMaterial() {
                
        if($("#lotacao").val() == 0 || $("#pas").val() == 0){
            return;
        }
        
        $.ajax({
            "url": "/model/pla/central/request_validar.php",
            "dataType": 'html',
            "data": {
                acao: "listaTbParaValidacao",
                lotacao: $("#lotacao").val(),
                pas: $("#pas").val(),
                central: $("#central").val()
            },
            "success": function (response) {  
                //console.log(response);
//                if(destroi == true){           
//                    var oTable = $('.tabela-itens-salvo').dataTable();
//                    oTable.fnDestroy();                  
//                }                                                  
             
                $(".tabelasItens").html(response);     
                
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
    listaTabelaTipoGastoMaterial();           
       
       
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
                "url": "/model/pla/central/request_validar.php",
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
    
    $('body').on('click', '.btn-concordo-central', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);
            
            var id = $this.val();
            var tipo_gasto = $this.attr('tipo');
            var lotacao = $("#lotacao").val();
            var pas = $("#pas").val();
                                    
            
            $(".btn-enviar-central-concordo").val(id);
            $(".btn-enviar-central-concordo").attr('lotacao', lotacao);
            $(".btn-enviar-central-concordo").attr('pas', pas);
                        
            $("#modalConcordo").modal('show');
            $(".modalMsgConcordo").focus();
            $(".modalTipoGastoCategoria").text(tipo_gasto);                                    
        }
    });
    
    $('#modalConcordo').on('hidden.bs.modal', function (e) {  
        $(".modalMsgConcordo").val(" ");        
        $(".btn-enviar-central-concordo").val(0);
        $(".btn-enviar-central-concordo").attr('lotacao', 0);
        $(".btn-enviar-central-concordo").attr('pas', 0);
        $(".modalTipoGastoCategoria").text(" ");
    });
    
    $('body').on('click', '.btn-enviar-central-concordo', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                                    
            var $this = $(this);
            $this.prop("disabled", true);            
            
            var Dados = {
                id : $this.val(),
                lotacao : $this.attr('lotacao'),
                pas : $this.attr('pas'),
                msg : $(".modalMsgConcordo").val()                
            }
            
            if(Dados.id == 0 && Dados.lotacao == 0
                    && Dados.pas == 0){
                $('#modalConcordo').modal('hide');
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;    
            }
                        
            $.ajax({
                "url": "/model/pla/central/request_validar.php",
                "dataType": "html",
                "data": {
                    "acao": "concordo",
                    "dados": Dados
                },
                "success": function (response) {                    
                    
                    if (response.trim() == "SessaoExpirada") {
                        $('#modalTitulo').modal('hide');
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        $('#modalConcordo').modal('hide');
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
                            $('#modalConcordo').modal('hide');
                            func.modalAlert(func.msgErroPadrao);
                            $this.prop("disabled", false);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $('#modalConcordo').modal('hide');
                            func.modalAlert(response.msg);
                            $this.prop("disabled", false);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        $('#modalConcordo').modal('hide');
                        func.modalAlert(response.msg, 'primary');
                        func.fechaModalReload();
                        $this.prop("disabled", false);
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        $('#modalConcordo').modal('hide');
                        func.modalAlert(func.msgErroPadrao);
                        $this.prop("disabled", false);
                        return false;
                    }
                },
                "error": function (response) {
                    console.log(response);
                    $('#modalConcordo').modal('hide');
                    func.modalAlert(func.msgErroPadrao);
                    $this.prop("disabled", false);
                    return false;
                }
            });                                         
            $this.prop("disabled", false);
        }
    });
    
    $('body').on('click', '.btn-discordo-central', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);
            
            var id = $this.val();
            var tipo_gasto = $this.attr('tipo');
            var lotacao = $("#lotacao").val();
            var pas = $("#pas").val();
                                    
            
            $(".btn-enviar-central-discordo").val(id);
            $(".btn-enviar-central-discordo").attr('lotacao', lotacao);
            $(".btn-enviar-central-discordo").attr('pas', pas);
            
            $("#modalDiscordo").modal('show');
            $(".modalMsgDiscordo").focus();
            $(".modalTipoGastoCategoria").text(tipo_gasto);                                    
        }
    });
    
    $('#modalDiscordo').on('hidden.bs.modal', function (e) {
        $(".modalMsgDiscordo").val(" ");        
        $(".btn-enviar-central-discordo").val(0);
        $(".btn-enviar-central-discordo").attr('lotacao', 0);
        $(".btn-enviar-central-discordo").attr('pas', 0);
        $(".modalTipoGastoCategoria").text(" ");
    });
    
    $('body').on('click', '.btn-enviar-central-discordo', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                                    
            var $this = $(this);
            $this.prop("disabled", true);            
            
            var Dados = {
                id : $this.val(),
                lotacao : $this.attr('lotacao'),
                pas : $this.attr('pas'),
                msg : $(".modalMsgDiscordo").val()                
            }
            
            if(Dados.id == 0 && Dados.lotacao == 0
                    && Dados.pas == 0){
                $('#modalDiscordo').modal('hide');
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;    
            }
                        
            $.ajax({
                "url": "/model/pla/central/request_validar.php",
                "dataType": "html",
                "data": {
                    "acao": "discordo",
                    "dados": Dados
                },
                "success": function (response) {                    
                    
                    if (response.trim() == "SessaoExpirada") {
                        $('#modalDiscordo').modal('hide');
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        $('#modalDiscordo').modal('hide');
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
                            $('#modalDiscordo').modal('hide');
                            func.modalAlert(func.msgErroPadrao);
                            $this.prop("disabled", false);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $('#modalDiscordo').modal('hide');
                            func.modalAlert(response.msg);
                            $this.prop("disabled", false);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        $('#modalDiscordo').modal('hide');
                        func.modalAlert(response.msg, 'primary');
                        func.fechaModalReload();
                        $this.prop("disabled", false);
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        $('#modalDiscordo').modal('hide');
                        func.modalAlert(func.msgErroPadrao);
                        $this.prop("disabled", false);
                        return false;
                    }
                },
                "error": function (response) {
                    console.log(response);
                    $('#modalDiscordo').modal('hide');
                    func.modalAlert(func.msgErroPadrao);
                    $this.prop("disabled", false);
                    return false;
                }
            });                                         
            $this.prop("disabled", false);
        }
    });
    
       
});
