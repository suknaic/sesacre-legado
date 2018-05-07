$(document).ready(function () {

    func = new Funcoes();
    $("body").on("focus", ".quantidade", function () {
            $(this).priceFormat({
                prefix: '',
                centsSeparator: ',',
                thousandsSeparator: '.',
                centsLimit: 2
            });
        });                            
       
});
