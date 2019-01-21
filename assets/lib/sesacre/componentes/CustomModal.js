Vue.component('custom-modal',{
    props: {
        nome: String,
        descricao: String
    },
    data: function(){
        return {
            estiloPadrao: {
                maxHeight: '85%',
                top: '20%',
                width: '80%',
                animationDuration:'0.6s',
                height: '80%'
            },
            estiloCorpo: {
                maxHeight: 'calc(100vh - 212px)',
                overflowY: 'auto'
            }
        }
    },
    template: `<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" v-bind:id="nome">
                    <div class="modal-dialog modal-lg" v-bind:style="estiloPadrao" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">{{ descricao }}</h4>
                            </div>
                            <div class="modal-body" v-bind:style="estiloCorpo">
                                <slot name="corpo"></slot>
                            </div>
                            <div class="modal-footer">
                                <slot name="rodape"></slot>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
               </div>`
});

