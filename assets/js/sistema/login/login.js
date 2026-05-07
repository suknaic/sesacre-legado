
$(document).ready(function(){
    
        
    func = new Funcoes();        

    $('body').on('click', '#btn-logar', function(e){        
      e.stopPropagation();
      if (e.isDefaultPrevented()) {        
      } else {
          e.preventDefault();
          var $this = $(this);
          $this.prop( "disabled", true );          
          var login = $("#login").val();
          var senha = $("#senha").val();        
          $.ajax({
              "url": "/model/sistema/login/request.php",
              "dataType": "html",
              "data": {
                "acao": "logar",
                "login": login,
                "senha": senha
              },
              "success": function (response) {
                  console.log(response);
                  $this.prop( "disabled", false );
                  if (response == "SessaoExpirada") {
                        func.modalAlert("Sistema em Manutenção.");
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            location.reload();
                        });                         
                        return false;
                  }                
                  
                  try {
                      response = JSON.parse(response);
                  } catch (e) {
                      func.modalAlert(func.msgErroPadrao, 'danger');
                      // console.log("Parse JSON");
                      return false;
                  }

                  if (response.tipoMsg === "Erro") {
                      if (response.tipoExibicao === "console") {
                          // console.log('Console Mensagem');
                          func.modalAlert(func.msgErroPadrao, 'danger');
                          return false;
                      } else if (response.tipoExibicao === "alert") {                        
                          func.modalAlert(response.msg);                        
                          return false;
                      }
                  } else if (response.tipoMsg === "ok") {                    
                      location.reload();
                      return false;
                  } else if (response.tipoMsg === "novaSenha") {                          
                      novaSenha(response.msg, senha);                    
                      return false;               
                  } else {
                      // console.log('Ultimo else');
                      func.modalAlert(func.msgErroPadrao, 'danger');
                      return false;
                  }
              },
              "error": function (response) {
                  $this.prop( "disabled", false );
                  func.modalAlert(func.msgErroPadrao, 'danger');
                  return false;
              }
          });

          $this.prop( "disabled", false );
      }
    });

  
    function novaSenha(texto, senha){       
        func.modalAlert(texto);        
        $('.modal-alert').on('hidden.bs.modal', function (e) {
            $("#senha").focus();
        });

        $("#senha").val("");
        $('.campoSenha').removeClass("has-success");
        $('.campoSenha').find('input').attr("placeholder", "Nova Senha");
        $('.campoSenha').find('span').removeClass("glyphicon-ok");
        var campoSenha = $('.campoSenha').clone();
        campoSenha.find("input").attr({
                                        "name": "senhaR",
                                        "id": "senhaR",
                                        "placeholder": "Repetir Nova Senha",
                                        "value": ""
                                    });
        $('.campoSenha').after(campoSenha);
        $('.campoSenha').after("<input type='hidden' name='senhaA' id='senhaA' value='"+senha+"' >");
        
        $("#btn-logar").attr("id", "btn-mudarSenha");
        
    }
    
    
    $('body').on('click', '#btn-mudarSenha', function(e){                   
        e.stopPropagation();
        if (e.isDefaultPrevented()) {        
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop( "disabled", true );
            var login = $("#login").val();
            var senhaA = $("#senhaA").val();
            var senha = $("#senha").val();
            var senhaR = $("#senhaR").val();
            if(senha != senhaR){
                alert(func.msgSenhaNaoIgual);
                $this.prop( "disabled", false );
                return false;
            }
            $.ajax({
                "url": "/model/sistema/login/request.php",
                "dataType": "html",
                "data": {
                  "acao": "mudarSenhaLogin",
                  "login": login,
                  "senha": senha,
                  "senhaR": senhaR,
                  "senhaA": senhaA
                },
                "success": function (response) {

                    $this.prop( "disabled", false );
                    if (response == "SessaoExpirada") {
                        alert('Sessão Expirada');
                        location.reload();
                        return false;
                    }                

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        // console.log("Parse JSON");
                        return false;
                    }

                    if (response.tipoMsg === "Erro") {
                        if (response.tipoExibicao === "console") {
                            // console.log('Console Mensagem');
                            func.modalAlert(func.msgErroPadrao, 'danger');
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
                        // console.log('Ultimo else');
                        func.modalAlert(func.msgErroPadrao, 'danger');
                        return false;
                    }
                },
                "error": function (response) {
                    $this.prop( "disabled", false );
                    func.modalAlert(func.msgErroPadrao, 'danger');
                    return false;
                }
            });

            $this.prop( "disabled", false );
        }
    });

    $('body').on('click', '#cadFornecedor', function(e){
        top.location.href = "/pages/fornecedor/cadFornecedor/index.php";
    });

    $('body').on('keypress', '#senha', function (e) {
        var key = e.which;
        if (key == 13) {                
            $("#btn-logar").trigger('click');
            return false;
        }        
    });
    
    $('body').on('keypress', '#senhaR', function (e) {
        var key = e.which;
        if (key == 13) {                
            $("#btn-mudarSenha").trigger('click');
            return false;
        }        
    });
    
    $('body').keyup(function(e){      
        if(e.keyCode == 32){               
           $('.modal').modal('hide');
        }
    });
            
});

