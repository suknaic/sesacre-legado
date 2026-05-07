$(document).ready(function () {

    func = new Funcoes();
             
   
    $('body').on('change', '#diretriz', function (e, tipo, objetivo) {        
        var Dados = {            
            id : $('#diretriz option:selected').val()
        }   
        if(Dados.id == 0 && Dados.id == ""){        
            return false;
        }        
        var enc = JSON.stringify(Dados);      
        
        $.ajax({
            "url": "/model/pla/pas/request_acao.php",
            "dataType": 'html',
            "data": {
                acao: "retornaSelectObjetivoNovo",
                dados: enc
            },
            "success": function (response) {    
                $('#objetivo').html(response);
                
                if(tipo == "editar"){
                    $('#objetivo').val(objetivo);                                                      
                }
              
            }
        });         
    });
    
    $('body').on('change', '#eixo', function (e, tipo, diretriz, objetivo) {        
        var Dados = {            
            id : $('#eixo option:selected').val()            
        }   
        if(Dados.id == 0 && Dados.id == ""){        
            return false;
        }        
        var enc = JSON.stringify(Dados);      
        
        $.ajax({
            "url": "/model/pla/pas/request_acao.php",
            "dataType": 'html',
            "data": {
                acao: "retornaSelectDiretrizNovo",
                dados: enc
            },
            "success": function (response) {                 
                $('#diretriz').html(response); 
                
                if(tipo == "editar"){
                    $('#diretriz').val(diretriz);      
                    $("#diretriz").trigger('change', ['editar', objetivo]);                                      
                }else{
                    $("#diretriz").trigger('change');     
                }
            }
        });         
    });
    
       
    function lista() {        
        var Dados = {            
            pas : $("#pas").val()
        }                
        $.ajax({
            "url": "/model/pla/pas/request_acao.php",
            "dataType": 'html',
            "data": {
                acao: "retornaAcoesUnidade",
                dados: Dados
            },
            "success": function (response) {                
                func.carregaTabelaPadrao('tabela', response, [1], true);
            }
        });
    }
    lista();
              
   $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var Dados = {
                pes: $("#pes").val(),
                objetivo: $("#objetivo option:selected").val(),
                acao: $("#acao").val(),                
                meta: $("#meta").val(),
                indicador: $("#indicador").val(),
                lotacao: $("#lotacao").val()
            }
            
            if (Dados.pes == "0" || Dados.objetivo == "0") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }            
             
            $.ajax({
                "url": "/model/pla/pas/request_acao.php",
                "dataType": "html",
                "data": {
                    "acao": "cadNovoAcao",
                    "dados": Dados
                },
                "success": function (response) {            
                    if (response.trim() == "SessaoExpirada") {
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        console.log(response);
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
                            console.log(response);
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        func.modalAlert(response.msg, 'primary');
                        func.fechaModalReload();                        
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    }
                },
                "error": function (response) {
                    $this.prop("disabled", false);
                    console.log(response);
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            });

            $this.prop("disabled", false);
        }
    });
    
    
    $('body').on('click', '.btn-editar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            
            var Dados = {
                pes: $("#pes").val(),
                objetivo: $("#objetivo option:selected").val(),
                acao: $("#acao").val(),                
                meta: $("#meta").val(),
                indicador: $("#indicador").val(),   
                lotacao: $("#lotacao").val(),
                id: $this.val()
            }
            
            if (Dados.pes == "0" || Dados.objetivo == "0"
                    || Dados.id == "" || Dados.id == 0) {         
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "/model/pla/pas/request_acao.php",
                "dataType": "html",
                "data": {
                    "acao": "edtNovoAcao",
                    "dados": Dados
                },
                "success": function (response) {
                    $this.prop("disabled", false);
                    if (response.trim() == "SessaoExpirada") {
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        console.log(response);
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
                            console.log(response);
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        func.modalAlert(response.msg, 'primary');
                        func.fechaModalReload()                        
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    }
                },
                "error": function (response) {
                    $this.prop("disabled", false);
                    console.log(response);
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            });

            $this.prop("disabled", false);
        }
    });
    
    $('body').on('click', '.btn-remover', function (e) {

        var $this = $(this);
        var id = $this.val();
        var item = $this.attr("nome");

        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem Certeza que deseja continuar com a Exclusão do Item <span class="text-danger">' + item + '</span>?',
            buttons: {
                'cancel': {
                    label: 'Não',
                    className: 'btn-default btn-rounded'
                },
                'confirm': {
                    label: 'Sim',
                    className: 'btn-primary btn-rounded'
                }
            },
            callback: function (result) {
                if (result) {
                    var Dados = {
                        id: id
                    }

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/pla/pas/request_acao.php",
                        "dataType": "html",
                        "data": {
                            "acao": "remNovoAcao",
                            "dados": Dados
                        },
                        "success": function (response) {
                            if (response.trim() == "SessaoExpirada") {
                                func.modalAlert(func.msgSemPermissao);
                                return false;
                            }

                            try {
                                response = JSON.parse(response);
                            } catch (e) {
                                func.modalAlert(func.msgErroPadrao);
                                console.log("Parse JSON");
                                console.log(response);
                                return false;
                            }

                            if (response.tipoMsg === "Erro") {
                                if (response.tipoExibicao === "console") {
                                    console.log('Console Mensagem');
                                    console.log(response);
                                    func.modalAlert(func.msgErroPadrao);
                                    return false;
                                } else if (response.tipoExibicao === "alert") {
                                    func.modalAlert(response.msg);
                                    return false;
                                }
                            } else if (response.tipoMsg === "ok") {
                                func.modalAlert(response.msg, 'primary');
                                func.fechaModalReload()  
                                return false;
                            } else {
                                console.log('Ultimo else');
                                console.log(response);
                                func.modalAlert(func.msgErroPadrao);
                                return false;
                            }
                        },
                        "error": function (response) {
                            console.log(response);
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        }
                    });


                }
            }
        });

    });
    
    
    $('body').on('click', '.btn-edit', function(e){
        
        var Dados = {            
            id : $(this).val()            
        }          
        
        $.ajax({
            "url": "/model/pla/pas/request_acao.php",
            "dataType": 'html',
            "data": {
                acao: "retornaDadosEdicaoNovoAcao",
                dados: Dados
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
                        window.location.href = "index.php?token="+Dados.pas;                        
                    });
                }
                if(response.tipoMsg == "ok"){
                    var info = response.msg;
                    console.log(info);
                    $("#acao").val(info.acao);
                    $("#meta").val(info.meta);
                    $("#indicador").val(info.indicador);   
                    $("#eixo").val(info.eixo);
                    $('#eixo').trigger('change', ['editar', info.diretriz, info.objetivo]);                                        
                    $(".btn-salvar").hide();
                    $(".btn-editar").show();
                    $(".btn-editar").val(Dados.id);
                    $('html, body').animate({
                        scrollTop: $('#page-content').offset().top + 'px'
                    }, 'slow');
                    
                }                                

            }
        });
        
    });    
    
    $('body').on('click', '#informacoes', function(e){
        var idPas = $("#pas").val();        
        $.ajax({
            "url": "/model/pla/pas/request_acao.php",
            "dataType": 'html',
            "data": {
                acao: "listaInfo",
                pas: idPas
            },
            "success": function (response) {
                $('#info-2').find('span').html(response);                
            }
        });                
    });
         
    $('body').on('click', '.btn-limpar', function (e) {
        location.reload();
    });
   
   

});
