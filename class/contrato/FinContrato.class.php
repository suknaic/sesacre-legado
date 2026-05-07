<?php

namespace classe\contrato;

class FinContrato
{
    private $id_contrato =  null;
    private $nr_contrato = null;
    private $id_processo =  null;
    private $id_pessoa = null;
    private $ds_objeto = null;
    private $fl_servico_continuado = null;
    private $dt_ini_vigencia_contrato = null;
    private $dt_fim_vigencia_contrato = null;
    private $dt_assinatura = null;
    private $ds_obs_contrato = null;
    private $st_ativo = null;
    private $id_modalidade = null;
    private $ds_are_abrangencia = null;
    private $ds_unidade_contemplada = null;
    private $id_orgao_gerenciador = null;
    private $id_tipo_gasto =  null;
    private $vl_contrato = null;
    private $tp_contrato = null;
    private $fl_bloqueado = null;
    private $fl_carona = null;
    private $id_contrato_alt = null;
    private $sql_contrato= null;
    private $id_contrato_aditivo_pai = null;

    public function getIdContrato()
    {
        return $this->id_contrato;
    }

    public function setIdContrato($id_contrato)
    {
        $this->id_contrato = $id_contrato;
        return $this;
    }

    public function getNrContrato()
    {
        return $this->nr_contrato;
    }

    public function setNrContrato($nr_contrato)
    {
        $this->nr_contrato = $nr_contrato;
        return $this;
    }

    public function getIdProcesso()
    {
        return $this->id_processo;
    }

    public function setIdProcesso($id_processo)
    {
        $this->id_processo = $id_processo;
        return $this;
    }

    public function getIdPessoa()
    {
        return $this->id_pessoa;
    }

    public function setIdPessoa($id_pessoa)
    {
        $this->id_pessoa = $id_pessoa;
        return $this;
    }

    public function getDsObjeto()
    {
        return $this->ds_objeto;
    }

    public function setDsObjeto($ds_objeto)
    {
        $this->ds_objeto = $ds_objeto;
        return $this;
    }

    public function getFlServicoContinuado()
    {
        return $this->fl_servico_continuado;
    }

    public function setFlServicoContinuado($fl_servico_continuado)
    {
        $this->fl_servico_continuado = $fl_servico_continuado;
        return $this;
    }

    public function getDtIniVigenciaContrato()
    {
        return $this->dt_ini_vigencia_contrato;
    }

    public function setDtIniVigenciaContrato($dt_ini_vigencia_contrato)
    {
        $this->dt_ini_vigencia_contrato = $dt_ini_vigencia_contrato;
        return $this;
    }

    public function getDtFimVigenciaContrato()
    {
        return $this->dt_fim_vigencia_contrato;
    }

    public function setDtFimVigenciaContrato($dt_fim_vigencia_contrato)
    {
        $this->dt_fim_vigencia_contrato = $dt_fim_vigencia_contrato;
        return $this;
    }

    public function getDtAssinatura()
    {
        return $this->dt_assinatura;
    }

    public function setDtAssinatura($dt_assinatura)
    {
        $this->dt_assinatura = $dt_assinatura;
        return $this;
    }

    public function getDsObsContrato()
    {
        return $this->ds_obs_contrato;
    }

    public function setDsObsContrato($ds_obs_contrato)
    {
        $this->ds_obs_contrato = $ds_obs_contrato;
        return $this;
    }

    public function getStAtivo()
    {
        return $this->st_ativo;
    }

    public function setStAtivo($st_ativo)
    {
        $this->st_ativo = $st_ativo;
        return $this;
    }

    public function getIdModalidade()
    {
        return $this->id_modalidade;
    }

    public function setIdModalidade($id_modalidade)
    {
        $this->id_modalidade = $id_modalidade;
        return $this;
    }

    public function getDsAreAbrangencia()
    {
        return $this->ds_are_abrangencia;
    }

    public function setDsAreAbrangencia($ds_are_abrangencia)
    {
        $this->ds_are_abrangencia = $ds_are_abrangencia;
        return $this;
    }

    public function getDsUnidadeContemplada()
    {
        return $this->ds_unidade_contemplada;
    }

    public function setDsUnidadeContemplada($ds_unidade_contemplada)
    {
        $this->ds_unidade_contemplada = $ds_unidade_contemplada;
        return $this;
    }

    public function getIdOrgaoGerenciador()
    {
        return $this->id_orgao_gerenciador;
    }

    public function setIdOrgaoGerenciador($id_orgao_gerenciador)
    {
        $this->id_orgao_gerenciador = $id_orgao_gerenciador;
        return $this;
    }

    public function getIdTipoGasto()
    {
        return $this->id_tipo_gasto;
    }

    public function setIdTipoGasto($id_tipo_gasto)
    {
        $this->id_tipo_gasto = $id_tipo_gasto;
        return $this;
    }

    public function getVlContrato()
    {
        return $this->vl_contrato;
    }

    public function setVlContrato($vl_contrato)
    {
        $this->vl_contrato = $vl_contrato;
        return $this;
    }

    public function getTpContrato()
    {
        return $this->tp_contrato;
    }

    public function setTpContrato($tp_contrato)
    {
        $this->tp_contrato = $tp_contrato;
        return $this;
    }

    public function getFlBloqueado()
    {
        return $this->fl_bloqueado;
    }

    public function setFlBloqueado($fl_bloqueado)
    {
        $this->fl_bloqueado = $fl_bloqueado;
        return $this;
    }

    public function getFlCarona()
    {
        return $this->fl_carona;
    }

    public function setFlCarona($fl_carona)
    {
        $this->fl_carona = $fl_carona;
        return $this;
    }

    public function getIdContratoAlt()
    {
        return $this->id_contrato_alt;
    }

    public function setIdContratoAlt($id_contrato_alt)
    {
        $this->id_contrato_alt = $id_contrato_alt;
        return $this;
    }

    public function getSqlContrato()
    {
        return $this->sql_contrato;
    }

    public function setSqlContrato($sql_contrato)
    {
        $this->sql_contrato = $sql_contrato;
        return $this;
    }

    public function getIdContratoAditivoPai()
    {
        return $this->id_contrato_aditivo_pai;
    }

    public function setIdContratoAditivoPai($id_contrato_aditivo_pai)
    {
        $this->id_contrato_aditivo_pai = $id_contrato_aditivo_pai;
        return $this;
    }
}
