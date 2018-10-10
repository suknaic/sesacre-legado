$(document).ready(function () {

    func = new Funcoes();
    //******** Carrega o DataTable pra tabela não ficar feia **********
    var table = $('#tabela').DataTable({
        "lengthMenu": [[10, 25, 50, 10, -1], [10, 25, 50, 100, "Todos"]],
        "order": [[0, "asc"]],
        "language": {
            "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
        },
        responsive: true
    });
    //*****************************************************************

    //************ Carrega o select2 em todos os select's *************
    $('.select').select2({ width:"100%" });
    //*****************************************************************

    //*********** Carregas todos os estado no select option ***********
    $.ajax({
        "url": "/pages/sistema/cidade/request.php",
        "dataType": 'html',
        "data": {
            acao: "SelectEstadoOption"
        },

        "success": function (response) {
            $('#idEstado').html(response);
        }
    });
    // ****************************************************************

    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var Cidade = {
                nome: $("#nmCidade").val(),
                idEstado: $("#idEstado").val()
            };

            if (Cidade.nome == '' && Cidade.idEstado == '') {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "/pages/sistema/cidade/request.php",
                "dataType": "html",
                "data": {
                    "acao": "listaCidadesTable",
                    "dados": Cidade
                },
                "success": function (response) {
                    try {
                        func.carregaTabelaPadrao('tabela', response, [8], true);
                        return false;
                    } catch (e) {
                        response = JSON.parse(response);
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            func.modalAlert(func.msgErroPadrao, 'danger');
                            return false;

                        } else if (response.tipoExibicao === "alert") {
                            func.modalAlert(response.msg);
                            return false;
                        }

                    } else {
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    }
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
            var Estado = {
                nome: $("#nmEstado").val(),
                sigla: $("#nmSigla").val(),
                id: $this.val(),
                idp: $("#idPais").val()


            };

            if ($("#nmEstado").val() == "" || $this.val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "/model/sistema/estado/request.php",
                "dataType": "html",
                "data": {
                    "acao": "edtEstado",
                    "estado": Estado
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
                        func.modalAlert(response.msg);
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
                    var Estado = {
                        id: id
                    }

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/sistema/estado/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "remEstado",
                            "estado": Estado
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
                                func.modalAlert(response.msg);
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

    $('body').on('click', '.btn-limpar', function (e) {
        $('#nmCidade').prop("disabled", false);
        $('#idEstado').prop("disabled", false);
        $("#nmCidade").val("");
        $('#idEstado').val('').trigger('change.select2');
    });

    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nmCidade").focus();
    });

    $('body').on('click', '.btn-newCidade', function (e) {
        top.location.href='cadEditCidade.php';
    });

    $('body').on('click', '.btn-edit', function (e) {
        var id = $(this).val();
        top.location.href='cadEditCidade.php?idCidade='+id;
    });

    $('body').on('keypress', '.formCidade', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-salvar").trigger('click');
            return false;
        }
    });

    $("body").on("change", "#nmCidade", function () {
        var texto = $(this).val();
        if (texto != '') {
            $("#idEstado").prop('disabled', true);
        } else {
            $("#idEstado").prop('disabled', false);
        }
    });

    $("body").on("change", "#idEstado", function () {
        var texto = $(this).val();
        if (texto != '') {
            $("#nmCidade").prop('disabled', true);
        } else {
            $("#nmCidade").prop('disabled', false);
        }
    });
});
