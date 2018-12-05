Vue.component('campo-texto',{
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
        atualiza: function (valor){
            this.$emit('input',valor)
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

Vue.component('campo-texto-grande',{
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
        atualiza: function (valor){
            this.$emit('input',valor)
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

Vue.component('campo-select',{
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
    mounted: function() {
        var vm = this
        $('.' + this.nome).select2().on('change', function(){
            vm.$emit('input',this.value)
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
                                <option value="0">Selecione p {{descricao}}</option>
                                <option v-for="opcao in opcoes" :key="opcao.id" v-bind:value="opcao.id">{{ opcao.nome }}</option>
                            </select>                                                                
                        </div>                                                   
                    </div>
                </div>`
});

func = new Funcoes();

var app = new Vue({ 
    el: '#cadRecurso' ,
    data: function (){
        return {
            idSistema: 0,
            nmRecurso: '',
            lkRecurso: '',
            dsRecurso: '',   
            sistemas: [],
            erros: []
        }
    },
    mounted: function(){
        axios({ 
            url: 'request.php',
            method: 'get',
            params: {
                acao: 'listaSistemas'
            }
        }).then(response => {
            var info = response.data;
            for(let indice in info){       
                this.sistemas.push({id: info[indice].id_sistema, nome: info[indice].nm_sistema});
            }             
        }).catch(erro => {
            console.log(erro);
        })

    },
    methods: {
        cadastrar: function (){
            
            if(!this.idSistema || !this.nmRecurso || !this.lkRecurso){
                func.modalAlert("Por favor preencha as informações obrigatórias.");
                return false;
            }
            
            var dados = {
                idSistema: this.idSistema,
                nmRecurso: this.nmRecurso,
                lkRecurso: this.lkRecurso,
                dsRecurso: this.dsRecurso
            }

            axios({
                url: 'request.php',
                method: 'post',
                params: {
                    acao: 'cadastrarRecurso',
                    dados: dados
                }
            }).then(response => {
                console.log(response);
                if (response.data.tipoMsg == 'ok') {
                    func.modalAlert(response.data.msg,'success');
                } else {
                    func.modalAlert(response.data.msg);
                }
                
            }).catch(erro => {
                console.log(erro);
                func.modalAlert(func.msgErroPadrao);
            }) 
        
        }
    }
})
        


