func = new Funcoes();
req = new Requisicoes();

new Vue({
    el: '#cadGrupoRecursos',
    data: function () {
        return {
            grupoOptions: [],
            grupo: {idGrupoRecurso: 0, nmGrupoRecurso: '', recursos: []},
            inserir: false
        }
    },
    mounted: function () {
        this.listaGrupoOptions();
    },
    methods: {
        cadastrar: function () {
            
            var dados = {
                acao: 'cadastrarGrupo',
                dados: this.grupo
            }
           
            req.axiosPost('request.php',dados, function(response){
                console.log(response);
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
        listaGrupoOptions: function () {
            var vm = this;
            var dados = {
                acao: 'listaGrupos'
            }; 
            req.axiosGet('request.php',dados,function(response){
                vm.grupoOptions = response;
            })
        },
        novoGrupo: function(parametro){
            this.inserir = parametro;

        },
        setaGrupo: function(dados){
            console.log(dados);
        }

    }
})