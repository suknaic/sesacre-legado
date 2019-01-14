Vue.component('custom-radio',{
    props: {
        nome: String,
        descricao: String,
        value: String,
        opcoes: Array,
        requerido: {
            default: false,
            type: Boolean
        },
        estilo: String
    },
    /*
     * https://br.vuejs.org/v2/guide/components.html#Usando-v-model-em-Componentes
     * Para maiores informações com relação ao uso de componentes
     */
    template: `<div class="form-group">
                    <label v-bind:for="nome" class="col-sm-2 control-label text-left">{{descricao}}: <span v-if="requerido" class="text-danger">*</span> </label>
                    <div class="col-sm-6">
                        <div v-for="opcao in opcoes">
                            <input  type="radio" v-bind:name="nome" v-bind:id="nome" v-bind:value="opcao.id" v-model="value"> {{ opcao.nome }}                                        
                        </div>
                    </div>
                </div>`
})