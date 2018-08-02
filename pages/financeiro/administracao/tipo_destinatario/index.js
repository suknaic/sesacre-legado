$(document).ready(function () {   
    func = new Funcoes();
    
    function lista(){
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaTiposDestinatarios"
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
                nmTpDest: $("#nm_doc_tipo_destinatario").val()
            }

            if (Dados.nmTpDest == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "request.php",
                "dataType": "html",
                "method": "post",
                "data": {
                    "acao": "cadastrarTipoDestinatario",
                    "dados": Dados
                },
                "success": function (response) {
                    console.log(response);
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
                        func.fechaModalReload();
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
                idTpDest: $("#id_doc_tipo_destinatario").val(),
                nmTpDest: $("#nm_doc_tipo_destinatario").val()
            }

            if (Dados.idTpDest == "" || Dados.idTpDest == "0" || Dados.nmTpDest == "") {            
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "request.php",
                "dataType": "html",
                "method": "post",
                "data": {
                    "acao": "alterarTipoDestinatario",
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
                        func.fechaModalReload();
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
    
    $('body').on('click', '.btn-excluir', function (e) {

        var $this = $(this);
        var dados = $(this).closest('tr').data('objeto');
        var id = dados.id_doc_tipo_destinatario;
        var item = $this.closest('tr').find('td:eq(0)').text();

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
                            "acao": "removerTipoDestinatario",
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
                                console.log('testando');
                                func.modalAlert(response.msg, 'primary');
                                func.fechaModalReload();
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
    
    
    $('body').on('click', '.btn-alterar', function (e) {
        e.preventDefault();
        
        var dados = $(this).closest('tr').data('objeto');
        $("#nm_doc_tipo_destinatario").val(dados.nm_doc_tipo_destinatario);
        $("#id_doc_tipo_destinatario").val(dados.id_doc_tipo_destinatario);
        
        $('.btn-salvar').hide();
        $('.btn-editar').show();
        $("#nm_doc_tipo_destinatario").focus();

    });
    $('body').on('click', '.btn-limpar', function (e) {
        $('.btn-salvar').prop("disabled", false);
        $('.btn-editar').prop("disabled", false);
        $('.btn-salvar').show();
        $('.btn-editar').val(0);
        $('.btn-editar').hide();
        $("#nm_doc_tipo_destinatario").val("");
        $("#id_doc_tipo_destinatario").val("");

    });
});
