Vue.component('input-texto', {
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
                    <slot>
                    </slot>
                </div>`
})