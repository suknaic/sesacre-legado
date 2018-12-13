func = new Funcoes();


new Vue({
    el: '#cadRecurso',
    mixins: [request],
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
            ;
            console.log(vm);
        },
        listaSistemasOptions: function () {
//            var vm = this;
            axios({
                url: 'request.php',
                method: 'GET',
                params: {
                  acao: 'listaSistemas'
                }
            }).then((response) => {     
                this.sistemasOptions = response.data;        
            });
            
        }

    }
})



