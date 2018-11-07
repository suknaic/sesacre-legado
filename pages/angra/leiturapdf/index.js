$(function () {

    $('#jstree').jstree({

    });
    
    $('#jstree').on("changed.jstree", function (e, data) {
        
        $("#panel_pdf").find('.embed_pdf').remove();        
        let a = '<embed src="http://localhost/pages/angra/leiturapdf/ler_pdf.php?id='+data.node.data.jstree.info+' width="600" height="500" alt="pdf" class="embed_pdf" type="application/pdf"  >'; 
        $("#panel_pdf").html(a)

    });    
});