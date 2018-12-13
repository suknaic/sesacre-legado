Vue.component('input-texto-grande',{
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