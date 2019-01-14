Vue.component('custom-select',{
    props: {
        nome: String,
        descricao: String,
        opcoes: Array,
        value: String,
        requerido: {
            default: false,
            type: Boolean
        }
    },
    
    mounted: function () {
        var vm = this;
        $('.' + this.nome)
                .select2({width: '100%', data: this.opcoes, placeholder: 'Selecione o(a) ' + this.descricao})
                .trigger('change')
                .on('change', function(){
                    vm.$emit('input',this.value);
                    vm.$emit('change');
                });
    },
    watch: {
        value: function (valor){
            $('.' + this.nome).val(valor).trigger('change');
        },
        opcoes: function (opcoes){
            $('.' + this.nome).empty();
            $('.' + this.nome).select2({width: '100%', data: opcoes, placeholder: 'Selecione o(a) ' + this.descricao}).trigger('change');
        }
    },
    template: `<div class="form-group">
                    <label v-bind:for="nome" class="col-sm-2 control-label text-left">
                        {{ descricao }}: <span v-if="requerido" class="text-danger">*</span></label>
                    <div class="col-sm-6">
                        <div class="input-group">
                                <span class="input-group-addon">
                                    <p class="fa fa-list inputPFa"></p>
                                </span>
                            <select class="form-control" v-bind:class="nome" v-model="value">

                            </select>                                                                
                        </div>
                    </div>
                    <slot>
                    </slot>
                </div>`
});
