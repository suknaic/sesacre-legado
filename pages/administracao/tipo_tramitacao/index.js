$(document).ready(function () {
    func = new Funcoes();
    
    
    function lista() {
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "data": {
                acao: "listaTramitacoes"
            },
            "success": function (response) {            
                func.carregaTabelaPadrao('tabela', response, [2]);
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
                tramitacao: $("#tipo_tramitacao").val()
            }

            if (Dados.tramitacao == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "request.php",
                "dataType": "html",
                "method": "post",
                "data": {
                    "acao": "cadTipoTramitacao",
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
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            location.reload();
                        });
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
        var id = $this.closest('tr').data('id');
        var item = $this.closest('tr').find('td:eq(1)').text();

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

                    $.ajax({
                        "url": "request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "desativarTipoTramitacao",
                            "dados": id
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
                                    location.reload();
                                });
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
    
    $('body').on('click', '.btn-ativar', function (e) {

        var $this = $(this);
        var id = $this.closest('tr').data('id');
        var item = $this.closest('tr').find('td:eq(1)').text();

        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem Certeza que deseja continuar com a Ativação do Item <span class="text-danger">' + item + '</span>?',
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

                    $.ajax({
                        "url": "request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "ativarTipoTramitacao",
                            "dados": id
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
                                    location.reload();
                                });
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
    
    $('body').on('click','.btn-edit',function(e){
        $(".btn-salvar").hide();
        $(".btn-editar").show();
        
        var idTipoTramitacao = $(this).closest('tr').data('id');
        var nmTipoTramitacao = $(this).closest('tr').find('td:eq(1)').text(); 

        $('#id_tramitacao').val(idTipoTramitacao);
        $('#tipo_tramitacao').val(nmTipoTramitacao);
        
        $('html, body').animate({
            scrollTop: $('#formulario').offset().top + 'px'
        }, 'slow');
       
    });
    
    $('body').on('click','.btn-limpar',function(e){
       $("#formulario").trigger("reset"); 
       $(".btn-salvar").show();
       $(".btn-editar").hide();
    });
//    
//    $('body').on('click','.btn-editar',function(e){
//        e.stopPropagation();
//        if (e.isDefaultPrevented()) {
//        } else {
//            e.preventDefault();
//            var $this = $(this);
//            $this.prop("disabled", true);
//            var Dados = {
//                id: $("#id_tipo_administracao").val(),
//                administracao: $("#tipo_administracao").val()
//            }
//
//            if ($("#tipo_administracao").val() == "" || $("#id_tipo_administracao").val() == 0) {
//                func.modalAlert(func.msgPreencherCampos);
//                $this.prop("disabled", false);
//                return false;
//            }
//            
//            $.ajax({
//                "url": "/model/administracao/tipo_administracao/request.php",
//                "dataType": "html",
//                "method": "post",
//                "data": {
//                    "acao": "altTipoAdministracao",
//                    "dados": Dados
//                },
//                "success": function (response) {
//                    $this.prop("disabled", false);
//                    if (response.trim() == "SessaoExpirada") {
//                        func.modalAlert(func.msgSemPermissao);
//                        return false;
//                    }
//
//                    try {
//                        response = JSON.parse(response);
//                    } catch (e) {
//                        func.modalAlert(func.msgErroPadrao);
//                        console.log("Parse JSON");
//                        console.log(response);
//                        return false;
//                    }
//
//                    if (response.tipoMsg === "Erro") {
//                        if (response.tipoExibicao === "console") {
//                            console.log('Console Mensagem');
//                            console.log(response);
//                            func.modalAlert(func.msgErroPadrao);
//                            return false;
//                        } else if (response.tipoExibicao === "alert") {
//                            func.modalAlert(response.msg);
//                            return false;
//                        }
//                    } else if (response.tipoMsg === "ok") {
//                        func.modalAlert(response.msg, 'primary');
//                        $('.modal-alert').on('hidden.bs.modal', function (e) {
//                            location.reload();
//                        });
//                        return false;
//                    } else {
//                        console.log('Ultimo else');
//                        console.log(response);
//                        func.modalAlert(func.msgErroPadrao);
//                        return false;
//                    }
//                },
//                "error": function (response) {
//                    $this.prop("disabled", false);
//                    console.log(response);
//                    func.modalAlert(func.msgErroPadrao);
//                    return false;
//                }
//            });
//            
//            $(".btn-salvar").show();
//            $(".btn-editar").hide();
//
//            $this.prop("disabled", false);
//        }
//    });
});

