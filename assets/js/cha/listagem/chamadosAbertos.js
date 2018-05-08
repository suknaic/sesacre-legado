$(document).ready(function () {

    func = new Funcoes();

    function listaLotacaoCombo() {
        $.ajax({
            "url": "/model/cha/abertura/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaLotacaoOption"
            },
            "success": function (response) {
//                console.log(response);
                $("#lotacao").append(response);
                $("#lotacao").select2({
                    width: " 100%"
                });
            }
        });
    }
    listaLotacaoCombo();
// //******************************************************************************************
    function returnChamados() {
        var id_usuario = $("#id_usuario").val();

        $.ajax({
            "url": "/model/cha/abertura/request.php",
            "dataType": "html",
            "method": "POST",
            "data": {
                "acao": "listaChamadoTable",
                "id_usuario": id_usuario,

            },
            "success":
                    function (response) {
                        //console.log(response);
                        func.carregaTabelaPadrao('tabela', response, [10], true);
                    }
        });
    }
    returnChamados();
//******************************************************************************************
    $('body').on('click', '#btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var DadosChamado = {
                idCategoriaPrincipal: $("#idCategoriaPrincipal").val(),
                idCategoriaTipo: $("#idCategoriaTipo").val(),
                idCategoriaPrimaria: $("#idCategoriaPrimaria").val(),
                idCategoriaSecundaria: $("#idCategoriaSecundaria").val(),
                idStatus: 1
            };

            var DadosFormSistema = {
                nome: $("#idCategoriaSecundaria").val(),
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
                "url": "/model/cha/abertura/request.php",
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

    $('body').on('click', '.btn-cancelar', function (e) {
        var $this = $(this);
        var id = $this.val();
        var chamado = $this.closest('td').find('.btn-edit').attr("nome");

        bootbox.confirm({
            title: func.msgCaixaDeConfirmacao,
            message: 'Você tem Certeza que Deseja Continuar com o Cancelamento  do Registro <span class="text-danger">' + chamado + '</span> ?',
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
                    var Chamado = {
                        id: id
                    };

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }
                    $.ajax({
                        "url": "/model/cha/abertura/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "cancela",
                            "chamado": Chamado
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
                                func.modalAlert(func.msgErroPadrao, 'danger');
                                return false;
                            }

                            if (response.tipoMsg === "Erro") {
                                if (response.tipoExibicao === "console") {
                                    func.modalAlert(func.msgErroPadrao, 'danger');
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
                                func.modalAlert(func.msgErroPadrao, 'danger');
                                return false;
                            }
                        },
                        "error": function (response) {
                            func.modalAlert(func.msgErroPadrao, 'danger');
                            return false;
                        }
                    });
                }
            }
        });
    });

       $('body').on('click', '.btn-editar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            //$this.prop("disabled", true);
            var idCategoriaSecundaria = ($("#idCategoriaSecundaria").val() ? $("#idCategoriaSecundaria").val() : "");
            var idPessoaServico = ($("#id_pessoa").val() ? $("#id_pessoa").val() : "");
            var nrTelefoneSolicitante = ($("#nrTelefoneSolicitante").val() ? $("#nrTelefoneSolicitante").val() : "");
            var dsChamado = ($("#dsProblema").val() ? $("#dsProblema").val() : "");

            var DadosChamado = {
                idCategoriaSecundaria: idCategoriaSecundaria,
                idPessoaSolicitante: $("#nm_usuario").val(),
                idPessoaServico: idPessoaServico,
                dhAbertura: $("#data").val(),
                dsChamado: dsChamado,
                nrTelefoneSolicitante: nrTelefoneSolicitante,
                dsFinalizado: null,
                dhFinalizado: null,
                nrAvaliacao: null,
                dhAvaliacao: null,
                dsAvaliacao: null,
                vlChamado: null,
                idStatus: 1,
                dhAgendamento: null,
                idPrioridade: null,
                dhCancelamento: null,
                dsCancelamento: null,
                dtPrazo: null
            };
//            console.log(DadosChamado);
//            return;
            var nmPessoa = ($("#nm_pessoa").val() ? $("#nm_pessoa").val() : "");
            var dsEmail = ($("#nm_email").val() ? $("#nm_email").val() : "");
            var nrTelefone = ($("#nrTelefone").val() ? $("#nrTelefone").val() : "");
            var nrCartaoSus = ($("#nr_cns").val() ? $("#nr_cns").val() : "");
            var nrCpf = ($("#nr_cpf").val() ? $("#nr_cpf").val() : "");
            var nrRg = ($("#nrRg").val() ? $("#nrRg").val() : "");
            var nrTelefoneSetor = ($("#nr_telefone").val() ? $("#nr_telefone").val() : "");
            var nrMatricula = ($("#nrMatricula").val() ? $("#nrMatricula").val() : "");
            var nmModulo = ($("#nmModulo").val() ? $("#nmModulo").val() : "");
            var nrPortaria = ($("#nrPortaria").val() ? $("#nrPortaria").val() : "");
            var nmSetor = ($("#nmSetor").val() ? $("#nmSetor").val() : "");
            var cdSetor = ($("#cdSetor").val() ? $("#cdSetor").val() : "");
            var nmResponsavel = ($("#nm_pessoa").val() ? $("#nm_pessoa").val() : "");
            var nrParticipantes = ($("#nrParticipantes").val() ? $("#nrParticipantes").val() : "");
            var dsSenhaDesejada = ($("#dsSenhaDesejada").val() ? $("#dsSenhaDesejada").val() : "");
            var nmExame = ($("#nmExame").val() ? $("#nmExame").val() : "");
            var dsExameParametro = ($("#dsExameParametro").val() ? $("#dsExameParametro").val() : "");
            var nmPermissao = ($("#nmPermissao").val() ? $("#nmPermissao").val() : "");
            var nmConselho = ($("#nmConselho").val() ? $("#nmConselho").val() : "");
            var nrConselho = ($("#nrConselho").val() ? $("#nrConselho").val() : "");
            var dtInicial = ($("#dtInicial").val() ? $("#dtInicial").val() : "");
            var dtFim = ($("#dtFim").val() ? $("#dtFim").val() : "");
            var dtNascimento = ($("#dtNascimento").val() ? $("#dtNascimento").val() : "");
            var idCargo = ($("#idCargo").val() ? $("#idCargo").val() : "");
            var idFuncao = ($("#idFuncao").val() ? $("#idFuncao").val() : "");
            var idLotacao = ($("#id_lotacao1").val() ? $("#id_lotacao1").val() : "");
            var idVinculo = ($("#idVinculo").val() ? $("#idVinculo").val() : "");


//            console.log($("#nm_email").val());
            var DadosFormSistema = {
//                idChamado: $("#idChamado").val(),
                nmPessoa: nmPessoa,
                dsEmail: dsEmail,
                nrTelefone: nrTelefone,
                nrCartaoSus: nrCartaoSus,
                nrCpf: nrCpf,
                nrRg: nrRg,
                nrTelefoneSetor: nrTelefoneSetor,
                nrMatricula: nrMatricula,
                nmModulo: nmModulo,
                nrPortaria: nrPortaria,
                nmSetor: nmSetor,
                cdSetor: cdSetor,
                nmResponsavel: nmResponsavel,
                nrParticipantes: nrParticipantes,
                dsSenhaDesejada: dsSenhaDesejada,
                nmExame: nmExame,
                dsExameParametro: dsExameParametro,
                nmPermissao: nmPermissao,
                nmConselho: nmConselho,
                nrConselho: nrConselho,
                dtInicial: dtInicial,
                dtFim: dtFim,
                dtNascimento: dtNascimento,
                idCargo: idCargo,
                idFuncao: idFuncao,
                idLotacao: idLotacao,
                idVinculo: idVinculo
            };
//            console.log(DadosFormSistema);

//            console.log(DadosFormSistema);
//            return;

//            if (DadosFormSistema.nmPessoa == "" || DadosFormSistema.dsEmail == "" || DadosFormSistema.nrTelefone == "" || DadosFormSistema.nrCartaoSus == "" || DadosFormSistema.nrCpf == 0
//                    || DadosFormSistema.nrRg == 0 || DadosFormSistema.nrTelefoneSetor == 0 || DadosFormSistema.nrMatricula == "" || DadosFormSistema.nmModulo == "" || DadosFormSistema.nrPortaria == ""
//                    || DadosFormSistema.nmSetor == "" || DadosFormSistema.cdSetor == "" || DadosFormSistema.nmResponsavel == "" || DadosFormSistema.nrParticipantes == "" || DadosFormSistema.dsSenhaDesejada == ""
//                    || DadosFormSistema.nmExame == "" || DadosFormSistema.dsExameParametro == "" || DadosFormSistema.nmPermissao == "" || DadosFormSistema.nmConselho == "" || DadosFormSistema.nrConselho == ""
//                    || DadosFormSistema.dtInicial == "" || DadosFormSistema.dtFim == "" || DadosFormSistema.dtNascimento == "" || DadosFormSistema.idCargo == 0 || DadosFormSistema.idFuncao == 0
//                    || DadosFormSistema.idLotacao == 0 || DadosFormSistema.idVinculo == 0) {
//                func.modalAlert(func.msgPreencherCampos + " (Formulário)");
//                //$this.prop("disabled", false);
//                return false;
//            }
//            if (DadosChamado.idCategoriaSecundaria == 0 || DadosChamado.idPessoaSolicitante == "" || DadosChamado.idPessoaServico == "" || DadosChamado.dhAbertura == "" ||
//                    DadosChamado.dsChamado == "" || DadosChamado.nrTelefoneSolicitante == "" || DadosChamado.dsFinalizado == "" || DadosChamado.dhFinalizado == "" ||
//                    DadosChamado.nrAvaliacao == "" || DadosChamado.dhAvaliacao == "" || DadosChamado.dsAvaliacao == "" || DadosChamado.vlChamado == "" ||
//                    DadosChamado.idStatus == 0 || DadosChamado.dhAgendamento == "" || DadosChamado.idPrioridade == 0 || DadosChamado.dhCancelamento == "" ||
//                    DadosChamado.dsCancelamento == "" || DadosChamado.dtPrazo == "") {
//                func.modalAlert(func.msgPreencherCampos + " (Chamado)");
//                //$this.prop("disabled", false);
//                return false;
//            }
            //***********************************************
//
//console.log(DadosChamado);
//console.log(DadosFormSistema);

            $.ajax({
                "url": "/model/cha/abertura/request.php",
                "dataType": 'html',
                'method': 'POST',
                "data": {
                    "acao": "editarChamado",
                    "dadosChamado": DadosChamado,
                    "dadosFormSistema": DadosFormSistema
                },

                "success": function (response) {
//                    console.log(response);
                    //$this.prop("disabled", false);
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
                            top.location.href = "/pages/cha/informatica/index.php";
                        });
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
    
    $('body').on('click', '.btn-edit', function (e) {
        e.preventDefault();
        //**********************
        var id = $(this).val();
        if (id.split("-")[0] == 1) {
            top.location.href = "/pages/cha/listagem/editar.php?id=" + id;
        }

    });

    $('body').on('click', '.btn-remover', function (e) {
        var $this = $(this);
        var id = $this.val();
        var item = $this.closest('td').find('.btn-edit').attr("nome");
        var idChamado = id;

        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem Certeza que deseja remover:   <span class="text-danger">' + item + '</span>?',
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
                        idChamado: idChamado

                    }

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/cha/abertura/request.php",
                        "dataType": "html",
                        "method": "POST",
                        "data": {
                            "acao": "removerFormSistema",
                            "idChamado": Dados
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
                                func.modalAlert(response.msg, 'primary');
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
//******************************************************************************************
//    $('body').on('click', '.btn-remover', function (e) {
//
//        var $this = $(this);
//        var id = $this.val();
//        var chamado = $this.closest('td').find('.btn-edit').attr("nome");
//
//        bootbox.confirm({
//            title: 'Caixa de Confirmação',
//            message: 'Você tem Certeza que deseja continuar com a Exclusão do Chamado <span class="text-danger">' + id + '</span>?',
//            buttons: {
//                'cancel': {
//                    label: 'Não',
//                    className: 'btn-default btn-rounded'
//                },
//                'confirm': {
//                    label: 'Sim',
//                    className: 'btn-primary btn-rounded'
//                }
//            },
//            callback: function (result) {
//                if (result) {
//                    var Dados = {
//                        id: id
//                    }
//
//                    if (id == "") {
//                        func.modalAlert(func.msgPreencherCampos);
//                        $this.prop("disabled", false);
//                        return false;
//                    }
//
//                    $.ajax({
//                        "url": "/model/cha/abertura/request.php",
//                        "dataType": "html",
//                        "data": {
//                            "acao": "removerFormSistemas",
//                            "dados": Dados
//                        },
//                        "success": function (response) {
//                            if (response.trim() == "SessaoExpirada") {
//                                func.modalAlert(func.msgSemPermissao);
//                                return false;
//                            }
//
//                            try {
//                                response = JSON.parse(response);
//                            } catch (e) {
//                                func.modalAlert(func.msgErroPadrao);
//                                console.log("Parse JSON");
//                                console.log(response);
//                                return false;
//                            }
//
//                            if (response.tipoMsg === "Erro") {
//                                if (response.tipoExibicao === "console") {
//                                    //console.log('Console Mensagem');
//                                    //console.log(response);
//                                    func.modalAlert(func.msgErroPadrao);
//                                    return false;
//                                } else if (response.tipoExibicao === "alert") {
//                                    func.modalAlert(response.msg);
//                                    return false;
//                                }
//                            } else if (response.tipoMsg === "ok") {
//                                func.modalAlert(response.msg, 'primary');
////                                $('.modal-alert').on('hidden.bs.modal', function (e) {
////                                    top.location.href = "/pages/rh/funcionario/index.php";
////                                });
//                                return false;
//                            } else {
//                                //console.log('Ultimo else');
//                                //console.log(response);
//                                func.modalAlert(func.msgErroPadrao);
//                                return false;
//                            }
//                        },
//                        "error": function (response) {
//                            //console.log(response);
//                            func.modalAlert(func.msgErroPadrao);
//                            return false;
//                        }
//                    });
//                }
//            }
//        });
//
//    });



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
