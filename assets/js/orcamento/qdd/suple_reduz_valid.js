$(document).ready(function () {

    func = new Funcoes();     
    
    function lista() {
        $.ajax({
            "url": "/model/orcamento/qdd/request_suple_reduz_valid.php",
            "dataType": 'html',
            "data": {
                acao: "listaSupleReduzParaValidar",
                ano: $("#ano").val()
            },
            "success": function (response) {
                func.carregaTabelaPadrao('tabela', response, [4], true);

            }
        });
    }
    func.carregaTabelaPadrao('tabela', null, [4]);
    lista();
              
    $('body').on('click', '.btn-validar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);       
            $("#modalValidar").modal('show');
            $(".btn-validar-modal").val($this.val());            
        }
    });
    
    $('body').on('click', '.btn-nao-validar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);       
            $("#modalNaoValidar").modal('show');
            $(".btn-nao-validar-modal").val($this.val());            
        }
    });
    
    $('body').on('click', '.btn-validacao', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var validacao = "";
            if($this.hasClass('btn-validar-modal')){
                validacao = "1";
            }else if($this.hasClass('btn-nao-validar-modal')){
                validacao = "0";
            }
            
            var Dados = {
                id: $this.val(),
                validacao: validacao,
                ano: $("#ano").val()
                
            }          

            if (Dados.id == "" || Dados.validacao == "") {
                $('.modal').modal('hide');
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }
           
                        
            $.ajax({
                "url": "/model/orcamento/qdd/request_suple_reduz_valid.php",
                "dataType": "html",
                "data": {
                    "acao": "validar",
                    "dados": Dados
                },
                "success": function (response) {
                    $this.prop("disabled", false);
                    if (response.trim() == "SessaoExpirada") {
                        $('.modal').modal('hide');
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }
                    console.log(response);
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        $('.modal').modal('hide');
                        func.modalAlert(func.msgErroPadrao);
                        console.log("Parse JSON");
                        console.log(response);
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            console.log('Console Mensagem');
                            console.log(response);
                            $('.modal').modal('hide');
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $('.modal').modal('hide');
                            func.modalAlert(response.msg);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        $('.modal').modal('hide');
                        lista();
                        func.modalAlert(response.msg, 'success');
                        
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        $('.modal').modal('hide');
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    }
                },
                "error": function (response) {
                    $('.modal').modal('hide');
                    $this.prop("disabled", false);
                    console.log(response);
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            });

            $this.prop("disabled", false);
        }
    });
              
   
                                 
});
