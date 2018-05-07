$(document).ready(function () {

    func = new Funcoes();
    
    //Masca para valor
    $("body").on("focus", "#valor", function () {
        $(this).priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
            centsLimit: 2
        });
    });
    
    $("body").on("focus", ".valor", function () {
        $(this).priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
            centsLimit: 2
        });
    });

    function listaTabela(){
        $.ajax({
            "url": "/model/pla/liberacao_fonte/request_liber_fonte.php",
            "dataType": 'json',
            "data": {
                acao: "listaTable",
                id: $("#liberacaoFonte").val()
            },
            "success": function (response) {     
                
                func.carregaTabelaPadraoFoot('tabela', response.msg[0], response.msg[1], [7], true);
                //func.carregaTabelaPadrao('tabela', response, [7], true);
            }
        });
    }
    func.carregaTabelaPadraoFoot('tabela', null, '<tr></tr>', [7]);
    listaTabela();

    $('body').on('click', '#btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var Dados = {
                liberacao_fonte: $("#liberacaoFonte").val(),
                programa: $("#programa option:selected").val(),                
                lotacao: $("#lotacao option:selected").val(),                
                despesa: $("#despesa option:selected").val(),
                valor: $("#valor").val(),
                id: $this.val()
            }                      
            
            if (Dados.liberacao_valor == 0 
                    || Dados.programa == 0 || Dados.liberacao_valor == ""
                    || Dados.lotacao == 0 || Dados.despesa == 0) {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }
                                                       
            $.ajax({
                "url": "/model/pla/liberacao_fonte/request_liber_fonte.php",
                "dataType": "html",
                "data": {
                    "acao": "salvarInicial",
                    "dados": Dados
                },
                "success": function (response) {
                    $this.prop("disabled", false);
                    if (response.trim() == "SessaoExpirada") {
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }
                    console.log(response);
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
                        func.modalAlert(response.msg, 'success');
                        if(Dados.id == "" || Dados.id == 0){
                            $("#valor").val(0);
                            $("#despesa").focus();
                            listaTabela();
                        }else{
                            func.fechaModalReload();
                        }
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
        var item = $this.closest('td').find('.btn-edit').attr("nome");

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
                        "url": "/model/pla/liberacao_fonte/request_liber_fonte.php",
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
                                //console.log("Parse JSON");
                                //console.log(response);
                                return false;
                            }

                            if (response.tipoMsg === "Erro") {
                                if (response.tipoExibicao === "console") {
                                    //console.log('Console Mensagem');
                                    //console.log(response);
                                    func.modalAlert(func.msgErroPadrao);
                                    return false;
                                } else if (response.tipoExibicao === "alert") {
                                    func.modalAlert(response.msg);
                                    return false;
                                }
                            } else if (response.tipoMsg === "ok") {
                                func.modalAlert(response.msg, 'success');
                                func.fechaModalReload();
                                $('.modal-alert').on('hidden.bs.modal', function (e) {
                                    location.reload();
                                });
                                return false;
                            } else {
                                //console.log('Ultimo else');
                                //console.log(response);
                                func.modalAlert(func.msgErroPadrao);
                                return false;
                            }
                        },
                        "error": function (response) {
                            //console.log(response);
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        }
                    });
                }
            }
        });

    });



    $('body').on('click', '.btn-edit', function (e) {
        e.preventDefault();
        var id = $(this).val();

        $('#btn-salvar').val(id);        
        $("#programa").val($(this).attr('programa'));        
        $("#despesa").val($(this).attr('despesa')); 
        $("#lotacao").val($(this).attr('lotacao'));
        $("#valor").val($(this).attr('valor'));                
        
        $("#btn-salvar").removeClass("btn-success");
        $("#btn-salvar").addClass("btn-info");             
        $("#btn-salvar").find("#txtBtn").text("Retificar Inicial");
        $('html, body').animate({
            scrollTop: $('#page-content').offset().top + 'px'
        }, 'slow');        
    });
    $('body').on('click', '.btn-limpar', function (e) {
        location.reload();
    });

    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nome").focus();
    });


    $('body').on('keypress', '#valor', function (e) {
        var key = e.which;
        if (key == 13) {
            $("#btn-salvar").trigger('click');
            return false;
        }
    });


    $('body').on('click', '.btn-suple', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);     
                                    
            $(".local_suple").text($this.closest('tr').find('td:eq(0)').text());
            $(".programa_suple").text($this.closest('tr').find('td:eq(1)').text());
            $(".despesa_suple").text($this.closest('tr').find('td:eq(2)').text());
            $(".inicial_suple").text($this.closest('tr').find('td:eq(3)').text());
            $(".suplementado_suple").text($this.closest('tr').find('td:eq(4)').text());
            $(".total_suple").text($this.closest('tr').find('td:eq(5)').text());            
            $(".btn-salvar-suplementacao").val($this.val());
            $("#modalSuplementado").modal('show');
        }
    });
    
    $('body').on('click', '.btn-reduz', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();                        
            var $this = $(this);     
                                    
            $(".local_suple").text($this.closest('tr').find('td:eq(0)').text());
            $(".programa_suple").text($this.closest('tr').find('td:eq(1)').text());
            $(".despesa_suple").text($this.closest('tr').find('td:eq(2)').text());
            $(".inicial_suple").text($this.closest('tr').find('td:eq(3)').text());
            $(".suplementado_suple").text($this.closest('tr').find('td:eq(4)').text());
            $(".total_suple").text($this.closest('tr').find('td:eq(5)').text());            
            $(".btn-salvar-reduzido").val($this.val());
            $("#modalReduzido").modal('show');
        }
    });


    $('body').on('click', '.btn-salvar-suplementacao', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);
            
            $this.prop("disabled", true);
            var Dados = {
                id: $this.val(),
                valor: $(".valorSuplementado").val(),
                tipo: "suplementar"
            }
            
            if(Dados.id == 0 || Dados.id == ""){
                $('#modalSuplementado').modal('hide');
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;                
            }
                        
            $.ajax({
                "url": "/model/pla/liberacao_fonte/request_liber_fonte.php",
                "dataType": "html",
                "data": {
                    "acao": "suple_reduz",
                    "dados": Dados
                },
                "success": function (response) {                 
                                        
                    if (response.trim() == "SessaoExpirada") {
                        $('#modalSuplementado').modal('hide');
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        $('#modalSuplementado').modal('hide');
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        console.log(response);                        
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
                            console.log(response);
                            $('#modalSuplementado').modal('hide');
                            func.modalAlert(func.msgErroPadrao);                            
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $('#modalSuplementado').modal('hide');
                            func.modalAlert(response.msg);                            
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        $('#modalSuplementado').modal('hide');
                        func.modalAlert(response.msg, 'success');
                        listaTabela();                  
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        $('#modalSuplementado').modal('hide');
                        func.modalAlert(func.msgErroPadrao);                        
                        return false;
                    }
                },
                "error": function (response) {
                    console.log(response);
                    $('#modalSuplementado').modal('hide');
                    func.modalAlert(func.msgErroPadrao);                    
                    return false;
                },
                "complete": function(){
                    $this.prop("disabled", false);
                }
            });            
            
            
        }
    });
    
    $('body').on('click', '.btn-salvar-reduzido', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);
            
            $this.prop("disabled", true);
            var Dados = {
                id: $this.val(),
                valor: $(".valorReduzido").val(),
                tipo: "reduzir"
            }
            
            if(Dados.id == 0 || Dados.id == ""){
                $('#modalReduzido').modal('hide');
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;                
            }
                        
            $.ajax({
                "url": "/model/pla/liberacao_fonte/request_liber_fonte.php",
                "dataType": "html",
                "data": {
                    "acao": "suple_reduz",
                    "dados": Dados
                },
                "success": function (response) {                 
                                        
                    if (response.trim() == "SessaoExpirada") {
                        $('#modalReduzido').modal('hide');
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        $('#modalReduzido').modal('hide');
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        console.log(response);                        
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
                            console.log(response);
                            $('#modalReduzido').modal('hide');
                            func.modalAlert(func.msgErroPadrao);                            
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $('#modalReduzido').modal('hide');
                            func.modalAlert(response.msg);                            
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        $('#modalReduzido').modal('hide');
                        func.modalAlert(response.msg, 'success');
                        listaTabela();                  
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        $('#modalReduzido').modal('hide');
                        func.modalAlert(func.msgErroPadrao);                        
                        return false;
                    }
                },
                "error": function (response) {
                    console.log(response);
                    $('#modalReduzido').modal('hide');
                    func.modalAlert(func.msgErroPadrao);                    
                    return false;
                },
                "complete": function(){
                    $this.prop("disabled", false);
                }
            });            
            
            
        }
    });


    $('body').on('click', '#btn-situacao', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            
            $.ajax({
                "url": "/model/pla/liberacao_fonte/request_liber_fonte.php",
                "dataType": 'html',
                "data": {
                    acao: "listaSituacao",
                    fonte: $("#fonte").val(),
                    ano: $("#ano").val()                    
                },
                "success": function (response) {                        
                    $("#situacao").html(response);                    
                }
            });
            
            
        }
    });


});
