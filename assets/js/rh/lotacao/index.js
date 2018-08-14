//******************************************************************************************
function listaCategoriaCombo() {
    $.ajax({
        "url": "/model/rh/lotacao/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaCategoriaOption"
        },
        "success": function (response) {
            // console.log(response);
            $("#id_categoria").append(response);
            $("#id_categoria").select2({
                //width: " 100%"
            });
        }
    });
}
listaCategoriaCombo();
//******************************************************************************************
function listaLotacaoCombo() {
    $.ajax({
        "url": "/model/rh/lotacao/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaLotacaoOption",
            id: 0
        },
        "success": function (response) {
            // console.log(response);
            $("#id_pai").append(response);
            $("#id_pai").select2({
                //width: " 100%"
            });
        }
    });
}
listaLotacaoCombo();
//******************************************************************************************
$(document).ready(function () {

    
    //******************************************************************************************

    func = new Funcoes();
    func.carregaTabelaPadrao('tabela', null, [7]);
    //**************************************************************************
    $('body').on('click', '.btn-novo', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            top.location.href = "/pages/rh/lotacao/cadastraLotacao.php";

        }
    });
    //*************************************************************************
    $('body').on('click', '.btn-novoContrato', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            top.location.href = "/pages/rh/contrato/index.php";

        }
    });
    //************************************************************************
    $('body').on('click', '.btn-pesquisar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var nome = $("#nm_lotacao").val();
            var categoria = $("#id_categoria").val();
            var lotacaoPai = $("#id_pai").val();
            
            if (nome === "" && categoria === "0" && lotacaoPai === "0") {
                func.modalAlert(func.msgPreencherCampos);
                return;
            }
            
            $.ajax({
                "url": "/model/rh/lotacao/request.php",
                "dataType": 'html',
                "method": "POST",
                "data": {
                    acao: "listaLotacaoTable",
                    nome: nome,
                    categoria: categoria,
                    lotacaoPai: lotacaoPai

                },
                "success": function (response) {
                    func.carregaTabelaPadrao('tabela', response, [7], true);
                }
            });
        }
    });

    

    $('body').on('click', '.btn-remover', function (e) {

        var $this = $(this);
        var id = $this.val();
        var item = $this.closest('td').find('.btn-edit').attr("nome");
        var idLotacao = id;
        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem Certeza que deseja Excluir:   <span class="text-danger">' + item + '</span>?',
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
                    var Lotacao = {
                        idLotacao: idLotacao

                    }

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/rh/lotacao/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "removerLotacao",
                            "lotacao": Lotacao
                        },
                        "success": function (response) {
                            console.log(response);
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
        var idLotacao = $(this).val();
        top.location.href = "/pages/rh/lotacao/editaLotacao.php?id=" + idLotacao;

    });

    $('body').on('click', '.btn-limpar', function (e) {
        
        $("#nm_lotacao").val("");
        $("#id_categoria").val('0').change();
        $("#id_pai").val("0").change();

    });

    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nome").focus();
    });


    $('body').on('keypress', '.formPesquisaFuncionario', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-pesquisar").trigger('click');
            return false;
        }
    });

});
