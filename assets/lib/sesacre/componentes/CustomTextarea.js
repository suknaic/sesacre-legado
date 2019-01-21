Vue.component('custom-textarea',{
    props: {
        nome: String,
        descricao: String,
        value: String,
        requerido: {
            default: false,
            type: Boolean
        },
        icone: String
    },
    /*
     * https://br.vuejs.org/v2/guide/components.html#Usando-v-model-em-Componentes
     * Para maiores informações com relação ao uso de componentes
     */
    template: `<div class="form-group">
                    <label v-bind:for="nome" class="col-sm-2 control-label text-left">{{descricao}}: <span v-if="requerido" class="text-danger">*</span> </label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <p v-bind:class="icone"></p>
                            </span>
                            <textarea class="form-control" v-bind:id="nome" rows="4" cols="50" v-bind:class="nome" v-bind:value="value" v-on:input="$emit('input',$event.target.value)" >{{ value }}</textarea>                                                        
                        </div>                                                  
                    </div>
                </div>`
})