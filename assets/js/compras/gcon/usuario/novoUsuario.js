$(document).ready(function () {
    
    //instacinado fucoes js
    func = new Funcoes();
        
        //chamando o menu do GCON
        $.ajax({
            "url": "/layout/menus/compras/gcon/menu_gcon.php",
            "dataType": "html",
            "success": function (response) {
                $("body").find("#menu_gcon").html(response);
            }
        });

        //função para limpar todos os campos
        $('body').on('click', '.btn-limpar', function (e) {
            $('.btn-salvar').prop("disabled", false);
            $("#id_usuario").select2('val','0');
            $("#id_permissao").select2('val','0');
        });
        
        //buscando o select option
        $("#id_usuario").select2();
        $("#id_permissao").select2();
        
        //Função para retornar os tecnicos 
        function retornaUsuarios(){
            $.ajax({
                "url":"/model/compras/gcon/usuario/request.php",
                "dataType":"html",
                "data":{
                    "acao":"listar_Tecnicos"
                },
                "success": function (response) {
                    $("#id_usuario").append(response);
                }
            });
        }
       
        //chamando a função retornaTecnicos
        retornaUsuarios();
        
        //Função para retornar os perfis 
        function retornaPerfis(){
            $.ajax({
                "url":"/model/compras/gcon/usuario/request.php",
                "dataType":"html",
                "data":{
                    "acao":"listar_Perfis"
                },
                "success": function (response) {
                    $("#id_permissao").append(response);
                }
            });
        }
        
        //chamando a função retornaTecnicos
        retornaPerfis();
        
        //Executa quando clica o butão Salvar
        $('body').on('click', '.btn-salvar', function (e) {
            e.stopPropagation();
            if (e.isDefaultPrevented()) {
            } else {
                e.preventDefault();
                var $this = $(this);
                $this.prop("disabled", true);
                //Array que vai para o request
                var usuario = {
                    id_usuario: $("#id_usuario").val(),
                    id_permissao: $("#id_permissao").val()
                    
                };
                //Enviando via Ajax para o request
                $.ajax({
                    "url": "/model/compras/gcon/usuario/request.php",
                    "dataType": "html",
                    "data": {
                        "acao": "cadastrar_Usuario",
                        "cadUsuario": usuario
                    },
                    
                    "success": function (response) {
                        $this.prop("disabled", false);
                        if (response.trim() === "SessaoExpirada") {
                            func.modalAlert(func.msgSemPermissao);
                            return false;
                        }

                        try {
                            response = JSON.parse(response);
                        } catch (e) {
                            func.modalAlert(func.msgErroPadrao, 'danger');
                            console.log("Parse JSON");
                            return false;
                        }

                        if (response.tipoMsg === "Erro") {
                            if (response.tipoExibicao === "console") {
                                console.log('Console Mensagem');
                                func.modalAlert(func.msgErroPadrao, 'danger');
                                return false;
                            } else if (response.tipoExibicao === "alert") {
                                func.modalAlert(response.msg, 'danger');
                                return false;
                            }
                        } else if (response.tipoMsg === "ok") {
                            func.modalAlert(response.msg, 'success');
                            $('.modal-alert').on('hidden.bs.modal', function (e) {
                                location.reload();
                            });
                            return false;
                        } else {
                            console.log('Ultimo else');
                            func.modalAlert(func.msgErroPadrao, 'danger');
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