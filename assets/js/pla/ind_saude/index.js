$(document).ready(function () {

    func = new Funcoes();

    function listaIndicador() {
        $.ajax({
            "url": "/model/pla/ind_saude/request.php",
            "dataType": 'html',
            "data": {
                acao: "listaIndicadorTable"
            },
            "success": function (response) {             
                func.carregaTabelaPadrao('tabela', response, [6]);
            }
        });
    }
    listaIndicador();

    $('body').on('click', '#btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var Dados = {
                nota: $("#nota").val(),
                nome: $("#nome").val(),                
                ano: $("#ano").val(),
                tipo: $('input[name=optradio]:checked', '.formDados').val(),
                meta: $("#meta").val(),                
                unidade: $("#unidade").val(),
                id: $this.val()
            }          

            if (Dados.nota == "" || Dados.nome == "" 
                    || Dados.ano.length != 4 || Dados.meta == ""
                     || Dados.unidade == ""
                     || $('input[name=optradio]:checked', '.formDados').length < 1 ) {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }
            
            if($this.hasClass('btn-editar')){
                if(Dados.id == "" || Dados.id == "0"){
                    func.modalAlert(func.msgPreencherCampos);
                    $this.prop("disabled", false);
                    return false;
                }
            }
                        
            $.ajax({
                "url": "/model/pla/ind_saude/request.php",
                "dataType": "html",
                "data": {
                    "acao": "salvaIndicador",
                    "dados": Dados
                },
                "success": function (response) {
                    $this.prop("disabled", false);
                    if (response.trim() == "SessaoExpirada") {
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }
                    console.log(response);
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
                    var Dados = {
                        id: id
                    }

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/pla/ind_saude/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "remIndicador",
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
                                func.modalAlert(response.msg);
                                $('.modal-alert').on('hidden.bs.modal', function (e) {
                                    location.reload();
                                });
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
        $("#nota").val($(this).attr('nota'));
        $("#nome").val($(this).attr('nome'));        
        $("#ano").val($(this).attr('ano'));
        $("#meta").val($(this).attr('meta'));
        $("#unidade").val($(this).attr('unidade'));        
        $("input[name=optradio]").prop("checked", false);
        $("input[name=optradio][value='"+$(this).attr('tipo')+"'] ").prop("checked", true);
        
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
