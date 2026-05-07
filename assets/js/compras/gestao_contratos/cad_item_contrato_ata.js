$(document).ready(function () {

    //instacinado fucoes js
    func = new Funcoes();
    $(".select").select2({
        width: " 100%"
    });

    //carrega Itens
    function retornaTrItens() {
        var dados = {
            "id": $("#id").val()
        }

        $.ajax({
            "url": "/model/compras/itens/request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornatrItens",
                "dados": dados
            },
            "success": function (response) {
                $("#tabela").find("tbody").html(response);
            }
        });
    }
    retornaTrItens();
    //fim

    $.ajax({
        "url": "/model/compras/itens/request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaUnidadeDeMedida"
        },
        "success": function (response) {
            $("#unidadeMedida").html(response);
        }
    });


    //Masca para valor
    $("body").on("focus", "#qtd", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
        });
    });

    $("body").on("focus", "#valor_unitario", function () {
        $(this).priceFormat({
            centsLimit: 4,
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
        });
    });

    //Inicia a edição do item
    $('body').on('click', '.btn-edit', function (e) {
        e.preventDefault();
        var Dados = {
            "tipoCad": $("#tipoCad").val(),
            "idItem": $(this).val()
        }

        $.ajax({
            "url": "/model/compras/itens/request.php",
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

                if (response.tipoMsg == "nao_encontrou") {
                    func.modalAlert(func.msgRegistroNaoEncontrado);
                    $('.modal-alert').on('hidden.bs.modal', function (e) {
                        location.reload();
                    });
                }
                if (response.tipoMsg == "ok") {
                    var info = response.msg;
                    if (info.tp_material == 'C') {
                        document.getElementById("valor_unitario").disabled = true;
                        document.getElementById("pc_desconto").disabled = true;
                    }

                    $("#itemNumero").val(info.nr_item)
                    $("#codigo").val(info.cd_desc_material);
                    $("#desc-item").text(info.nm_desc_material);
                    $("#item").text(info.nm_material);
                    $("#grupo").text(info.nm_grupo);
                    $("#sub-grupo").text(info.nm_sub_grupo);
                    $("#despesa").text(info.cd_elemento_despesa);
                    $("#tipo").text(info.tp_material);
                    $("#marca").val(info.nm_marca);
                    $("#modelo").val(info.nm_modelo);
                    $("#lote").val(info.nr_lote);
                    $("#qtd").val(info.qt_itens);
                    $("#valor_unitario").val(info.vl_itens);
                    $("#desc_item").val(info.ds_itens)
                    $("#pc_desconto").val(info.pc_desconto);
                    $(".btn-salvar").hide();
                    $(".btn-editar").show();
                    $(".btn-editar").val(Dados.idItem);
                    $('html, body').animate({
                        scrollTop: $('#page-content').offset().top + 'px'
                    }, 'slow');
                }
            }
        });
    });
    //fim
    $("body").on("click", ".btn-editar", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            //validação de campos js
            if ($("#codigo").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#itemNumero").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#marca").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#modelo").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#lote").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#qtd").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#valor_unitario").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#unidadeMedida").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            if ($("#pc_desconto").val() == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            var dados = {
                "itemNumero": $("#itemNumero").val(),
                "idItem": $(this).val(),
                "id": $("#id").val(),
                "id_alt": $("#id_alt").val(),
                "codigo": $("#codigo").val(),
                "marca": $("#marca").val(),
                "modelo": $("#modelo").val(),
                "lote": $("#lote").val(),
                "qtd": $("#qtd").val(),
                "valor_unitario": $("#valor_unitario").val(),
                "pc_desconto": $("#pc_desconto").val(),
                "desc_item": $("#desc_item").val(),
                "unidadeMedida": $("#unidadeMedida").val()
            }

            $.ajax({
                "url": "/model/compras/itens/request.php",
                "dataType": "html",
                "data": {
                    "acao": "edicaoItemAtaContrato",
                    "dados": dados
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
                        func.modalAlert(response.msg, 'success');
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
            $this.prop("disabled", false);
        }
    });

    $('body').on('click', '.btn-remover', function (e) {
        var $this = $(this);
        var id = $this.val();
        var item = $this.closest('td').find('.btn-remover').attr("nomeMaterial");
        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que deseja continuar com a Exclusão do Item: <span class="text-danger">' + item + '</span> ?',
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
                        "idItem": id,
                        "tipoCad": $("#tipoCad").val()
                    }

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/compras/itens/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "excluirItem",
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

    $("body").on("click", ".btn-finaliza", function (e) {
        window.location.href = "/pages/compras/gestao_contratos/index.php";
    });
});
