<?php

class ConPagamentoAnotacoesTb {

    private $id_pagamento_anotacao = null;
    private $id_pessoa = null;
    private $id_pagamento = null;
    private $dh_pagamento_anotacao = null;
    private $ds_pagamento_anotacao = null;

    public function getIdPagamentoAnotacao() {
        return $this->id_pagamento_anotacao;
    }

    public function setIdPagamentoAnotacao($id_pagamento_anotacao) {
        $this->id_pagamento_anotacao = $id_pagamento_anotacao;

        return $this;
    }

    public function getIdPessoa() {
        return $this->id_pessoa;
    }

    public function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;

        return $this;
    }

    public function getIdPagamento() {
        return $this->id_pagamento;
    }

    public function setIdPagamento($id_pagamento) {
        $this->id_pagamento = $id_pagamento;

        return $this;
    }

    public function getDhPagamentoAnotacao() {
        return $this->dh_pagamento_anotacao;
    }

    public function setDhPagamentoAnotacao($dh_pagamento_anotacao) {
        $this->dh_pagamento_anotacao = $dh_pagamento_anotacao;

        return $this;
    }

    public function getDsPagamentoAnotacao() {
        return $this->ds_pagamento_anotacao;
    }

    public function setDsPagamentoAnotacao($ds_pagamento_anotacao) {
        $this->ds_pagamento_anotacao = $ds_pagamento_anotacao;

        return $this;
    }

}
