Vue.component('input-select',{
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
                    <slot>
                    </slot>
                </div>`
});