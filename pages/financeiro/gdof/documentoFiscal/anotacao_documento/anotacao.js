


$(document).ready(function () {
    $('body').on('click','.btn-addAnotacao', function(){
       
        var id_documento = $("#id_documento").val();
        var nr_documento = $("#nr_documento").val();
       
        bootbox.confirm({
            title: 'Adicionar Anotação',
            message: 'Você tem Certeza que deseja continuar com a \n\
                Inserção de Anotação para Documento Fiscal <span class="text-danger">' + nr_documento + '</span>?\n\
                <br> \n\
                <div class="form-group"> \n\
                    <label for="anotacao">Anotacao: <span class="text-danger">*</span></label> \n\
                    <div class="input-group"> \n\
                        <span class="input-group-addon"> \n\
                            <p class="fa fa-list inputPFa"></p> \n\
                        </span> \n\
                        <textarea id="anotacao" class="form-control"></textarea>\n\
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
                
//                if (result) {                   
//                    if (id == "") {
//                        func.modalAlert(func.msgPreencherCampos);                        
//                        return true;
//                    }                    
//                    if($("#rem_justificativa").val() == ""){
//                        func.modalAlert("É Necessário Informar um Justificativa.");                        
//                        return true;
//                    }
//                    
//                    var dados = {
//                        id: id,
//                        justificativa: $("#rem_justificativa").val()
//                    }
//
//                    $.ajax({
//                        "url": "request.php",
//                        "dataType": "html",
//                        "data": {
//                            "acao": "removerDocumentoFiscal",
//                            "dados": dados
//                        },
//                        "success": function (response) {    
//                            
//                            if (response.trim() == "SessaoExpirada") {
//                                func.modalAlert(func.msgSemPermissao);
//                                return true;
//                            }
//
//                            try {
//                                response = JSON.parse(response);
//                            } catch (e) {
//                                func.modalAlert(func.msgErroPadrao);                                
//                                return true;
//                            }
//
//                            if (response.tipoMsg === "Erro") {
//                                if (response.tipoExibicao === "console") {                                    
//                                    func.modalAlert(func.msgErroPadrao);
//                                    return false;
//                                } else if (response.tipoExibicao === "alert") {
//                                    func.modalAlert(response.msg);
//                                    return true;
//                                }
//                            } else if (response.tipoMsg === "ok") {
//                                func.modalAlert(response.msg, 'success');
//                                $('.modal-alert').on('hidden.bs.modal', function (e) {
//                                    location.reload();
//                                });
//                                return true;
//                            } else {                                
//                                func.modalAlert(func.msgErroPadrao);
//                                return true;
//                            }
//                        },
//                        "error": function (response) {                            
//                            func.modalAlert(func.msgErroPadrao);
//                            return true;
//                        }
//                    });
//                }
            }
        });
    })
});

