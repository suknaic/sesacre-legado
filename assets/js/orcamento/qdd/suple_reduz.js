$(document).ready(function () {

    func = new Funcoes();     
    
    function lista() {
        $.ajax({
            "url": "/model/orcamento/qdd/request_suple_reduz.php",
            "dataType": 'html',
            "data": {
                acao: "listaSupleReduz",
                ano: $("#ano").val()
            },
            "success": function (response) {             
                func.carregaTabelaPadrao('tabela', response, [4], true);

            }
        });
    }
    func.carregaTabelaPadrao('tabela', null, [4]);
    lista();
    
    
    $("body").on("focus", ".valor", function () {
        $(this).priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.',
            centsLimit: 2
        });
    });
    
    $('body').on('click', '.tipo', function (e) {                    
        if($(this).val() == 's'){
            $("#spanPrimeiro").text("Suplementado");
            $("#spanSegundo").text("Reduzidos");

        }else{
            $("#spanPrimeiro").text("Reduzido");
            $("#spanSegundo").text("Suplementados");

        }                                                                  
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
    
    $('body').on('keypress', '#valor', function (e) {
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
    
    
    function salvarSupleReduz(i, d){
        
        $.ajax({
            "url": "/model/orcamento/qdd/request_suple_reduz.php",
            "dataType": "html",
            "data": {
                "acao": "salvar",
                "ano": $("#ano").val(),
                "inicial": i,
                "dados": d
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
                    $(".btn-salvar").prop("disabled", false);                    
                    return false;
                }

                if (response.tipoMsg === "Erro") {
                    if (response.tipoExibicao === "console") {
                        console.log('Console Mensagem');
                        console.log(response);                            
                        func.modalAlert(func.msgErroPadrao);
                        $(".btn-salvar").prop("disabled", false);
                        return false;
                    } else if (response.tipoExibicao === "alert") {                            
                        func.modalAlert(response.msg);
                        $(".btn-salvar").prop("disabled", false);
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
                    $(".btn-salvar").prop("disabled", false);
                    return false;
                }
            },
            "error": function (response) {
                console.log(response);                    
                func.modalAlert(func.msgErroPadrao);
                $(".btn-salvar").prop("disabled", false);
                return false;
            }
        });     
        
        
    }
      
    $('body').on('click', '.btn-salvar', function (e) {
        
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            e.preventDefault();                        
            var $this = $(this);
            $this.prop("disabled", true);
            
            var inicial = {
                programa: $("#programaTipo option:selected").val(),
                fonte: $("#fonteTipo option:selected").val(),
                despesa: $("#despesaTipo option:selected").val(),
                valor: $("#valorTipo").val(),
                obs: $("#obs").val(),
                tipo: $("input:radio.tipo:checked").val()
            }
            
            if(inicial.programa == 0 || inicial.despesa == 0){
                func.modalAlert('Precisa Seleciona um Programa ou Despesa.');
                $this.prop("disabled", false);
                return false;
            }
            
            if(inicial.obs == "" || inicial.obs.length < 3){
                func.modalAlert('Informe uma Observação.');
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
            
            msg = 'Você tem Certeza que deseja continuar com essa Ação?';

            var tipoTexto = $("input:radio.tipo:checked").val() == "s" ? "Reduzido" : "Suplementado";
            if(Dados.length < 1){
                msg += ' <span class="text-danger">NÃO existe nenhum Registro a ser '+tipoTexto+'. </span>';
            }
            
            bootbox.confirm({
                title: 'Caixa de Confirmação',
                message: msg,
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
                        salvarSupleReduz(inicial, Dados);
                    }else{
                        $(".btn-salvar").prop("disabled", false);  
                    }
                }
            });
            
            $(".btn-salvar").prop("disabled", false);          
        }
    });
                                 
});
