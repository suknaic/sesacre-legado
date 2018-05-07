$(document).ready(function () {

    func = new Funcoes();
             
    
    $('body').on('click', '.btn-enviar-valida', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                                    
            var $this = $(this);
            $this.prop("disabled", true);            
            
            var Dados = {                
                pas : $("#pas").val(),
                msg : $(".modalMsgValida").val()                
            }
            
            if(Dados.pas == 0){
                $('#modalValida').modal('hide');
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;    
            }
                        
            $.ajax({
                "url": "/model/pla/pas_validacao/request_validar.php",
                "dataType": "html",
                "data": {
                    "acao": "valida",
                    "dados": Dados
                },
                "success": function (response) {                    
                    
                    if (response.trim() == "SessaoExpirada") {
                        $('#modalValida').modal('hide');
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        $('#modalValida').modal('hide');
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
                            $('#modalValida').modal('hide');
                            func.modalAlert(func.msgErroPadrao);
                            $this.prop("disabled", false);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $('#modalValida').modal('hide');
                            func.modalAlert(response.msg);
                            $this.prop("disabled", false);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        $('#modalValida').modal('hide');
                        func.modalAlert(response.msg, 'success');
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            window.location.href = "index.php";
                        });                        
                        $this.prop("disabled", false);
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        $('#modalValida').modal('hide');
                        func.modalAlert(func.msgErroPadrao);
                        $this.prop("disabled", false);
                        return false;
                    }
                },
                "error": function (response) {
                    console.log(response);
                    $('#modalValida').modal('hide');
                    func.modalAlert(func.msgErroPadrao);
                    $this.prop("disabled", false);
                    return false;
                }
            });                                         
            $this.prop("disabled", false);
        }
    });
    
    $('body').on('click', '.btn-enviar-nao-valida', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                                    
            var $this = $(this);
            $this.prop("disabled", true);            
            
            var Dados = {
                pas : $("#pas").val(),
                msg : $(".modalMsgNaoValida").val()               
            }
            
            if(Dados.pas == 0){
                $('#modalNaoValida').modal('hide');
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;    
            }
                        
            $.ajax({
                "url": "/model/pla/pas_validacao/request_validar.php",
                "dataType": "html",
                "data": {
                    "acao": "naovalida",
                    "dados": Dados
                },
                "success": function (response) {                    
                    
                    if (response.trim() == "SessaoExpirada") {
                        $('#modalNaoValida').modal('hide');
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        $('#modalNaoValida').modal('hide');
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
                            $('#modalNaoValida').modal('hide');
                            func.modalAlert(func.msgErroPadrao);
                            $this.prop("disabled", false);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $('#modalNaoValida').modal('hide');
                            func.modalAlert(response.msg);
                            $this.prop("disabled", false);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        $('#modalNaoValida').modal('hide');
                        func.modalAlert(response.msg, 'primary');
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            window.location.href = "index.php";
                        });
                        $this.prop("disabled", false);
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        $('#modalNaoValida').modal('hide');
                        func.modalAlert(func.msgErroPadrao);
                        $this.prop("disabled", false);
                        return false;
                    }
                },
                "error": function (response) {
                    console.log(response);
                    $('#modalNaoValida').modal('hide');
                    func.modalAlert(func.msgErroPadrao);
                    $this.prop("disabled", false);
                    return false;
                }
            });                                         
            $this.prop("disabled", false);
        }
    });
    
       
});
