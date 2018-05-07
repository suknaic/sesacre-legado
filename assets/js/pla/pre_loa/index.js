$(document).ready(function () {

    func = new Funcoes();              
                     
    function verificaSituacaoPreLoa(){
        
        var ano = $("#ano").val();
        
        $.ajax({
            "url": "/model/pla/pre_loa/request.php",
            "dataType": 'html',
            "data": {
                acao: "verificaSituacaoPreLoa",
                ano: ano
            },
            "success": function (response) {         
                $("#informacao").html(response);                    
            }
        });
    }    
    function abreModalAno(){
        
        var panel = $('.selecaoAno').clone();
                        
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
                    var ano = $(".bootbox").find('.anoSelect option:selected').val();                                                                                 
                    window.location.href = "index.php?token="+ano;
                }
            }
        });                
    }
    if($("#ano").val() == 0){
        abreModalAno();
    }else{
        verificaSituacaoPreLoa();
    }    
    
    $('body').on('click', '.btn-enviar-planejamento', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);            
            $("#modalEnvioPlanejamento").modal('show');                                    
        }
    });
    
    $('body').on('click', '.btn-retornar-planejamento', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);            
            $("#modalRetornoPlanejamento").modal('show');                                    
        }
    });
    
    
    
    
    $('body').on('click', '.btn-envia-planejamento', function (e) {
        
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();                        
            var $this = $(this);
            $this.prop("disabled", true);
            var Dados = {
                ano : $("#ano").val(),
                mensagem: $('.modalMsgEnvio').val()                           
            }
            
            if(Dados.ano == 0 ){
                $('#modalEnvioPlanejamento').modal('hide');
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;                
            }
                        
                        
            $.ajax({
                "url": "/model/pla/pre_loa/request.php",
                "dataType": "html",
                "data": {
                    "acao": "enviarPlanejamento",
                    "dados": Dados
                },
                "success": function (response) {                 
                    
                    if (response.trim() == "SessaoExpirada") {
                        $('#modalEnvioPlanejamento').modal('hide');
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        $('#modalEnvioPlanejamento').modal('hide');
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
                            $('#modalEnvioPlanejamento').modal('hide');
                            func.modalAlert(func.msgErroPadrao);
                            $this.prop("disabled", false);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $('#modalEnvioPlanejamento').modal('hide');
                            func.modalAlert(response.msg);
                            $this.prop("disabled", false);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        $('#modalEnvioPlanejamento').modal('hide');
                        func.modalAlert(response.msg, 'primary');
                        func.fechaModalReload();
                        $this.prop("disabled", false);
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        $('#modalEnvioPlanejamento').modal('hide');
                        func.modalAlert(func.msgErroPadrao);
                        $this.prop("disabled", false);
                        return false;
                    }
                },
                "error": function (response) {
                    console.log(response);
                    $('#modalEnvioPlanejamento').modal('hide');
                    func.modalAlert(func.msgErroPadrao);
                    $this.prop("disabled", false);
                    return false;
                }
            });            
            $this.prop("disabled", false);            
        }
    });
    
    $('body').on('click', '.btn-retorna-planejamento', function (e) {
        
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();                        
            var $this = $(this);
            $this.prop("disabled", true);
            var Dados = {
                ano : $("#ano").val(),
                mensagem: $('.modalMsgRetorno').val()                           
            }
            
            if(Dados.ano == 0 ){
                $('#modalRetornoPlanejamento').modal('hide');
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;                
            }
                        
                        
            $.ajax({
                "url": "/model/pla/pre_loa/request.php",
                "dataType": "html",
                "data": {
                    "acao": "retornarPlanejamento",
                    "dados": Dados
                },
                "success": function (response) {                 
                    
                    if (response.trim() == "SessaoExpirada") {
                        $('#modalRetornoPlanejamento').modal('hide');
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        $('#modalRetornoPlanejamento').modal('hide');
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
                            $('#modalRetornoPlanejamento').modal('hide');
                            func.modalAlert(func.msgErroPadrao);
                            $this.prop("disabled", false);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $('#modalRetornoPlanejamento').modal('hide');
                            func.modalAlert(response.msg);
                            $this.prop("disabled", false);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        $('#modalRetornoPlanejamento').modal('hide');
                        func.modalAlert(response.msg, 'success');
                        func.fechaModalReload();
                        $this.prop("disabled", false);
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        $('#modalRetornoPlanejamento').modal('hide');
                        func.modalAlert(func.msgErroPadrao);
                        $this.prop("disabled", false);
                        return false;
                    }
                },
                "error": function (response) {
                    console.log(response);
                    $('#modalRetornoPlanejamento').modal('hide');
                    func.modalAlert(func.msgErroPadrao);
                    $this.prop("disabled", false);
                    return false;
                }
            });            
            $this.prop("disabled", false);            
        }
    });
    
    
    
    
    
       
});
