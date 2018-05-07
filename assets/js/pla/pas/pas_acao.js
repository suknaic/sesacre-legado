$(document).ready(function () {

    func = new Funcoes();
             
   
    $('body').on('change', '#proj_ppa_ati', function (e, tipo, eixo, acao) {        
        var Dados = {            
            id : $('#proj_ppa_ati option:selected').val()
        }   
        var enc = JSON.stringify(Dados);              
        $.ajax({
            "url": "/model/pla/pas/request_acao.php",
            "dataType": 'html',
            "data": {
                acao: "retornaSelectEixo",
                dados: enc
            },
            "success": function (response) {                  
                $('#eixo').html(response);                                
                if(tipo == "editar"){
                    $('#eixo').val(eixo);                    
                    $("#eixo").trigger('change', ['editar', acao]);                        
                }else{
                    $("#eixo").trigger('change');
                }              
            }
        });         
    });
    
    $('body').on('change', '#eixo', function (e, tipo, acao) {        
        var Dados = {            
            id : $('#eixo option:selected').val(),
            pas: $('#pas').val()
        }   
        var enc = JSON.stringify(Dados);              
        $.ajax({
            "url": "/model/pla/pas/request_acao.php",
            "dataType": 'html',
            "data": {
                acao: "retornaSelectAcao",
                dados: enc
            },
            "success": function (response) {                 
                $('#acao').html(response);                 
                if(tipo == "editar"){
                    $('#acao').val(acao);                                                            
                }
                $("#acao").trigger('change');
            }
        });         
    });
    
    $('body').on('change', '#acao', function (e) {        
        var Dados = {            
            id : $('#acao option:selected').val()            
        }   
        if(Dados.id == 0 || Dados.id == ""){        
            $('#infoAcao').html(" ");
            return false;
        }        
        var enc = JSON.stringify(Dados);              
        $.ajax({
            "url": "/model/pla/pas/request_acao.php",
            "dataType": 'html',
            "data": {
                acao: "retornaDadosAcao",
                dados: enc
            },
            "success": function (response) {                                       
                $('#infoAcao').html(response);             
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
                acao: "retornaPasAcao",
                dados: Dados
            },
            "success": function (response) {                
                func.carregaTabelaPadrao('tabela', response, [4], true);
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
                pas: $("#pas").val(),
                ppa_proj_ati: $("#proj_ppa_ati option:selected").val(),
                acao: $("#acao option:selected").val(),
                parceria: $("#parceria").val(),
                meta: $("#meta").val(),
                indicador: $("#indicador").val(),                
            }
            
            if (Dados.pas == "0" || Dados.ppa_proj_ati == "0" || Dados.acao == "0") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }
                       
            $.ajax({
                "url": "/model/pla/pas/request_acao.php",
                "dataType": "html",
                "data": {
                    "acao": "cad",
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
                        $('.modal-alert').on('hidden.bs.modal', function (e) {                            
                            $("#acao").val(0);
                            $("#parceria").val("");
                            $("#meta").val("");
                            $("#indicador").val("");
                            $("#infoAcao").html(" ");                                                        
                        });
                        lista();
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
    
    
    $('body').on('click', '.btn-editar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            
            var Dados = {                
                ppa_proj_ati: $("#proj_ppa_ati option:selected").val(),
                acao: $("#acao option:selected").val(),
                parceria: $("#parceria").val(),
                meta: $("#meta").val(),
                indicador: $("#indicador").val(),      
                id: $this.val()
            }
            
            if (Dados.pas == "0" || Dados.ppa_proj_ati == "0" || Dados.acao == "0"
                    || Dados.id == "" || Dados.id == 0) {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "/model/pla/pas/request_acao.php",
                "dataType": "html",
                "data": {
                    "acao": "edt",
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
                            "acao": "rem",
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
                acao: "retornaDadosEdicao",
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
                    
                    $("#parceria").val(info.parceria);
                    $("#meta").val(info.meta);
                    $("#indicador").val(info.indicador);   
                    $("#proj_ppa_ati").val(info.ppa_proj_ati);
                    $('#proj_ppa_ati').trigger('change', ['editar', info.eixo, info.acao]);                                        
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
   

    $('body').on('click', '.btn-nova-acao', function (e) {
        window.location.href = "pas_acao_novo.php?token="+$("#pas").val();         
    });


});
