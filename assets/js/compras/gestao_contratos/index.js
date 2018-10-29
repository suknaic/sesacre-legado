$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    $(".select").select2({
        width: " 100%"
    });

    //pegando menu da gestao do contrato
    $.ajax({
        "url": "/layout/menus/compras/gestao_contratos/menuGestaoContratos.php",
        "dataType": "html",
        "success": function (response) {
            $("body").find("#menu_contratos").html(response);
        }
    });
    //fim

    //Listando tipo de gasto
    $.ajax({
        "url": "/model/compras/gestaoContratos/request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaTipoGasto"
        },
        "success": function (response) {
            $("body").find("#tipoGasto").html(response);
            $(".select").select2({
            });
        }
    });
    //fim

    //Listando cadfornecedores
    $.ajax({
        "url": "/model/compras/gestaoContratos/request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaFornecedor"
        },
        "success": function (response) {
            $("body").find("#contratado").html(response);
            $(".select").select2({
            });
        }
    });
    //fim

    //Listando modalidades
    $.ajax({
        "url": "/model/compras/gestaoContratos/request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaModalidade"
        },
        "success": function (response) {
            $("body").find("#modalidade").html(response);
            $(".select").select2({
            });
        }
    });
    //fim

    //Listando centrais
    $.ajax({
        "url": "/model/compras/gestaoContratos/request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaCentrais"
        },
        "success": function (response) {
            $("body").find("#central").append(response);
            $(".select").select2({
            });
        }
    });
    //fim

    //carregar datatable para tabela
    $('.dropdown-toggle').dropdown();
    $('#demo-dt-basic').DataTable({
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
        "language": {
            "url": "/assets/lib/template/plugins/datatables/media/js/Portuguese-Brasil.json"
        },
        responsive: true
    });
    //fim

    $('body').on('click', '.btn-pesquisar', function (e) {
        var dados = {
            "tipoCont": $("#tipoCont option:selected").val(),
            "tipoGasto": $("#tipoGasto option:selected").val(),
            "central": $("#central option:selected").val(),
            "contratado": $("#contratado option:selected").val()
        };
        
        $.ajax({
            "method": "POST",
            "url": "/model/compras/gestaoContratos/request.php",
            "dataType": 'html',
            "data": {
                acao: "pesquisaContrato",
                dados: dados
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
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    } else if (response.tipoExibicao === "alert") {
                        func.modalAlert(response.msg);
                        return false;
                    }
                } else if (response.tipoMsg === "ok") {
                    func.carregaTabelaPadrao('tabela', response.msg, [], true);
                } else {
                    console.log('Ultimo else');
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            }
        });
    });

    $('body').on('click', '.editar', function (e) {
        var id = $(this).val();
        $.ajax({
            "url": "/model/compras/gestaoContratos/request.php",
            "dataType": 'html',
            "data": {
                acao: "editarItens",
                id: $(this).val()
            },
            "success": function (response) {
                if (response === 'sim') {
                    window.location.href = "/pages/compras/gestao_contratos/cad_item_contrato_ata.php?&id=" + id;

                } else if (response === 'nao') {
                    window.location.href = "/pages/compras/gestao_contratos/cad_item.php?&id=" + id;
                }
                return false;
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
                    func.carregaTabelaPadrao('tabela', response.msg, [], true);
                } else {
                    console.log('Ultimo else');
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            }
        });
    });

    $('body').on('click', '.espelho', function (e) {
        var id = $(this).val();
        $.ajax({
            "url": "/model/compras/gestaoContratos/request.php",
            "dataType": 'html',
            "data": {
                acao: "editarItens",
                id: $(this).val()
            },
            "success": function (response) {
                window.open("/pages/compras/gestao_contratos/ver_contrato.php?&id=" + id);
            }
        });
    });
});
