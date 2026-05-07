$(document).ready(function () {

    func = new Funcoes();
    
    function lista() {
        
        var Dados = {            
            pas : $("#pas").val()
        }                
        $.ajax({
            "url": "/model/pla/pas/request.php",
            "dataType": 'html',
            "data": {
                acao: "retornaPTAs",
                dados: Dados
            },
            "success": function (response) {                
                func.carregaTabelaPadrao('tabela', response, [2], true);
            }
        });
    }
    lista();
    
    function valoresLiberado() {
        
        var Dados = {            
            pas : $("#pas").val()
        }                
        $.ajax({
            "url": "/model/pla/pas/request.php",
            "dataType": 'html',
            "data": {
                acao: "retornaValoresLiberado",
                dados: Dados
            },
            "success": function (response) {                
                $("#valoresLiberado").html(response);
            }
        });
    }
    valoresLiberado();
           

    $('body').on('click', '.btn-enviar-planejamento', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);            
            $("#modalEnvioPlanejamento").modal('show');                                    
        }
    });
    
    
    $('body').on('click', '.btn-envia-planejamento', function (e) {
        
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();                        
            var $this = $(this);
            $this.prop("disabled", true);
            var Dados = {
                pas : $("#pas").val(),
                mensagem: $('.modalMsgEnvio').val()                           
            }
            
            if(Dados.pas == 0 ){
                $('#modalEnvioPlanejamento').modal('hide');
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;                
            }
                        
            $.ajax({
                "url": "/model/pla/pas/request.php",
                "dataType": "html",
                "data": {
                    "acao": "enviarPlanejamento",
                    "dados": Dados
                },
                "success": function (response) {                 
                    
                    if (response.trim() == "SessaoExpirada") {
                        $('#modalEnvioPlanejamento').modal('hide');
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        $('#modalEnvioPlanejamento').modal('hide');
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
                            $('#modalEnvioPlanejamento').modal('hide');
                            func.modalAlert(func.msgErroPadrao);
                            $this.prop("disabled", false);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $('#modalEnvioPlanejamento').modal('hide');
                            func.modalAlert(response.msg);
                            $this.prop("disabled", false);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        $('#modalEnvioPlanejamento').modal('hide');
                        func.modalAlert(response.msg, 'primary');
                        func.fechaModalReload();
                        $this.prop("disabled", false);
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        $('#modalEnvioPlanejamento').modal('hide');
                        func.modalAlert(func.msgErroPadrao);
                        $this.prop("disabled", false);
                        return false;
                    }
                },
                "error": function (response) {
                    console.log(response);
                    $('#modalEnvioPlanejamento').modal('hide');
                    func.modalAlert(func.msgErroPadrao);
                    $this.prop("disabled", false);
                    return false;
                }
            });            
            $this.prop("disabled", false);            
        }
    });


});
