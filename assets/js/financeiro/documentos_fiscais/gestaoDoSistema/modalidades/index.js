$(document).ready(function () {

    func = new Funcoes();

    function listaModalidadeAtiva() {
        $.ajax({
            "url": "/model/financeiro/document_fiscais/financeiro/gestaoDoSistema/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaModalidadeAtiva"
            },
            "success": function (response) {
                $("#modalidadeA").find("tbody").html(response);
                var table = $('#modalidadeA').DataTable({
                    "lengthMenu": [[10, 25, 50, 10, -1], [10, 25, 50, 100, "Todos"]],
                    "order": [],
                    "language": {
                        "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
                    },
                    responsive: true
                });
                $("#tabela").show();

            }
        });
    }

    function listaModalidadeDesativada() {
        $.ajax({
            "url": "/model/financeiro/document_fiscais/financeiro/gestaoDoSistema/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaModalidadeDesativada"
            },
            "success": function (response) {
                $("#modalidadeD").find("tbody").html(response);
                var table = $('#modalidadeD').DataTable({
                    "lengthMenu": [[10, 25, 50, 10, -1], [10, 25, 50, 100, "Todos"]],
                    "order": [],
                    "language": {
                        "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
                    },
                    responsive: true
                });
                $("#tabela").show();

            }
        });
    }

    listaModalidadeAtiva();
    listaModalidadeDesativada();

    $("body").on("click", ".btn-salvar", function (e) {
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);

            if ($("#nmModalidade").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            var modalidade = {
                NmModalidade: $("#nmModalidade").val(),
            }

            $.ajax({
                "url": "/model/financeiro/document_fiscais/financeiro/gestaoDoSistema/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadastraModalidade",
                    "modalidade": modalidade
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
                        func.modalAlert(response.msg);
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            location.reload();
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
    });

    $("body").on("click", ".btn-edit", function (e) {
        $(".btn-salvar").hide();
        $(".btn-limpar").show();
        $(".btn-editar").show();
        $("#nmModalidade").val($(this).attr('nome'));
        $("#idModalidade").val($(this).val());
    });

    $("body").on("click", ".btn-editar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var modalidade = {
                nmModalidade: $("#nmModalidade").val(),
                idModalidade: $("#idModalidade").val()
            };
            $.ajax({
                "url": "/model/financeiro/document_fiscais/financeiro/gestaoDoSistema/request.php",
                "dataType": "html",
                "data": {
                    "acao": "editarModalidade",
                    "modalidade": modalidade,

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
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
                            func.modalAlert(func.msgErroPadrao);
                            return false;

                        } else if (response.tipoExibicao === "alert") {
                            $("body").find("#nmModalidade").html("");
                            func.modalAlert(response.msg);

                            return false;
                        }

                    } else if (response.tipoMsg === "ok") {
                        func.modalAlert(response.msg);
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            $('.btn-salvar').prop("disabled", false);
                            $("#nmModalidade").val("");
                            $(".btn-editar").hide();
                            location.reload();
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

            $this.prop("disabled", false);
        }
    });


    $('body').on('click', '.btn-remover', function (e) {

        var $this = $(this);
        var id = $this.val();
        var item = $this.closest('td').find('.btn-edit').attr("nome");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que deseja continuar com a Exclusão da modalidade <span class="text-danger">' + item + '</span> ?',
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
                    var modalidade = {
                        idModalidade: id
                    }

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/financeiro/document_fiscais/financeiro/gestaoDoSistema/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "excluirModalidade",
                            "modalidade": modalidade
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
                                func.modalAlert(response.msg);
                                $('.modal-alert').on('hidden.bs.modal', function (e) {
                                    location.reload();
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

    $('body').on('click', '.btn-ativa', function (e) {

        var $this = $(this);
        var id = $this.val();
        var item = $this.closest('td').find('.btn-ativa').attr("nome");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que deseja restaurar a modalidade <span class="text-danger">' + item + '</span> ?',
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
                    var modalidade = {
                        idModalidade: id
                    }

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/financeiro/document_fiscais/financeiro/gestaoDoSistema/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "restauraModalidade",
                            "modalidade": modalidade
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
                                func.modalAlert(response.msg);
                                $('.modal-alert').on('hidden.bs.modal', function (e) {
                                    location.reload();
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