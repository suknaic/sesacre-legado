
function lista(){
    $.ajax({
        "url": "request.php",
        "dataType": 'html',
        "data": {
            "acao": "retornaVinculos"
        },
        "success": function (response) {  
            func.carregaTabelaPadrao('tabela', response, [4]);
        }
    });
}

$(document).ready(function () {  
    
    func = new Funcoes();
    
    $('body').find('select').select2({
        width: '100%'
    });
    
    lista();
    
    $('select').change( function (){
        $(this).select2();
    });
    
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            
            var tipoLotacao = $("#id_doc_lotacao option:selected").data('objeto');
            
            var Dados = {
                idPessoa: $("#id_pessoa option:selected").val(),
                idDocTipoLotacao: tipoLotacao.id_doc_tipo_lotacao,
                idLotacao: tipoLotacao.id_lotacao,
                idTramitacao: $("#id_tramitacao option:selected").val()
            }

            if (Dados.idPessoa == "0" || Dados.idDocTipoLotacao == "0" || Dados.idDocTipoLotacao == "" || 
                    Dados.idTramitacao == "0" || Dados.idLotacao == "" || Dados.idLotacao == "0"){
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }
            
            $.ajax({
                "url": "request.php",
                "dataType": "html",
                "method": "post",
                "data": {
                    "acao": "salvarVincLiquidacao",
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
    
    $('body').on('click', '.remover-vinculo', function (e) {

        var $this = $(this);
        var dados = $(this).closest('tr').data('objeto');
        var id = dados.id_vincular_tramitacao;
        
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
                        id: id
                    }

                    $.ajax({
                        "url": "request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "removerVincLiquidacao",
                            "dados": Dados
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


