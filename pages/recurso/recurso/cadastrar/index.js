

func = new Funcoes();
req = new Requisicoes();

new Vue({
    el: '#cadRecurso',
    data: function () {
        return {
            sistemasOptions: [],
            novoRecurso: {idSistema: 0, nmRecurso: '', lkRecurso: '', dsRecurso: ''}
        }
    },
    mounted: function () {
        this.listaSistemasOptions();
    },
    methods: {
        cadastrar: function () {
            var vm = this;
            //Função do Jquery que converte JSON em QueryString
            var dados = $.param({
                acao: 'cadastrarRecurso',
                dados: this.novoRecurso
            });  
           
            req.axiosPost('request.php',dados, function(response){
                console.log(response);
            });
            
           
        },
        listaSistemasOptions: function () {
            var vm = this;
            var param = {
                acao: 'listaSistemas'
            }; 
            req.axiosGet('request.php',param,function(response){
                vm.sistemasOptions = response;
            })
        }

    }
})



