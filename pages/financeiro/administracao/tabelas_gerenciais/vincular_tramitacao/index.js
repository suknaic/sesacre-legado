
$(document).ready(function () {   
    func = new Funcoes();
    
    $('#id_doc_tipo_remetente option[value="0"]').text('Selecione o Tipo de Remetente');
    $('#id_doc_tipo_destinatario option[value="0"]').text('Selecione o Tipo de Destinatário');
    
    $('body').find('select').select2({
        width: '100%'
    });
    
    //Inverte a posição do select para tipo de Remetente e Destinatário
    $('body').on('change','#tp_doc_tramitacao',function(e){
        var tipo_tramitacao = $("#tp_doc_tramitacao option:selected").val();
        if (tipo_tramitacao == '1') { //Encaminhar
            $('#remetente_conteudo').prependTo('#primeiro');
            $('#destinatario_conteudo').prependTo('#segundo');
        } else if(tipo_tramitacao == '2') { //Receber
            $('#destinatario_conteudo').prependTo('#primeiro');
            $('#remetente_conteudo').prependTo('#segundo');
        }
    });
    
    function lista(){
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaParmTramitacoes"
            },
            "success": function (response) {  
//                console.log(response);
                func.carregaTabelaPadrao('tabela', response, [4]);
            }
        });
    }
    
    lista();
    
    
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            
            var Dados = {
                idDocTpRemetente: $("#id_doc_tipo_remetente option:selected").val(),
                idDocTpDestinatario: $("#id_doc_tipo_destinatario option:selected").val(),
                idDocSit: $("#id_documento_situacao option:selected").val(),
                tpParmTramitacao: $("#tp_parm_tramitacao option:selected").val()
            }

            if (Dados.idDocTpRemetente == "0" || Dados.idDocTpDestinatario == "0" || Dados.idDocSit == "0" || Dados.tpParmTramitacao == "0"){
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "request.php",
                "dataType": "html",
                "method": "post",
                "data": {
                    "acao": "cadastrarParmTramitacao",
                    "dados": Dados
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
                        func.modalAlert(response.msg, 'primary');
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
    
    
    $('body').on('click', '.btn-excluir', function (e) {

        var $this = $(this);        
        var item = $this.closest('tr').data('objeto');
        var id = item.id_doc_parm_tramitacao;
        item = item.nm_tipo_remetente+"/"+item.tramitacao+"/"+item.nm_tipo_destinatario+"/"+item.nm_situacao;        

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
                   
                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "removerParmTramitacao",
                            "dados": id
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
                                    location.reload();
                                });
                                return false;
                            } else {                                
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

