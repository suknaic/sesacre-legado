$(document).ready(function () {
    //instacinado fucoes js
    func = new Funcoes();

    $('body').on('click', '.btn-editar', function (e) {
        e.stopPropagation();
        if (e.isDefaultPrevented()) {
        } else {
            var id = $("#id_contrato").val();
            var tpContrato = $("#tp_contrato").val();
            if (tpContrato == 1) {
                window.location.href = "/pages/compras/gestao_contratos/edit_ata.php?token=" + id;
            }else if (tpContrato == 2){
                window.location.href = "/pages/compras/gestao_contratos/edit_contrato.php?token=" + id;
            }
        }
    });
});
      