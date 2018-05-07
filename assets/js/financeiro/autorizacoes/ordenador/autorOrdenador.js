$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();


    $(document).ready(function () {
        //instacinado fucoes js
        func = new Funcoes();

        $('body').on('click', '.btn-salvar', function (e) {

            var $this = $(this);
            var id = $("#pedido").val();

            bootbox.confirm({
                title: func.msgCaixaDeConfirmacao,
                message: 'Você tem Certeza que deseja continuar com a Autorização do pedido: <span class="text-danger">' + id + '</span> ?',
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
                        //validação de campos js

                        if ($("#obsAutoriza").val() == "") {
                            func.modalAlert(func.msgPreencherCampos);
                            $this.prop("disabled", false);
                            return false;
                        }

                        if ($("#pedido").val() == "") {
                            func.modalAlert(func.msgPreencherCampos);
                            $this.prop("disabled", false);
                            return false;
                        }
                        var dados = {
                            "pedido": $("#pedido").val(),
                            "obsAutoriza": $("#obsAutoriza").val()
                        }
                        $.ajax({
                            "url": "/model/financeiro/autorizacoes/central/request.php",
                            "dataType": 'html',
                            "method": "POST",
                            "data": {
                                "acao": "autorizacaoGerenteOrdenado",
                                "dados": dados
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
                                    return false;
                                }

                                if (response.tipoMsg === "Erro") {
                                    if (response.tipoExibicao === "console") {
                                        func.modalAlert(func.msgErroPadrao);
                                        return false;
                                    } else if (response.tipoExibicao === "alert") {
                                        func.modalAlert(response.msg);
                                        return false;
                                    }
                                } else if (response.tipoMsg === "ok") {
                                    func.modalAlert(response.msg, 'success');
                                    $('.modal-alert').on('hidden.bs.modal', function (e) {
                                        window.location.href = "/pages/financeiro/autorizacoes/ordenador/index.php";
                                    });
                                    return false;
                                } else {
                                    console.log('Ultimo else');
                                    func.modalAlert(func.msgErroPadrao);
                                    return false;
                                }
                            },
                            "error": function (response) {
                                $this.prop("disabled", false);
                                func.modalAlert(func.msgErroPadrao);
                                return false;
                            }
                        });
                    }
                }
            });
        });

        $('body').on('click', '.btn-cancelar', function (e) {

            var $this = $(this);
            var id = $this.val();

            bootbox.confirm({
                title: func.msgCaixaDeConfirmacao,
                message: 'Você tem Certeza que deseja continuar com a Cancelamento do pedido: <span class="text-danger">' + id + '</span> ?',
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
                        var dados = {
                            "pedido": $("#pedido").val(),
                            "obsAutoriza": $("#obsAutoriza").val()
                        }

                        if ($("#obsAutoriza").val() == "") {
                            func.modalAlert(func.msgPreencherCampos);
                            $this.prop("disabled", false);
                            return false;
                        }

                        if ($("#pedido").val() == "") {
                            func.modalAlert(func.msgPreencherCampos);
                            $this.prop("disabled", false);
                            return false;
                        }

                        $.ajax({
                            "url": "/model/financeiro/autorizacoes/central/request.php",
                            "dataType": 'html',
                            "method": "POST",
                            "data": {
                                "acao": "cancelarPedido",
                                "dados": dados
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
                                    return false;
                                }

                                if (response.tipoMsg === "Erro") {
                                    if (response.tipoExibicao === "console") {
                                        console.log('Console Mensagem');
                                        func.modalAlert(func.msgErroPadrao);
                                        return false;
                                    } else if (response.tipoExibicao === "alert") {
                                        func.modalAlert(response.msg);
                                        return false;
                                    }
                                } else if (response.tipoMsg === "ok") {
                                    func.modalAlert(response.msg, 'primary');
                                    $('.modal-alert').on('hidden.bs.modal', function (e) {
                                        window.location.href = "/pages/financeiro/autorizacoes/orcamento/index.php";
                                    });
                                    return false;
                                } else {
                                    console.log('Ultimo else');
                                    func.modalAlert(func.msgErroPadrao);
                                    return false;
                                }
                            },
                            "error": function (response) {
                                func.modalAlert(func.msgErroPadrao);
                                return false;
                            }
                        });
                    }
                }
            });
        });
    });

});
