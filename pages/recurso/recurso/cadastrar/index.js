Vue.component('campo-texto',{
    props: {
        nome: String,
        descricao: String,
        sugestao: String,
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
                            <input type="text" class="form-control" v-bind:class="nome" v-bind:value="valor" v-on:input="atualiza($event.target.value)">
                        </div>                                                    
                    </div>
                </div>`
})

Vue.component('campo-numerico',{
    props: {
        nome: String,
        descricao: String,
        sugestao: String,
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
                    <label class="col-sm-2 control-label text-left">{{ descricao }}: <span v-if="requerido" class="text-danger">*</span></label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <p class="fa fa-sort-numeric-asc inputPFa"></p>
                            </span>
                            <input class="form-control" type="text" v-bind:class="nome" v-bind:value="valor" v-on:input="atualiza($event.target.value)">
                        </div>                                                                                                 
                    </div>
                </div>`
})

Vue.component('campo-select',{
    props: {
        nome: String,
        descricao: String,
        requerido: {
            default: false,
            type: Boolean
        },
        valor: Number,
        opcoes: {
            default: function(){ () => [] },
            type: Array
        },
        ajuda: {
            default: '',
            type: String
        }
    },
    methods: {
        atualiza: function (e){
            console.log(e.target.value)
            this.$emit('input',e.target.value)
        }
    },
    template: `<div class="form-group">
                    <label class="col-sm-2 control-label text-left">{{ descricao }}: 
                        <span v-if="requerido" class="text-danger">*</span>
                        <span v-if="ajuda != ''" class="fa fa-question-circle add-tooltip" 
                            data-original-title="ajuda" 
                            data-toggle="tooltip" data-container="body" data-placement="top" role="button">                                                              
                        </span>                                                    
                    </label>
                    <div class="col-sm-6">
                        <div class="input-group">
                                <span class="input-group-addon">
                                    <p class="fa fa-list inputPFa"></p>
                                </span>
                            <select class="form-control" v-bind:class="nome" v-on:change="atualiza">
                                <option v-for="opcao in opcoes" v-bind:value="opcao.valor">{{opcao.texto}}</option>
                            </select>                                                                
                        </div>                                                   
                    </div>
                </div>`
})

Vue.component('campo-texto-grande',{
    props: {
        nome: String,
        descricao: String,
        valor: String
    },
    methods: {
        atualiza: function (valor){
            this.$emit('input',valor)
        }
    },
    template: `<div class="form-group">
                    <label class="col-sm-2 control-label text-left">{{descricao}}: </label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <p class="fa fa-file-text-o inputPFa"></p>
                            </span>
                            <textarea class="form-control" rows="4" cols="50" v-bind:class="nome"  v-on:input="atualiza($event.target.value)" ></textarea>                                                        
                        </div>                                                  
                    </div>
                </div>`
})

var app = new Vue({ 
    el: '#cadRecurso' ,
    data: function (){
        return {
            idSistema: 0,
            nmRecurso: '',
            lkRecurso: '',
            dsRecurso: '',
            sistemasIds: [] 
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
            var info = response.data
            for( idx in info){        
                this.sistemasIds.push({texto: info[idx].nm_sistema, valor: info[idx].id_sistema})
            }             
        })
    }
})