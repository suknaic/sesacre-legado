<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="pesquisaPessoa" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Pesquisa de Pessoa</h4>
            </div>
            <div class="modal-body">
                <div class="input-group mar-btm">
                    <input type="hidden" id="tipo" disabled>
                    <input type="text" id="nm_pessoa" placeholder="Nome da Pessoa" class="form-control">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button" id="btn-pesquisa">
                            <i class="fa fa-search" aria-hidden="true"></i> Pesquisar
                        </button>
                    </span>
                </div>
                <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="tabelaPessoa" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>CNPJ/CPF</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

