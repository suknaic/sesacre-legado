$(document).ready(function () {

    func = new Funcoes();

    function listaPasLiberacao() {               
        
        $.ajax({
            "url": "/model/pla/pas_liberacao/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaPasParaLiberar",
                ano: $("#ano option:selected").val()
            },
            "success": function (response) {             
                func.carregaTabelaPadrao('tabela', response, [2], true);
            }
        });
    }
    func.carregaTabelaPadrao('tabela', null, [2], false);
    listaPasLiberacao();          
    
    $('body').on('change', '#ano', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);
            listaPasLiberacao();            
        }
    });
       
    $('body').on('click', '.btn-informacoes', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);
            var id = $this.val();
            
            $.ajax({
                "url": "/model/pla/pas_liberacao/request.php",
                "dataType": 'html',
                "data": {
                    acao: "informacoes",                    
                    id: id
                },
                "success": function (response) {                                 
                    $("#modalMensagem").find('.modal-body').html(response);
                    $("#modalMensagem").modal('show');
                }
            });                                    
        }
    });
    
    $('body').on('click', '.btn-liberar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);
            var id = $this.val();
            $(".btn-libera").val(id);            
            $("#modalLiberar").modal('show');                        
        }
    });
    
    $('body').on('click', '.btn-bloquear', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);
            var id = $this.val();
            $(".btn-bloqueia").val(id);            
            $("#modalBloquear").modal('show');                        
        }
    });
    
    $('body').on('click', '.btn-libera', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                                    
            var $this = $(this);
            $this.prop("disabled", true);            
            
            var Dados = {                
                id : $this.val(),
                msg : $(".modalMsgLiberar").val()                
            }
            
            if(Dados.pas == 0){
                $('#modalLiberar').modal('hide');
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;    
            }
                        
            $.ajax({
                "url": "/model/pla/pas_liberacao/request.php",
                "dataType": "html",
                "data": {
                    "acao": "liberarPas",
                    "dados": Dados
                },
                "success": function (response) {                    
                    
                    if (response.trim() == "SessaoExpirada") {
                        $('#modalLiberar').modal('hide');
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        $('#modalLiberar').modal('hide');
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
                            $('#modalLiberar').modal('hide');
                            func.modalAlert(func.msgErroPadrao);
                            $this.prop("disabled", false);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $('#modalLiberar').modal('hide');
                            func.modalAlert(response.msg);
                            $this.prop("disabled", false);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        $('#modalLiberar').modal('hide');
                        func.modalAlert(response.msg, 'success');
                        func.fechaModalReload();                                            
                        $this.prop("disabled", false);
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        $('#modalLiberar').modal('hide');
                        func.modalAlert(func.msgErroPadrao);
                        $this.prop("disabled", false);
                        return false;
                    }
                },
                "error": function (response) {
                    console.log(response);
                    $('#modalLiberar').modal('hide');
                    func.modalAlert(func.msgErroPadrao);
                    $this.prop("disabled", false);
                    return false;
                }
            });                                         
            $this.prop("disabled", false);
        }
    });
    
    $('body').on('click', '.btn-bloqueia', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                                    
            var $this = $(this);
            $this.prop("disabled", true);            
            
            var Dados = {                
                id : $this.val(),
                msg : $(".modalMsgBloquear").val()                
            }
            
            if(Dados.pas == 0){
                $('#modalLiberar').modal('hide');
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;    
            }
                        
            $.ajax({
                "url": "/model/pla/pas_liberacao/request.php",
                "dataType": "html",
                "data": {
                    "acao": "bloquearPas",
                    "dados": Dados
                },
                "success": function (response) {                    
                    
                    if (response.trim() == "SessaoExpirada") {
                        $('#modalBloquear').modal('hide');
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        $('#modalBloquear').modal('hide');
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
                            $('#modalBloquear').modal('hide');
                            func.modalAlert(func.msgErroPadrao);
                            $this.prop("disabled", false);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $('#modalBloquear').modal('hide');
                            func.modalAlert(response.msg);
                            $this.prop("disabled", false);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        $('#modalBloquear').modal('hide');
                        func.modalAlert(response.msg, 'success');
                        func.fechaModalReload();                                            
                        $this.prop("disabled", false);
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        $('#modalBloquear').modal('hide');
                        func.modalAlert(func.msgErroPadrao);
                        $this.prop("disabled", false);
                        return false;
                    }
                },
                "error": function (response) {
                    console.log(response);
                    $('#modalBloquear').modal('hide');
                    func.modalAlert(func.msgErroPadrao);
                    $this.prop("disabled", false);
                    return false;
                }
            });                                         
            $this.prop("disabled", false);
        }
    });
       
       
});
