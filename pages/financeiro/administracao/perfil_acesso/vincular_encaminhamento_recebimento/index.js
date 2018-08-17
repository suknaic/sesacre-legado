$(document).ready(function () {   
    func = new Funcoes();
    
    $('body').find('select').select2({
        width: '100%'
    });
    
    function lista(){
        $.ajax({
            "url": "request.php",
            "dataType": 'html',
            "data": {
                "acao": "retornaDocVincTramitacoes"
            },
            "success": function (response) {  
//                console.log(response);
                func.carregaTabelaPadrao('tabela', response, [4]);
            }
        });
    }
    
    lista();
    
    $('body').on('change','#tp_tramitacao',function (e){
        e.preventDefault();
        
        var tp_tramitacao = $("#tp_tramitacao option:selected").val();
        
        //converte para inteiro o valor da opção selecionada
        tp_tramitacao = parseInt(tp_tramitacao);
        
       
        switch (tp_tramitacao) {
            case 1:
                $("#labelTpLotacao").html('Tipo do Destinatário/Destinatário: <span class="text-danger">*</span>');
                $('#id_doc_lotacao option[value="0"]').text("Selecione o Tipo de Destinatário/Destinatário");
                break;
                
            case 2:
                $("#labelTpLotacao").html('Tipo do Remetente/Remetente: <span class="text-danger">*</span>');
                $('#id_doc_lotacao option[value="0"]').text("Selecione o Tipo de Remetente/Remetente");

                break;
        }
       
        $('#id_doc_lotacao').select2();
    });
    
    
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            
            var Dados = {
                idPessoa: $("#id_pessoa option:selected").val(),
                idDocLotacao: $("#id_doc_lotacao option:selected").val(),
                tpTramitacao: $("#tp_tramitacao option:selected").val()
            }

            if (Dados.idPessoa == "0" || Dados.idDocLotacao == "0" || Dados.tpTramitacao == "0"){
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "request.php",
                "dataType": "html",
                "method": "post",
                "data": {
                    "acao": "salvarDocVincTramitacao",
                    "dados": Dados
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
        var dados = $(this).closest('tr').data('objeto');
        var tipo = dados.tramitacao;
        
        var id = 0;
        if (tipo == '1') { //Encaminhamento
            id = dados.id_doc_vinc_encaminhamento;
        } else if(tipo == '2'){ //Recebimento
            id = dados.id_doc_vinc_recebimento;
        }
        
        
        var item = $this.closest('tr').find('td:eq(0)').text() + ' - ' + $this.closest('tr').find('td:eq(1)').text() + ' - ' + $this.closest('tr').find('td:eq(2)').text() ;


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
                        id: id,
                        tipo: tipo
                    }

                    $.ajax({
                        "url": "request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "removerDocVincTramitacao",
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
                                console.log('testando');
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
                            console.log(response);
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        }
                    });


                }
            }
        });

    });
});