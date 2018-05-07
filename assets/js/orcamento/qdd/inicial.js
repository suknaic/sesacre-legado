$(document).ready(function () {

    func = new Funcoes();     
    
    function listaDotacaoInicial() {
        $.ajax({
            "url": "/model/orcamento/qdd/request_inicial.php",
            "dataType": 'html',
            "data": {
                acao: "listaDotacaoInicial",
                ano: $("#ano").val()
            },
            "success": function (response) {             
                func.carregaTabelaPadrao('tabela', response, [4], true);

            }
        });
    }
    func.carregaTabelaPadrao('tabela', null, [4]);
    listaDotacaoInicial();
    
    
    $("body").on("focus", "#valor", function () {
        $(this).priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
            centsLimit: 2
        });
    });
                 
    
    $('body').on('click', '.btn-add', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();                        
            
            var Dados = {
                programa : $("#programa option:selected").val(),
                fonte : $("#fonte option:selected").val(),
                despesa : $("#despesa option:selected").val(),
                valor: $("#valor").val()                
            }
            
            if(Dados.programa == 0 || Dados.fonte == 0
                    || Dados.despesa == 0){
                func.modalAlert(func.msgPreencherCampos, "warning");
                return false;
            }
            
            var Texto = {
                programa : $("#programa option:selected").text(),
                fonte : $("#fonte option:selected").text(),
                despesa : $("#despesa option:selected").text(),
                valor: $("#valor").val() 
            }                   
            
            var existe = false;
            $( ".linhas" ).each(function( index ) {
                if($(this).attr('programa') == Dados.programa
                        && $(this).attr('fonte') == Dados.fonte
                        && $(this).attr('despesa') == Dados.despesa){
                    func.modalAlert("Já existe um Programa com a mesma fonte e Despesa na Lista.", "warning");
                    existe = true;
                    return false;                                         
                }                
            });
            if(existe){
                return false;
            }
            
            var linha = "<tr class='linhas' \n\
                            programa='"+Dados.programa+"' \n\
                            fonte='"+Dados.fonte+"'\n\
                            despesa='"+Dados.despesa+"'\n\
                            valor='"+Dados.valor+"'>\n\
                            <td>"+Texto.programa+"</td>\n\
                            <td>"+Texto.fonte+"</td>\n\
                            <td>"+Texto.despesa+"</td>\n\
                            <td>"+Texto.valor+"</td>\n\
                            <td class='text-center excluirLinha' role='button'>\n\
                                <p class='fa fa fa-times inputPFa text-danger'></p>\n\
                            </td>\n\
                        </tr>";                        
            $("#registros").find('tbody').append(linha);                                    
            $("#valor").val(0);
            $("#despesa").focus();
        }
    });
    
    $('body').on('keypress', '.form', function (e) {
        var key = e.which;
        if (key == 13) {
            $(".btn-add").trigger('click');                        
            return false;
        }
    });      
    
    $('body').on('click', '.excluirLinha', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else { 
            e.preventDefault();         
            $(this).closest('.linhas').remove();            
        }
    });
      
    $('body').on('click', '.btn-salvar', function (e) {
        
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();                        
            var $this = $(this);
            $this.prop("disabled", true);
            
            if($( ".linhas" ).length < 1){
                func.modalAlert('Não foi possível localizar nenhum item para ser salvo.');
                $this.prop("disabled", false);
                return false;
            }
            
            var Dados = [];
            
            $( ".linhas" ).each(function( index ) {               
                Dados.push({programa: $(this).attr('programa')
                    , fonte: $(this).attr('fonte')
                    , despesa: $(this).attr('despesa')
                    , valor: $(this).attr('valor')                    
                });                                          
            });                        
            
            if(Dados.length < 1){
                func.modalAlert('Não foi possível localizar nenhum item para ser salvo.');
                $this.prop("disabled", false);
                return false;
            }
                        
                        
            $.ajax({
                "url": "/model/orcamento/qdd/request_inicial.php",
                "dataType": "html",
                "data": {
                    "acao": "salvarRegistros",
                    "ano": $("#ano").val(),
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
                        $('.modal-alert').on('hidden.bs.modal', function (e) {
                            location.reload();
                        });
                        return false;
                        //listaDotacaoInicial();                        
                        //$this.prop("disabled", false);
                        //return false;
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
                        
            var id = $this.val();
            
            var item = $this.closest('tr').find('td:eq(0)').text()+" - "+$this.closest('tr').find('td:eq(1)').text()+" - "+$this.closest('tr').find('td:eq(2)').text();
            
            var Dados = {
                id : id                                   
            }        
            if(Dados.id == 0 ){                
                func.modalAlert(func.msgPreencherCampos);
                $this.prop("disabled", false);
                return false;                
            }            

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
                                                
                        $.ajax({
                            "url": "/model/orcamento/qdd/request_inicial.php",
                            "dataType": "html",
                            "data": {
                                "acao": "removerRegistro",
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
                                    listaDotacaoInicial();
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
