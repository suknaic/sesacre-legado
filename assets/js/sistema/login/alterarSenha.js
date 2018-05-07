
$(document).ready(function () {


    func = new Funcoes();

    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var senhaAtual = $("#senhaAtual").val();
            var novaSenha = $("#novaSenha").val();
            var repetirSenha = $("#repetirSenha").val();
            
            if (novaSenha == "" || repetirSenha == "" || senhaAtual == "") {
                func.modalAlert(func.msgPreencherCampos);                
                $this.prop("disabled", false);
                return false;
            }

            if (novaSenha != repetirSenha) {
                func.modalAlert(func.msgSenhaNaoIgual);                
                $this.prop("disabled", false);
                return false;
            }
                        

            $.ajax({
                "url": "/model/sistema/login/request.php",
                "dataType": "html",
                "method": "POST",
                "data": {
                    "acao": "alterarSenha",
                    "senhaAtual": senhaAtual,
                    "novaSenha": novaSenha,
                    "repetirSenha": repetirSenha
                },
                "success": function (response) {

                    $this.prop("disabled", false);
                    if (response == "SessaoExpirada") {
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            location.reload();
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
                        func.modalAlert(func.msgSenhaAlteradaSucesso, 'success');
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            location.reload();
                        });
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
  

    $('body').on('keypress', '.formAlterarSenha', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-salvar").trigger('click');
            return false;
        }
    });

});

