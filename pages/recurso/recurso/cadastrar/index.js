Vue.component('campo-texto', {
    props: {
        nome: String,
        descricao: String,
        requerido: {
            default: false,
            type: Boolean
        },
        valor: String
    },
    methods: {
        atualiza: function (valor) {
            this.$emit('input', valor)
        }
    },
    template: `<div class="form-group">
                    <label class="col-sm-2 control-label text-left">{{ descricao }}: <span v-if="requerido" class="text-danger">*</span> </label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <p class="fa fa-file-text-o inputPFa"></p>
                            </span>
                            <input type="text" class="form-control" v-bind:class="nome" v-bind:value="valor" v-on:input="atualiza($event.target.value)" >
                        </div>                                                    
                    </div>
                </div>`
})

Vue.component('campo-texto-grande', {
    props: {
        nome: String,
        descricao: String,
        valor: String,
        requerido: {
            default: false,
            type: Boolean
        },
    },
    methods: {
        atualiza: function (valor) {
            this.$emit('input', valor)
        }
    },
    template: `<div class="form-group">
                    <label class="col-sm-2 control-label text-left">{{descricao}}: <span v-if="requerido" class="text-danger">*</span> </label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <p class="fa fa-file-text-o inputPFa"></p>
                            </span>
                            <textarea class="form-control" rows="4" cols="50" v-bind:class="nome"  v-on:input="atualiza($event.target.value)" >{{ valor }}</textarea>                                                        
                        </div>                                                  
                    </div>
                </div>`
})

Vue.component('campo-select', {
    props: {
        nome: String,
        descricao: String,
        opcoes: Array,
        valor: String,
        requerido: {
            default: false,
            type: Boolean
        }
    },
    mounted: function () {
        var vm = this
        $('.' + this.nome).select2().on('change', function () {
            vm.$emit('input', this.value) // 'this.value' aqui se refere ao elemento capturado pelo Jquery
        })
    },
    template: `<div class="form-group">
                    <label class="col-sm-2 control-label text-left">
                        {{ descricao }}: <span v-if="requerido" class="text-danger">*</span></label>
                    <div class="col-sm-6">
                        <div class="input-group">
                                <span class="input-group-addon">
                                    <p class="fa fa-list inputPFa"></p>
                                </span>
                            <select class="form-control" v-bind:class="nome" >
                                <option value="0">Selecione o {{descricao}}</option>
                                <option v-for="opcao in opcoes" :key="opcao.id" v-bind:value="opcao.id">{{ opcao.nome }}</option>
                            </select>                                                                
                        </div>                                                   
                    </div>
                </div>`
});

func = new Funcoes();

var app = new Vue({
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

            //Função do Jquery que converte JSON em QueryString
            var dados = $.param({
                acao: 'cadastrarRecurso',
                dados: this.novoRecurso
            });  
            
            axios({
              url: 'request.php',
              method: 'POST',
              headers: {
                  'X-Requested-With': 'XMLHttpRequest',
                  'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
              },
              data: dados 
            }).then(function(response){            
                console.log(response.data);
            });
        },
        listaSistemasOptions: function () {
            var vm = this;
            axios({
                url: 'request.php',
                method: 'GET',
                params: {
                  acao: 'listaSistemas'
                }
            }).then(function(response) {     
                vm.sistemasOptions = response.data;        
            });
            
        }

    }
})



