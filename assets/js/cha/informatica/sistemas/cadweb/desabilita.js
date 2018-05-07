$(document).ready(function () {

    func = new Funcoes();

    function listaLotacaoCombo() {
        $.ajax({
            "url": "/model/cha/informatica/sistemas/cadweb/chamado-request.php",
            "dataType": 'html',
            "data": {
                acao: "listaLotacaoOption"
            },
            "success": function (response) {
//             console.log(response);
                $("#lotacao").append(response);
                $("#lotacao").select2({
                    width: " 100%"
                });
            }
        });
    }
    listaLotacaoCombo();

    function listaChamado() {
        $.ajax({
            "url": "/model/cha/informatica/sistemas/cadweb/chamado-request.php",
            "dataType": 'html',
            "data": {
                acao: "listaChamadoTable"
            },
            "success": function (response) {
                func.carregaTabelaPadrao('tabela', response, [6]);
            }
        });
    }
    listaChamado();
// ******************************************************
//func.carregaTabelaPadrao('tabela', null, [2]);
function returChamados() {
       var id_usuario = $("#id_usuario").val();

       $.ajax({
           "url": "/model/cha/informatica/sistemas/cadweb/chamado-request.php",
           "dataType": "html",
           "data": {
               "acao": "returnChamados",
               "id_usuario": id_usuario

           },
           "success":
                   function (response) {
                      func.carregaTabelaPadrao('tabela', response, [11], true);
                      console.log(response);
                   }
       });
   }
// returChamados()


//*****************************************************************************

    $('body').on('click', '#btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var DadosChamado = {
                catPrincipal: 3,
                catTipo: 3,
                catPrimaria: 9,
                catSecundaria: 134,
                status: 1
            };

            var DadosFormSistema = {
                nome: $("#nome").val(),
                email: $("#email").val(),
                telefone: $("#telefone").val(),
                cns: $("#cns").val(),
                lotacao: $("#lotacao").val(),
            };
            //  console.log(Dados['#lotacao']);
            /*  if (Dados.nome == "" || Dados.email == ""
             || Dados.telefone == "" || Dados.cns == "" || Dados.lotacao == ""
             || $('input[name=optradio]:checked', '.formDados').length < 1 ) {
             func.modalAlert(func.msgPreencherCampos);
             $this.prop("disabled", false);
             return false;
             }*/

            if ($this.hasClass('btn-editar')) {
                if (Dados.id == "" || Dados.id == "0") {
                    func.modalAlert(func.msgPreencherCampos);
                    $this.prop("disabled", false);
                    return false;
                }
            }

            $.ajax({
                "url": "/model/cha/informatica/sistemas/cadweb/chamado-request.php",
                "dataType": "html",
                "data": {
                    "acao": "salvarChamado",
                    "dadosFormSistema": DadosFormSistema,
                    "dadosChamado": DadosChamado
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
//                        console.log("Parse JSON");
//                        console.log(response);
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
                            top.location.href = "/pages/cha/informatica/index.php";
                        });
                        return false;
                    } else {
//                        console.log('Ultimo else');
//                        console.log(response);
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
        var chamado = $this.closest('td').find('.btn-edit').attr("nome");

        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem Certeza que deseja continuar com a Exclusão deste Chamado?<span class="text-danger">' + chamado + '</span>?',
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
                        "url": "/model/cha/informatica/sistemas/cadweb/chamado-request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "remChamado",
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
                                func.modalAlert(response.msg, 'primary');
//                                $('.modal-alert').on('hidden.bs.modal', function (e) {
//                                    top.location.href = "/pages/rh/funcionario/index.php";
//                                });
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
        $("#nome").val($(this).attr('nome'));
        $("#email").val($(this).attr('email'));
        $("#telefone").val($(this).attr('telefone'));
        $("#cns").val($(this).attr('cns'));
        $("#lotacao").prop("checked", false);

        $("#btn-salvar").removeClass("btn-success");
        $("#btn-salvar").addClass("btn-info");
        $("#btn-salvar").find("#txtBtn").text("Salvar Edição");
        $("#nome").focus();
    });
    $('body').on('click', '.btn-limpar', function (e) {
        location.reload();
    });

    $('.modal-alert').on('shown.bs.modal', function (e) {
        $("#nome").focus();
    });


    $('body').on('keypress', '.formDados', function (e) {
        var key = e.which;
        if (key == 13) {
            $("#btn-salvar").trigger('click');
            return false;
        }
    });

});
