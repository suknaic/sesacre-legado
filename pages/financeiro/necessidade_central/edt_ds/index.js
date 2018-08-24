
$(document).ready(function () {      
    
    //instacinado fucoes js
    func = new Funcoes();
    var url = "request.php";     
    
    //========================================================================================================
    
        
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();                        
            var $this = $(this);              
            $this.prop("disabled", true);
            
            
            
            $.ajax({
                "url": "/model/financeiro/necessidade_central/requestPedido.php",
                "dataType": "html",
                "method": "post",
                "data": {
                    "acao": "editar_justificativa",
                    "pedido": $("#pedido").val(),
                    "justificativa": $("#n_justificativa").val()
                },
                "success": function (response) {
                    
                    console.log(response)                    
                    
                    if (response.trim() === "SessaoExpirada") {
                        func.modalAlert(func.msgSemPermissao);
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            top.location = "/pages/index.php";
                        });
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
                        func.modalAlert(response.msg, 'success');
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
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }
            });
            $this.prop("disabled", false);                                               
        }
    });
    
    
                              
});
