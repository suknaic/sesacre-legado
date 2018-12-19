Vue.component('custom-textarea',{
    props: {
        nome: String,
        descricao: String,
        valor: String,
        requerido: {
            default: false,
            type: Boolean
        }
    },
    /*
     * https://br.vuejs.org/v2/guide/components.html#Usando-v-model-em-Componentes
     * Para maiores informações com relação ao uso de componentes
     */
    template: `<div class="form-group">
                    <label class="col-sm-2 control-label text-left">{{descricao}}: <span v-if="requerido" class="text-danger">*</span> </label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <p class="fa fa-file-text-o inputPFa"></p>
                            </span>
                            <textarea class="form-control" rows="4" cols="50" v-bind:class="nome" v-bind:valor="valor" v-on:input="$emit('input',$event.target.value)" >{{ valor }}</textarea>                                                        
                        </div>                                                  
                    </div>
                </div>`
})