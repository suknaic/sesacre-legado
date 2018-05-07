$(document).ready(function () {

    func = new Funcoes();              
                         
    function abreModalAno(){
        
        var panel = $('.selecaoAno').clone();
                        
        panel.show();
       
        bootbox.confirm({
            title: 'Caixa de Seleção',
            message: panel,
            buttons: {
                'cancel': {
                    label: 'Fechar',
                    className: 'btn-default btn-rounded'
                },
                'confirm': {
                    label: 'Avançar',
                    className: 'btn-primary btn-rounded'
                }
            },
            callback: function (result) {
                if (result) {
                    var ano = $(".bootbox").find('.anoSelect option:selected').val();                                                                                 
                    window.location.href = "index.php?token="+ano;
                }
            }
        });                
    }
    if($("#ano").val() == 0){
        abreModalAno();
    }                  
    
    $('body').on('click', '.btn-salvar', function (e) {
        
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();                        
            var $this = $(this);
            $this.prop("disabled", true);
            var Dados = {
                ano : $("#ano").val()                                     
            }
            
            if(Dados.ano == 0 ){                
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;                
            }
                        
                        
            $.ajax({
                "url": "/model/orcamento/qdd/request.php",
                "dataType": "html",
                "data": {
                    "acao": "criarQdd",
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
                        $this.prop("disabled", false);
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
                            console.log(response);                            
                            func.modalAlert(func.msgErroPadrao);
                            $this.prop("disabled", false);
                            return false;
                        } else if (response.tipoExibicao === "alert") {                            
                            func.modalAlert(response.msg);
                            $this.prop("disabled", false);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {                        
                        func.modalAlert(response.msg, 'success');
                        func.fechaModalReload();
                        $this.prop("disabled", false);
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);                        
                        func.modalAlert(func.msgErroPadrao);
                        $this.prop("disabled", false);
                        return false;
                    }
                },
                "error": function (response) {
                    console.log(response);                    
                    func.modalAlert(func.msgErroPadrao);
                    $this.prop("disabled", false);
                    return false;
                }
            });            
            $this.prop("disabled", false);            
        }
    });
    
    $('body').on('click', '.btn-remover', function (e) {
        
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();                        
            var $this = $(this);
            $this.prop("disabled", true);
            var Dados = {
                ano : $("#ano").val()                                     
            }        
            if(Dados.ano == 0 ){                
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;                
            }            

            bootbox.confirm({
                title: 'Caixa de Confirmação',
                message: 'Você tem Certeza que deseja continuar com a Exclusão do Item <span class="text-danger">' + Dados.ano + '</span>?',
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
                            "url": "/model/orcamento/qdd/request.php",
                            "dataType": "html",
                            "data": {
                                "acao": "removerQdd",
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
            
            
            $this.prop("disabled", false);            
        }
    });
    
    
    
    
    
       
});
