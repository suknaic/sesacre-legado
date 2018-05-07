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
  
    function lista() {
        
        var Dados = {            
            pas : $("#pas").val()
        }                
        $.ajax({
            "url": "/model/pla/pta/request.php",
            "dataType": 'html',
            "data": {
                acao: "retornaBox",
                dados: Dados
            },
            "success": function (response) {
                $('.box-ptas').html(response);                
            }
        });
    }
    lista();               
   
   
    $('body').on('click', '.btn-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();
            var $this = $(this);
            $this.prop("disabled", true);
            var Dados = {
                pas: $("#pas").val(),
                nome: $("#nome").val(),              
                dt_inicio: $("#dt_inicio").val(),
                dt_fim: $("#dt_fim").val()                
            }
            
            if (Dados.nome == "" || Dados.pas == "0"                    
                    || Dados.dt_inicio == "" || Dados.dt_fim == "") {
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }
           
            $.ajax({
                "url": "/model/pla/pta/request.php",
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
                id: $this.val(),
                pas: $("#pas").val(),
                nome: $("#nome").val(),                
                dt_inicio: $("#dt_inicio").val(),
                dt_fim: $("#dt_fim").val()                
            }
            
            if (Dados.nome == "" || Dados.pas == "0"                    
                    || Dados.dt_inicio == "" || Dados.dt_fim == ""
                    || Dados.id == "0") {                        
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;
            }

            $.ajax({
                "url": "/model/pla/pta/request.php",
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
                    console.log(response);
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            });

            $this.prop("disabled", false);
        }
    });
    
    $('body').on('click', '.btn-pta-remover', function (e) {

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
                        "url": "/model/pla/pta/request.php",
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
                            console.log(response);
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        }
                    });
                }
            }
        });
    });
   
   $('body').on('click', '.btn-pta-edit', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {            
            var $this = $(this);
            $("#nome").val($this.closest('.dadosPta').attr('nome'));                                
            $("#dt_inicio").val(($this.closest('.dadosPta').attr('dt_inicio')));
            $("#dt_fim").val(($this.closest('.dadosPta').attr('dt_fim')));            
            $(".btn-salvar").hide();
            $(".btn-editar").val($this.val());             
            $(".btn-editar").show();
            $('html, body').animate({
                scrollTop: $('#page-content').offset().top + 'px'
            }, 'slow');
            $('#nome').focus();
        }
    });
               
   
    $('body').on('click', '.btn-limpar', function (e) {
        window.location.reload();   
    });
    
    
    
    
    
    //***** Relacionado ao Titulo do PTA *** //            
    
    $('body').on('click', '.btn-titulo-salvar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();                        
            var $this = $(this);
            $this.prop("disabled", true);
            var Dados = {
                pta : $this.val(),
                titulo: $('#titulo').val(),
                objeto: $("#objeto").val(),
                justificativa: $("#justificativa").val(),
                programa: $("#programa option:selected").val(),
                ppa_proj_ati: $("#proj_ppa_ati").val()
            }
            
            if(Dados.pta == 0 || Dados.titulo == ""
                    || Dados.programa == 0 || Dados.ppa_proj_ati == 0){
                $('#modalTitulo').modal('hide');
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;                
            }
                        
            $.ajax({
                "url": "/model/pla/pta/request.php",
                "dataType": "html",
                "data": {
                    "acao": "cadTitulo",
                    "dados": Dados
                },
                "success": function (response) {
                    
                    if (response.trim() == "SessaoExpirada") {
                        $('#modalTitulo').modal('hide');
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        $('#modalTitulo').modal('hide');
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
                            $('#modalTitulo').modal('hide');
                            func.modalAlert(func.msgErroPadrao);
                            $this.prop("disabled", false);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $('#modalTitulo').modal('hide');
                            func.modalAlert(response.msg);
                            $this.prop("disabled", false);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        $('#modalTitulo').modal('hide');
                        func.modalAlert(response.msg, 'primary');
                        func.fechaModalReload();
                        $this.prop("disabled", false);
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        $('#modalTitulo').modal('hide');
                        func.modalAlert(func.msgErroPadrao);
                        $this.prop("disabled", false);
                        return false;
                    }
                },
                "error": function (response) {
                    console.log(response);
                    $('#modalTitulo').modal('hide');
                    func.modalAlert(func.msgErroPadrao);
                    $this.prop("disabled", false);
                    return false;
                }
            });            
            $this.prop("disabled", false);            
        }
    });
    
    $('body').on('click', '.btn-titulo-editar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();                        
            var $this = $(this);            
            $this.prop("disabled", true);
            var Dados = {
                id : $this.val(),
                titulo: $('#titulo').val(),
                objeto: $("#objeto").val(),
                justificativa: $("#justificativa").val(),
                programa: $("#programa option:selected").val(),
                ppa_proj_ati: $("#proj_ppa_ati").val()                
            }
            
            if(Dados.id == 0 || Dados.titulo == ""
                    || Dados.programa == 0 || Dados.ppa_proj_ati == 0){
                $('#modalTitulo').modal('hide');
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;                
            }
                        
            $.ajax({
                "url": "/model/pla/pta/request.php",
                "dataType": "html",
                "data": {
                    "acao": "edtTitulo",
                    "dados": Dados
                },
                "success": function (response) {
                    
                    if (response.trim() == "SessaoExpirada") {
                        $('#modalTitulo').modal('hide');
                        func.modalAlert(func.msgSemPermissao);
                        return false;
                    }

                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        $('#modalTitulo').modal('hide');
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
                            $('#modalTitulo').modal('hide');
                            func.modalAlert(func.msgErroPadrao);
                            $this.prop("disabled", false);
                            return false;
                        } else if (response.tipoExibicao === "alert") {
                            $('#modalTitulo').modal('hide');
                            func.modalAlert(response.msg);
                            $this.prop("disabled", false);
                            return false;
                        }
                    } else if (response.tipoMsg === "ok") {
                        $('#modalTitulo').modal('hide');
                        func.modalAlert(response.msg, 'primary');
                        func.fechaModalReload();
                        $this.prop("disabled", false);
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);
                        $('#modalTitulo').modal('hide');
                        func.modalAlert(func.msgErroPadrao);
                        $this.prop("disabled", false);
                        return false;
                    }
                },
                "error": function (response) {
                    console.log(response);
                    $('#modalTitulo').modal('hide');
                    func.modalAlert(func.msgErroPadrao);
                    $this.prop("disabled", false);
                    return false;
                }
            });            
            $this.prop("disabled", false);            
        }
    });
    
    $('body').on('click', '.removerTitulo', function (e) {

        var $this = $(this);
        var id = $this.attr('value');
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
                        "url": "/model/pla/pta/request.php",
                        "dataType": "html",
                        "data": {
                            "acao": "remTitulo",
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
                            console.log(response);
                            func.modalAlert(func.msgErroPadrao);
                            return false;
                        }
                    });
                }
            }
        });
    });
            
    function buscaProgramaTrabalho(pta){
        var Dados = {
            pta : pta
        }                        
        if($('#programa option').length > 0){
            $("#modalTitulo").modal('show'); 
            buscaPPAProjAti(pta);
            return false;
        }
        $.ajax({
            "url": "/model/pla/pta/request.php",
            "dataType": 'html',
            "data": {
                acao: "retornaProgramaTrabalho",
                dados: Dados
            },
            "success": function (response) {                
                $('#programa').html(response);    
                buscaPPAProjAti(pta);
            }
        });
    }
    
    function buscaPPAProjAti(pta){
        var Dados = {
            pta : pta
        }                        
        if($('#proj_ppa_ati option').length > 0){
            $("#modalTitulo").modal('show'); 
            return false;
        }
        $.ajax({
            "url": "/model/pla/pta/request.php",
            "dataType": 'html',
            "data": {
                acao: "retornaPpaProjAti",
                dados: Dados
            },
            "success": function (response) {                
                $('#proj_ppa_ati').html(response);    
                $("#modalTitulo").modal('show'); 
            }
        });
    }
    

    $('body').on('click', '.btn-cad-titulo', function(e){       
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {            
            $('.btn-titulo-salvar').val($(this).val());     
            buscaProgramaTrabalho($(this).val());                                       
        }
    });
    
    $('body').on('click', '.editarTitulo', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            var $this = $(this);
            
            var Dados = {
                id : $this.attr('value')
            }
            
            $.ajax({
                "url": "/model/pla/pta/request.php",
                "dataType": 'html',
                "data": {
                    acao: "retornaDadosEdicaoPtaTitutlo",
                    dados: Dados
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
                        
                        $("#titulo").val(response.msg.nome);
                        $("#objeto").val(response.msg.objeto);
                        $("#justificativa").val(response.msg.justificativa);
                        $("#programa").html(response.msg.programa);
                        $("#proj_ppa_ati").html(response.msg.proj_ppa_ati);
                        
                        $("#modalTitulo").modal('show'); 
                        $(".btn-titulo-salvar").hide();
                        $(".btn-titulo-editar").show();
                        $('.btn-titulo-editar').val($this.attr('value'));
                                                
                        return false;
                    } else {
                        console.log('Ultimo else');
                        console.log(response);                        
                        func.modalAlert(func.msgErroPadrao);                        
                        return false;
                    }                                                                                
                }
            });                                      
        }
    });
    
    $('#modalTitulo').on('hidden.bs.modal', function (e){
        $("#titulo").val("");
        $("#objeto").val("");
        $("#justificativa").val("");
        $("#programa").val(0);
        $("#proj_ppa_ati").val(0);
        $(".btn-titulo-salvar").val(0);
        $(".btn-titulo-salvar").show();
        $(".btn-titulo-editar").val(0);
        $(".btn-titulo-editar").hide();
        $(".btn-titulo-remover").val(0);
    });


});
