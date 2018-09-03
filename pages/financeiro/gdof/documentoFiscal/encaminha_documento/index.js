$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();
    var id = 0;
    $('body').find('select').select2({
        width: '100%'
    });

    function lista() {
        var Dados = {
            nrDocFis: $("#id_doc_fis").val(),
            anoDocFis: $("#ano_doc_fis option:selected").val(),
            contratado: $("#id_contratado option:selected").val(),
            nrProtocolo: $("#nr_protocolo").val(),
            nrContrato: $("#nr_contrato").val(),
            nrPedido: $("#nr_pedido").val(),
            nrEmpenho: $("#nr_empenho").val(),
            tpGasto: $("#tipo_gasto option:selected").val(),
            sitDoc: $("#situacao option:selected").val(),
            remetente: $("#remetente option:selected").val()

        }
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaDocumentosFiscais",
                "dados": Dados
            },
            "success": function (response) {
                func.carregaTabelaPadrao('tabela', response, [4], true);
            }
        });
    }

    $("body").on("click", ".btn-pesquisar", function () {
        lista();
    });

    $('body').on('click', '.ver_documento', function (e) {
        var id = $(this).val();
        window.open("/pages/financeiro/gdof/documentoFiscal/ver_documento/index.php?&id=" + id);
    });
    
    $('body').on('click', '.editar', function (e) {
        var id = $(this).val();
        window.location.href = "/pages/financeiro/gdof/documentoFiscal/edit_documento/index.php?&id=" + id;
    });
    
    
    

    $("body").on('click', '.enviarDoCumento', function () {
        id = $(this).val();

        $('#modalEncaminhar').modal();
    });

    $("body").on("change", "#tipoDestinatario", function () {
        var $this = $(this);
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaDestinatarioPorTipo",
                "dados": $this.val()
            },
            "success": function (response) {
                $("#destinatario").html(response);
            }
        });
    });

    $("body").on("click", ".enviarEncaminhamento", function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();

            if ($("#tipoDestinatario option:selected").val() == 0) {
                func.modalAlert("Nenhuma tipo foi selecionado.");
                return false;
            }

            if ($("#destinatario option:selected").val() == 0) {
                func.modalAlert("Nenhuma Destinatario foi selecionado.");
                return false;
            }

            var dados = {
                "tipoDestinatario": $("#tipoDestinatario").val(),
                "destinatario": $("#destinatario").val(),
                "id": id
            }
            $('#modalEncaminhar').modal('hide');
            $.ajax({
                "url": "/pages/financeiro/gdof/documentoFiscal/encaminha_documento/request.php",
                "method": "POST",
                "dataType": "html",
                "data": {
                    "acao": "cadastrarEncaminhamento",
                    "dados": dados
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
                        func.fechaModalReload();
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
    
    $('body').on('click', '.excluir', function (e) {
       
        var $this = $(this);        
        var item = $this.closest('tr').data('objeto');
        var id = item.id_documento_fiscal;
        item = item.nr_documento_fiscal;        

        bootbox.confirm({
            title: 'Cancelamento do Documento Fiscal',
            message: 'Você tem Certeza que deseja continuar com o \n\
                Cancelamento do Documento Fiscal <span class="text-danger">' + item + '</span>?\n\
                <br> \n\
                <div class="form-group"> \n\
                    <label for="rem_justificativa">Justificativa: <span class="text-danger">*</span></label> \n\
                    <div class="input-group"> \n\
                        <span class="input-group-addon"> \n\
                            <p class="fa fa-list inputPFa"></p> \n\
                        </span> \n\
                        <textarea id="rem_justificativa" class="form-control"></textarea>\n\
                    </div> \n\
                </div>',           
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
                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);                        
                        return true;
                    }                    
                    if($("#rem_justificativa").val() == ""){
                        func.modalAlert("É Necessário Informar um Justificativa.");                        
                        return true;
                    }
                    
                    var dados = {
                        id: id,
                        justificativa: $("#rem_justificativa").val()
                    }

                    $.ajax({
                        "url": "request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "removerDocumentoFiscal",
                            "dados": dados
                        },
                        "success": function (response) {    
                            
                            if (response.trim() == "SessaoExpirada") {
                                func.modalAlert(func.msgSemPermissao);
                                return true;
                            }

                            try {
                                response = JSON.parse(response);
                            } catch (e) {
                                func.modalAlert(func.msgErroPadrao);                                
                                return true;
                            }

                            if (response.tipoMsg === "Erro") {
                                if (response.tipoExibicao === "console") {                                    
                                    func.modalAlert(func.msgErroPadrao);
                                    return false;
                                } else if (response.tipoExibicao === "alert") {
                                    func.modalAlert(response.msg);
                                    return true;
                                }
                            } else if (response.tipoMsg === "ok") {
                                func.modalAlert(response.msg, 'success');
                                $('.modal-alert').on('hidden.bs.modal', function (e) {
                                    location.reload();
                                });
                                return true;
                            } else {                                
                                func.modalAlert(func.msgErroPadrao);
                                return true;
                            }
                        },
                        "error": function (response) {                            
                            func.modalAlert(func.msgErroPadrao);
                            return true;
                        }
                    });
                }
            }
        });

    });


});
