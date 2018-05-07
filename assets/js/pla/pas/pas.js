$(document).ready(function () {

    func = new Funcoes();
          
    $("#dt_inicio").mask("99/99/9999");
    $("#dt_fim").mask("99/99/9999");
    
    //datapiker, plugins para data
    $('#dt_inicio').datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR"
    });    
     //datapiker, plugins para data
    $('#dt_fim').datepicker({
        format: 'dd/mm/yyyy',
        language: "pt-BR"
    });
  
    $('body').on('keyup', '#dt_inicio', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);            
            
            if(!isNaN($this.val().substring(6, 10))){
                $("#nome").val(`${$("#nome").attr('programa')} ${$this.val().substring(6, 10)}`);
            }                        
        }
    });
  
  
    function lista() {
        
        var Dados = {            
            lotacao : $("#lotacao").val()
        }                
        $.ajax({
            "url": "/model/pla/pas/request.php",
            "dataType": 'html',
            "data": {
                acao: "pesquisaLotacao",
                dados: Dados
            },
            "success": function (response) {                
                func.carregaTabelaPadrao('tabela', response, [6], true);
            }
        });
    }
    lista();
    
    function carregaPas(){
        var Dados = {           
            pas : $("#pas").val(),
            lotacao: $("#lotacao").val()
        }                
        $.ajax({
            "url": "/model/pla/pas/request.php",
            "dataType": 'html',
            "data": {
                acao: "carregaFormularioPas",
                dados: Dados
            },
            "success": function (response) {
                
                try {
                    response = JSON.parse(response);
                } catch (e) {                    
                    console.log(response);
                    return false;
                }
                
                if(response.tipoMsg == "nao_encontrou"){
                    func.modalAlert(func.msgRegistroNaoEncontrado);
                    $('.modal-alert').on('hidden.bs.modal', function (e) {                        
                        window.location.href = "pas.php?token="+Dados.lotacao;                        
                    });
                }
                if(response.tipoMsg == "ok"){
                    var info = response.msg;
                    $("#nome").val(info.nome);
                    $("#pes").val(info.pes);
                    $("#pes_resp").val(info.pessoa_resp);
                    $("#pes_exec").val(info.pessoa_exec);
                    $("#dt_inicio").val(info.dt_inicio);
                    $("#dt_fim").val(info.dt_fim);
                    $("#observacao").val(info.obs);
                    $(".btn-salvar").hide();
                    $(".btn-editar").show();
                    
                }                                

            }
        });
    }
    if($("#pas").val() != 0){
        carregaPas()
    }
    
   
   $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var Dados = {
                lotacao: $("#lotacao").val(),
                nome: $("#nome").val(),
                pes: $("#pes option:selected").val(),
                pessoa_resp: $("#pes_resp option:selected").val(),
                pessoa_exec: $("#pes_exec option:selected").val(),
                dt_inicio: $("#dt_inicio").val(),
                dt_fim: $("#dt_fim").val(),
                obs: $("#observacao").val()
            }
            
            if (Dados.lotacao == "" || Dados.nome == "" || Dados.pes == "0"
                    || Dados.pessoa_exec == "0" || Dados.pessoa_resp == "0"
                    || Dados.dt_inicio == "" || Dados.dt_fim == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }
           
            $.ajax({
                "url": "/model/pla/pas/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cad",
                    "dados": Dados
                },
                "success": function (response) {
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
    
    
    $('body').on('click', '.btn-editar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            
            var Dados = {
                id: $("#pas").val(),
                lotacao: $("#lotacao").val(),
                nome: $("#nome").val(),
                pes: $("#pes option:selected").val(),
                pessoa_resp: $("#pes_resp option:selected").val(),
                pessoa_exec: $("#pes_exec option:selected").val(),
                dt_inicio: $("#dt_inicio").val(),
                dt_fim: $("#dt_fim").val(),
                obs: $("#observacao").val()
            }
            
            if (Dados.lotacao == "" || Dados.nome == "" || Dados.pes == "0"
                    || Dados.pessoa_exec == "0" || Dados.pessoa_resp == "0"
                    || Dados.dt_inicio == "" || Dados.dt_fim == "" || Dados.pas == "0") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "/model/pla/pas/request.php",
                "dataType": "html",
                "data": {
                    "acao": "edt",
                    "dados": Dados
                },
                "success": function (response) {
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
    
    $('body').on('click', '.btn-remover', function (e) {

        var $this = $(this);
        var id = $this.val();
        var item = $this.attr("nome");

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

                    if (id == "") {
                        func.modalAlert(func.msgPreencherCampos);
                        $this.prop("disabled", false);
                        return false;
                    }

                    $.ajax({
                        "url": "/model/pla/pas/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "rem",
                            "dados": Dados
                        },
                        "success": function (response) {
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
                                $('.modal-alert').on('hidden.bs.modal', function (e) {
                                    window.location.href = "pas.php?token="+$("#lotacao").val();    
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
                            console.log(response);
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        }
                    });


                }
            }
        });

    });
   
   
   
    $('body').on('click', '.btn-limpar', function (e) {
        window.location.href = "pas.php?token="+$("#lotacao").val();      
    });


});
