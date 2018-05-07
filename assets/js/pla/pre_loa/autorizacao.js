$(document).ready(function () {

    func = new Funcoes();              
                     
    function lista(){
        
        var ano = $("#ano").val();
        
        $.ajax({
            "url": "/model/pla/pre_loa/request_autorizacao.php",
            "dataType": 'html',
            "data": {
                acao: "valores",
                ano: ano
            },
            "success": function (response) {         
                $("#informacao").html(response);                    
                $("#sesacre-xlsx").show();
            }
        });        
    }
  
   // listarAutorizacaoPreLoa();
   
   
   function abreModalAno(){
        
        $.ajax({
            "url": "/model/pla/pre_loa/request_autorizacao.php",
            "dataType": 'html',
            "data": {
                acao: "verificaAutorizacaoPreLoa"        
            },
            "success": function (response) {                  
                $("#bodyModalTabelaPreLoa").html(response);                    
                $("#modalTabelaPreLoa").modal('show');                
            }
        });           
    }
    if($("#ano").val() == 0){
        abreModalAno();
    }else{
        lista();
    }    
    
    $('body').on('click', '.linha', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                                               
            window.location.href = "autorizacao.php?token="+$(this).attr('valor');
        }
    });
                                
    
    
    $('body').on('click', '.btn-autorizar', function (e) {
        
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();                        
            var $this = $(this);
            $this.prop("disabled", true);
            var Dados = {
                ano : $("#ano").val(),
                mensagem: $('.modalMsgAutorizar').val()                           
            }
            
            if(Dados.ano == 0 ){
                $('#modalAutorizar').modal('hide');
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;                
            }
                        
                        
            $.ajax({
                "url": "/model/pla/pre_loa/request_autorizacao.php",
                "dataType": "html",
                "data": {
                    "acao": "autorizar",
                    "dados": Dados
                },
                "success": function (response) {                 
                    
                    if (response.trim() == "SessaoExpirada") {
                        $('#modalAutorizar').modal('hide');
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        $('#modalAutorizar').modal('hide');
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
                            $('#modalAutorizar').modal('hide');
                            func.modalAlert(func.msgErroPadrao);
                            $this.prop("disabled", false);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $('#modalAutorizar').modal('hide');
                            func.modalAlert(response.msg);
                            $this.prop("disabled", false);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        $('#modalAutorizar').modal('hide');
                        func.modalAlert(response.msg, 'success');
                        func.fechaModalReload();
                        $this.prop("disabled", false);
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        $('#modalAutorizar').modal('hide');
                        func.modalAlert(func.msgErroPadrao);
                        $this.prop("disabled", false);
                        return false;
                    }
                },
                "error": function (response) {
                    console.log(response);
                    $('#modalAutorizar').modal('hide');
                    func.modalAlert(func.msgErroPadrao);
                    $this.prop("disabled", false);
                    return false;
                }
            });            
            $this.prop("disabled", false);            
        }
    });
    
    $('body').on('click', '.btn-retornar', function (e) {
        
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();                        
            var $this = $(this);
            $this.prop("disabled", true);
            var Dados = {
                ano : $("#ano").val(),
                mensagem: $('.modalMsgRetornar').val()                           
            }
            
            if(Dados.ano == 0 ){
                $('#modalRetornar').modal('hide');
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;                
            }
                        
                        
            $.ajax({
                "url": "/model/pla/pre_loa/request_autorizacao.php",
                "dataType": "html",
                "data": {
                    "acao": "retornar",
                    "dados": Dados
                },
                "success": function (response) {                 
                    
                    if (response.trim() == "SessaoExpirada") {
                        $('#modalRetornar').modal('hide');
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        $('#modalRetornar').modal('hide');
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
                            $('#modalRetornar').modal('hide');
                            func.modalAlert(func.msgErroPadrao);
                            $this.prop("disabled", false);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $('#modalRetornar').modal('hide');
                            func.modalAlert(response.msg);
                            $this.prop("disabled", false);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        $('#modalRetornar').modal('hide');
                        func.modalAlert(response.msg, 'success');
                        func.fechaModalReload();
                        $this.prop("disabled", false);
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        $('#modalRetornar').modal('hide');
                        func.modalAlert(func.msgErroPadrao);
                        $this.prop("disabled", false);
                        return false;
                    }
                },
                "error": function (response) {
                    console.log(response);
                    $('#modalRetornar').modal('hide');
                    func.modalAlert(func.msgErroPadrao);
                    $this.prop("disabled", false);
                    return false;
                }
            });            
            $this.prop("disabled", false);            
        }
    });
    
    
    $('body').on('click', '#abrirModalAno', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            $.ajax({
                "url": "/model/pla/pre_loa/request_autorizacao.php",
                "dataType": 'html',
                "data": {
                    acao: "retornarAnos"        
                },
                "success": function (response) {                  
                    $("#modalAno").find('.modal-body').html(response);                    
                    $("#modalAno").modal('show');                
                }
            });                        
        }
    });
    
    
    $('body').on('click', '.linhaAno', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                                               
            window.location.href = "visualizar_preloa.php?token="+$(this).attr('valor');
        }
    });
    
    
    
       
});

function exportExcel(format, ano) {
    return ExcellentExport.convert({
        anchor: 'sesacre-' + format,
        filename: 'pre_loa-'+ano,
        format: format
    }, [{
        name: 'Pre-LOA',
        from: {
            table: 'tabela'
        }
    }]);
}
