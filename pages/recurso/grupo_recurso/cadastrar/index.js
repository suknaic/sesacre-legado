func = new Funcoes();
req = new Requisicoes();

new Vue({
    el: '#cadGrupoRecursos',
    data: function () {
        return {
            gruposOptions: [],
            novoGrupo: {idGrupo: 0, recursos: []}
        }
    },
    mounted: function () {
        this.listaGruposOptions();
    },
    methods: {
        cadastrar: function () {
            var vm = this;
            
            var dados = {
                acao: 'cadastrarGrupo',
                dados: this.novoGrupo
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
        listaGruposOptions: function () {
            var vm = this;
            var dados = {
                acao: 'listaGrupos'
            }; 
            req.axiosGet('request.php',dados,function(response){
                vm.gruposOptions = response;
            })
        }

    }
})