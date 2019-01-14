Vue.component('custom-text', {
    props: {
        nome: String,
        descricao: String,
        value: String,
        requerido: {
            default: false,
            type: Boolean
        },
        estilo: String
    },
    template: `<div class="form-group">
                    <label v-bind:for="nome" class="col-sm-2 control-label text-left">{{ descricao }}: <span v-if="requerido" class="text-danger">*</span> </label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <p v-bind:class="estilo"></p>
                            </span>
                            <input class="form-control" v-bind:id="nome" v-bind:class="nome" v-bind:value="value" v-on:input="$emit('input', $event.target.value)" >
                        </div>                                                    
                    </div>
                    <slot>
                    </slot>
                </div>`
})