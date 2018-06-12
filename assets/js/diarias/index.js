
function carregaTabela(){
    $.ajax({
        "url": "/model/diarias/request.php",
        "dataType": 'html',
        "data": {
            acao: "listaDiarias"
        },
        "success": 
            function (response) {
                func.carregaTabelaPadrao('tabelaDiarias', response, [8], true);
        }
    });   
}
       
$(document).ready(function () {
    func = new Funcoes();
    
    carregaTabela();
    
    $('body').on('click','.enviarDiaria', function(e){
        var $this = $(this);
        var diaria = $this.closest('tr').data("diaria");
        var idDiaria = diaria.id_diaria;
        var mensagem = "Nº: " + diaria.id_diaria + " / Proponente: " + diaria.nm_proponente + " / Proposto: " + diaria.nm_proposto;
        
        var DADOS = {
            diaria: idDiaria,
            estagio: '2', //Enviado para deferimento
            obs: 'Enviado a diária para deferimento.'
        }
        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem Certeza que deseja continuar o envio para deferimento da Diária <span class="text-danger">' + mensagem + '</span>?',
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

                    $.ajax({
                        "url": "/model/diarias/request.php",
                        "dataType": "html",
                        "method": "post",
                        "data": {
                            "acao": "atualizaEstagioDiaria",
                            "dados": DADOS
                        },
                        "success": function (response) {
//                            console.log(response);
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
                                //Reload após deletar o registro
                                $('.modal-alert').on('hidden.bs.modal', function (e) {
                                    location.reload();
                                });
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
    
    $('body').on('click', '.excluirDiaria', function (e) {
        var $this = $(this);
        
        var diaria = $this.closest('tr').data("diaria");
        var idDiaria = diaria.id_diaria;
        var mensagem = "Nº: " + diaria.id_diaria + " / Proponente: " + diaria.nm_proponente + " / Proposto: " + diaria.nm_proposto;
        bootbox.confirm({
            title: 'Caixa de Confirmação',
            message: 'Você tem Certeza que deseja continuar com a Exclusão da Diária <span class="text-danger">' + mensagem + '</span>?',
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

                    $.ajax({
                        "url": "/model/diarias/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "excluirDiaria",
                            "id": idDiaria
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
                                func.modalAlert(response.msg, 'primary');
                                //Reload após deletar o registro
                                $('.modal-alert').on('hidden.bs.modal', function (e) {
                                    location.reload();
                                });
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