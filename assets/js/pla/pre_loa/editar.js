$(document).ready(function () {

    func = new Funcoes();       
    
    //Masca para valor
    $("body").on("focus", "#valor", function () {
        $(this).priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
            centsLimit: 4
        });
    });
    
    function lista(){
        
        var ano = $("#ano").val();
        
        $.ajax({
            "url": "/model/pla/pre_loa/request_editar.php",
            "dataType": 'html',
            "data": {
                acao: "valores",
                ano: ano
            },
            "success": function (response) {         
                $("#informacao").html(response);                                    
            }
        });        
    }
    
    lista();
    
    $('body').on('click', '.btn-add', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                                    
            $("#modalValor").modal('show');
        }
    });
    
    $('body').on('click', '.registro', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);
            var id = $this.attr('id');
            
            $.ajax({
                "url": "/model/pla/pre_loa/request_editar.php",
                "dataType": 'html',
                "data": {
                    acao: "retornaEdicao",
                    id: id
                },
                "success": function (response) {    
                                        
                    try {
                        response = JSON.parse(response);
                    } catch (e) {                    
                        console.log(response);
                        return false;
                    }


                    if(response.tipoMsg == "nao_encontrou"){
                        func.modalAlert(func.msgRegistroNaoEncontrado);
                        $('.modal-alert').on('hidden.bs.modal', function (e) {                        
                            location.reload();
                        });
                    }
                    if(response.tipoMsg == "ok"){

                        var info = response.msg;                        
                        $("#programa").val(info.id_programa_trabalho);
                        $("#despesa").val(info.id_despesa_elemento);
                        $("#fonte").val(info.id_fonte);
                        $("#valor").val(info.vl_pre_loa_valores);
                        $("#valor").trigger("focus");                        
                        $(".btn-salvar").val(info.id_pre_loa_valores);
                        $(".btn-salvar").removeClass('btn-success').addClass('btn-info').text("Salvar Edição");   
                        $(".btn-remover").show();
                        $("#modalValor").modal('show');
                        
                    }                                        
                    
                }
            });                                                               
        }
    });
    
    $('#modalValor').on('hidden.bs.modal', function (e) {
        $("#programa").val(0);
        $("#despesa").val(0);
        $("#fonte").val(0);
        $("#valor").val("");
        $(".btn-salvar").val(0);
        $(".btn-salvar").removeClass('btn-info').addClass('btn-success').text("Salvar");        
        $(".btn-remover").hide();
    });
    
    
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);
            
            $this.prop("disabled", true);
            var Dados = {
                id: $this.val(),
                ano: $("#ano").val(),
                programa : $("#programa option:selected").val(),
                despesa : $("#despesa option:selected").val(),
                fonte : $("#fonte option:selected").val(),
                valor: $('#valor').val()                           
            }
            
            if(Dados.programa == 0 || Dados.despesa == 0
                    || Dados.fonte == 0 || Dados.ano == 0 || Dados.ano == ""){
                $('#modalValor').modal('hide');
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;                
            }
                        
            $.ajax({
                "url": "/model/pla/pre_loa/request_editar.php",
                "dataType": "html",
                "data": {
                    "acao": "salvarRegistro",
                    "dados": Dados
                },
                "success": function (response) {                 
                    
                    
                    if (response.trim() == "SessaoExpirada") {
                        $('#modalValor').modal('hide');
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        $('#modalValor').modal('hide');
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        console.log(response);                        
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
                            console.log(response);
                            $('#modalValor').modal('hide');
                            func.modalAlert(func.msgErroPadrao);                            
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $('#modalValor').modal('hide');
                            func.modalAlert(response.msg);                            
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        $('#modalValor').modal('hide');
                        func.modalAlert(response.msg, 'primary');
                        func.fechaModalReload();                        
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        $('#modalValor').modal('hide');
                        func.modalAlert(func.msgErroPadrao);                        
                        return false;
                    }
                },
                "error": function (response) {
                    console.log(response);
                    $('#modalValor').modal('hide');
                    func.modalAlert(func.msgErroPadrao);                    
                    return false;
                },
                "complete": function(){
                    $this.prop("disabled", false);
                }
            });            
            
            
        }
    });
    
    $('body').on('click', '.btn-remover', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);
            
            $this.prop("disabled", true);
            var Dados = {
                id: $(".btn-salvar").val()                                          
            }
            
            if(Dados.id == 0 || Dados.id == ""){
                $('#modalValor').modal('hide');
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;                
            }
                        
            $.ajax({
                "url": "/model/pla/pre_loa/request_editar.php",
                "dataType": "html",
                "data": {
                    "acao": "removerRegistro",
                    "dados": Dados
                },
                "success": function (response) {                 
                    
                    
                    if (response.trim() == "SessaoExpirada") {
                        $('#modalValor').modal('hide');
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        $('#modalValor').modal('hide');
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        console.log(response);                        
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
                            console.log(response);
                            $('#modalValor').modal('hide');
                            func.modalAlert(func.msgErroPadrao);                            
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $('#modalValor').modal('hide');
                            func.modalAlert(response.msg);                            
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        $('#modalValor').modal('hide');
                        func.modalAlert(response.msg, 'primary');
                        func.fechaModalReload();                        
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        $('#modalValor').modal('hide');
                        func.modalAlert(func.msgErroPadrao);                        
                        return false;
                    }
                },
                "error": function (response) {
                    console.log(response);
                    $('#modalValor').modal('hide');
                    func.modalAlert(func.msgErroPadrao);                    
                    return false;
                },
                "complete": function(){
                    $this.prop("disabled", false);
                }
            });            
            
            
        }
    });
    
    $('body').on('click', '.btn-desativar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);
            
            $this.prop("disabled", true);
            var Dados = {
                ano: $("#ano").val(),
                msg: $(".modalMsgEnvio").val()
            }
            
            if(Dados.ano == 0 || Dados.ano == ""){
                $('#modalDesativar').modal('hide');
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;                
            }            
                        
            $.ajax({
                "url": "/model/pla/pre_loa/request_editar.php",
                "dataType": "html",
                "data": {
                    "acao": "desativar",
                    "dados": Dados
                },
                "success": function (response) {                 
                    
                    
                    if (response.trim() == "SessaoExpirada") {
                        $('#modalDesativar').modal('hide');
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        $('#modalDesativar').modal('hide');
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        console.log(response);                        
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
                            console.log(response);
                            $('#modalDesativar').modal('hide');
                            func.modalAlert(func.msgErroPadrao);                            
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $('#modalDesativar').modal('hide');
                            func.modalAlert(response.msg);                            
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        $('#modalDesativar').modal('hide');
                        func.modalAlert(response.msg, 'primary');
                        func.fechaModalReload();                        
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        $('#modalDesativar').modal('hide');
                        func.modalAlert(func.msgErroPadrao);                        
                        return false;
                    }
                },
                "error": function (response) {
                    console.log(response);
                    $('#modalDesativar').modal('hide');
                    func.modalAlert(func.msgErroPadrao);                    
                    return false;
                },
                "complete": function(){
                    $this.prop("disabled", false);
                }
            });            
            
            
        }
    });
       
});
