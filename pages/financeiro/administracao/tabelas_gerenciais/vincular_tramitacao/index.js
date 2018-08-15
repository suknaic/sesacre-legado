
$(document).ready(function () {   
    func = new Funcoes();
    
    $('#id_doc_tipo_remetente option[value="0"]').text('Selecione o Tipo de Remetente');
    $('#id_doc_tipo_destinatario option[value="0"]').text('Selecione o Tipo de Destinatário');
    
    $('body').find('select').select2({
        width: '100%'
    });
    
    
    $('body').on('change','#tp_doc_tramitacao',function(e){
        var tipo_tramitacao = $("#tp_doc_tramitacao option:selected").val();
        if (tipo_tramitacao == '1') { //Encaminhar
            $('#remetente_conteudo').prependTo('#primeiro');
            $('#destinatario_conteudo').prependTo('#segundo');
        } else if(tipo_tramitacao == '2') { //Receber
            $('#destinatario_conteudo').prependTo('#primeiro');
            $('#remetente_conteudo').prependTo('#segundo');
        }
    });
    
    
});

