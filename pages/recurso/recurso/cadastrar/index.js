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

Vue.component('campo-select',VueSelect.VueSelect);

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
                this.sistemasIds.push({label: info[idx].nm_sistema, key: info[idx].id_sistema})
            }             
        })
    }
})