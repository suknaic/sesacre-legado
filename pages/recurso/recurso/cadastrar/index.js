func = new Funcoes();
req = new Requisicoes();

new Vue({
    el: '#cadRecurso',
    data: function () {
        return {
            sistemasOptions: [],
            novoRecurso: {idSistema: "1", nmRecurso: '', lkRecurso: '', dsRecurso: 'dsadasdsa'}
        }
    },
    mounted: function () {
        this.listaSistemasOptions();
    },
    methods: {
        cadastrar: function () {
            
            var dados = {
                acao: 'cadastrarRecurso',
                dados: this.novoRecurso
            }
           
            req.axiosPost('request.php',dados, function(response){

                if (response.tipoMsg === "Erro") {
                    if (response.tipoExibicao === "console") {
                        console.log('Console Mensagem');
                        func.modalAlert(func.msgErroPadrao);
                        return false;
                    } else if (response.tipoExibicao === "alert") {
                        func.modalAlert(response.msg);
                        return false;
                    }
                } else if (response.tipoMsg === "ok") {
                    func.modalAlert(response.msg, 'success');
                    func.fechaModalReload();
                    return false;
                } else {
                    console.log('Ultimo else');
                    func.modalAlert(func.msgErroPadrao);
                    return false;
                }
            });
            
           
        },
        listaSistemasOptions: function () {
            var vm = this;
            var dados = {
                acao: 'listaSistemas'
            }; 
            req.axiosGet('request.php',dados,function(response){
                vm.sistemasOptions = response;
            })
        }

    }
})



