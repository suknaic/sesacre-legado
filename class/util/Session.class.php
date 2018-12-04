<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/config/constantes.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/strings.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/perfil.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/conexao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Metodos.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Log.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/sistema/DaoSesPerfilPessoa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/ErroExcept.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/rh/DaoSesPessoa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/RecursoUtil.class.php";

class Session extends RecursoUtil{

    private $logado = FALSE;
    private $idUser = null;
    private $perfis = Array();
    private $opcao = null;

    public function getIdUser() {
        return $this->idUser;
    }

    public function setIdUser($idUser) {
        $this->idUser = $idUser;
        return $this;
    }

    public function getLogado() {
        return $this->logado;
    }

    public function setLogado($logado) {
        $this->logado = $logado;
        return $this;
    }

    function getPerfis() {
        return $this->perfis;
    }

    function setPerfis($perfis) {
        $this->perfis = $perfis;
    }
    
    public function getOpcao() {
        return $this->opcao;
    }
    public function setOpcao($opcao) {
        $this->opcao = $opcao;
        return $this;
    }

    
    public function __construct($opcao = null) {
        $this->opcao = $opcao;
        switch ($opcao) {
            //Default, Situação normal do Sistema, verifica se está logado, caso não esteja irá mandar para tela de login
            case null:
                $this->sessionPadrao();
                break;
            //Toda e qualquer requisição ajax que for Feita.
            case 'ajax':
                $this->sessionAjax();
                break;
            //Quando for Tela de Login
            case 'login':
                $this->sessionLogin();
                break;
            //Qualquer Ajax sem necessidade de login
            //Utilizar Inicialmente no Momento de Logar no Sistema
            case 'ajaxSemAcesso':
                $this->sessionAjaxSemAcesso();
                break;
            default:
                $this->sessionPadrao();
                break;
        }
    }

    private function sessionPadrao() {
        if ($this->secSession() && SISTEMA_ONOFF == "ON" && $this->verificaDuplicidadeLogin()) {
            $this->logado = TRUE;
            $this->idUser = $_SESSION['idUser'];
            $this->carregaPerfis();
        } else {
            header("location:" . "/logout.php");
            exit;
        }
    }

    private function sessionAjax() {
        if ($this->secSession() && SISTEMA_ONOFF == "ON" && $this->verificaDuplicidadeLogin()) {
            $this->logado = TRUE;
            $this->idUser = $_SESSION['idUser'];
            $this->carregaPerfis();
        } else {
            echo "SessaoExpirada";
            exit;
        }
    }

    private function sessionLogin() {
        if ($this->secSession()) {
            header("location:" . "/pages/index.php");
            exit;
        }
    }

    private function sessionAjaxSemAcesso() {
        if (SISTEMA_ONOFF != "ON") {
            echo "SessaoExpirada";
            exit;
        }
    }

    /**
     * Verifica se o usuário já está logado.
     */
    private function secSession() {
        session_start();
        if (!isset($_SESSION['idUser'])) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * Verifica se está ocorrendo Duplicidade de Login no sistema.
     * Se o Usuário está logado em duas ou mais máquinas diferente
     * Caso esteja, irá derrubar o acesso do mais antigo
     * @return Boolean
     */
    private function verificaDuplicidadeLogin() {
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        $pessoa = new DaoSesPessoa();
        if ($pessoa->verificaUltimoLogin($_SESSION['idUser'], $_SESSION['data'], $pdo)) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Verifica se o usuário possui as devidas permissões.
     * @param int $perfil
     * @return Boolean
     */
    public function verificaPermissao($perfil) {
        if (in_array($perfil, $this->perfis)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Carrega Todos os Perfis do Usuário no Objeto ou na Sessão
     */
    public function carregaPerfis() {
        try {
            //Se a sessão dos perfis não tiver sido preenchida, deverá consultar os perfis
            if (!isset($_SESSION['perfis'])) {
                $this->carregaArrayPerfis();
                $_SESSION['perfis'] = $this->perfis;
            } else {
                //Faz com que os perfis sejam carregando mesmo que já exista na sessão
                //Um Refresh
                //$this->carregaArrayPerfis();
                //$_SESSION['perfis'] = $this->perfis;

                $this->perfis = $_SESSION['perfis'];
            }
        } catch (Exception $ex) {
            echo "<code>" . $ex->getMessage() . "</code>";
        }
    }

    /**
     * Coloca Todos os perfis do Usuario em um array do Objeto Session
     */
    public function carregaArrayPerfis() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoPerfil = new DaoSesPerfilPessoa();
            $daoPerfil->setIdPessoa($this->idUser);

            $result = $daoPerfil->retornaPerfisPorPessoa($pdo);

            if ($result) {
                foreach ($result as $value) {
                    $this->perfis[] = $value['id_perfil'];
                }
            }
        } catch (Exception $ex) {
            
        }
    }
    
    /**
     * Faz o negocio acontecer
     */
    public function recurso(PDO $pdo = null){
        try{          
            if(empty($pdo)){
                $conexao = new Conexao();
                $pdo = $conexao->connect(); 
            }            
            $this->setIdPessoa($this->idUser);            
            $resultado = $this->validaRecursoUsuario($pdo);
            if(!$resultado){
                echo "Resultado false";
                if($this->opcao == "ajax"){
                    echo "SessaoExpirada";
                    exit;
                }else{
                    header("location:" . "/pages/index.php?permi=1");
                    exit;
                }
            }                                                
            return true;                                    
        } catch (Exception $ex) {            
            return false;
        }                
    }

    /**
     * Acessa a Tudo
     * @return boolean
     */
    public function vPGeral() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_ZEUS)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    /**
     * Pode Fazer qualquer Ação dentro do Sistema
     * @return boolean
     */
    public function vPGeralAcao() {
        if (!$this->verificaPermissao(PERFIL_TI)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    /**
     * Verifica se o usuário tem permissão para o Sistema de Planejamento
     * @return boolean
     */
    public function vPPlanejamento() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_ZEUS) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO_ZEUS) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    /**
     * Verifica se o usuário tem permissão para o Sistema de Rh
     * @return boolean
     */
    public function vPRh() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_ZEUS) && !$this->verificaPermissao(PERFIL_RH_ZEUS) && !$this->verificaPermissao(PERFIL_RH)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    /**
     * Verifica se o usuário tem permissão para o Sistema de Planejamento
     * @return boolean
     */
    public function vPCompras() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_COMPRAS_USUARIO) && !$this->verificaPermissao(PERFIL_COMPRAS_TECNICO) && !$this->verificaPermissao(PERFIL_COMPRAS_ADMINISTRADOR)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    public function vPComprasAdminTi() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_COMPRAS_ADMINISTRADOR)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    public function vPComprasTecAdmin() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_COMPRAS_TECNICO) && !$this->verificaPermissao(PERFIL_COMPRAS_ADMINISTRADOR)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    /**
     * Verifica se o usuário tem permissão para o Sistema de Contratos
     * @return boolean
     */
    public function vPContratos() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_ZEUS) && !$this->verificaPermissao(PERFIL_CONTRATOS_USUARIO) && !$this->verificaPermissao(PERFIL_CONTRATOS_TECNICO) && !$this->verificaPermissao(PERFIL_CONTRATOS_ADMINISTRADOR)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    /**
     * Verifica se o usuário tem permissão para o Sistema de Contratos
     * @return boolean
     */
    public function vPContratosTecnico() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_ZEUS) && !$this->verificaPermissao(PERFIL_CONTRATOS_TECNICO) && !$this->verificaPermissao(PERFIL_CONTRATOS_ADMINISTRADOR)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    /**
     * Verifica se o usuário tem permissão para o Sistema de Contratos
     * @return boolean
     */
    public function vPContratosAdmin() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_ZEUS) && !$this->verificaPermissao(PERFIL_CONTRATOS_ADMINISTRADOR)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    /**
     * Verifica se o usuário tem permissão para o sistema de Planejamento
     * Caso o usuário seja, ZEUS, ele não poderá fazer nenhuma ação que modifique as informações.
     * Por isso somente esses Perfis poderão fazer as Ações
     * @return boolean
     */
    public function vPPlanejamentoAcao() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    /**
     * Verifica se o usuário tem permissão para utilizar o Sistema do Planejamento na parte
     * que compete os Usuários do Sistema, que fazem o PTA/PAS e etc
     * @return boolean
     */
    public function vPPlanejamentoUsuario() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_ZEUS) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO_ZEUS) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO_USUARIO)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    /**
     * Verifica se o usuário tem permissão para utilizar o Sistema do Planejamento na parte
     * que compete os Usuários do Sistema, que fazem o PTA/PAS e etc
     * Caso o usuário seja, ZEUS, ele não poderá fazer nenhuma ação que modifique as informações.
     * Por isso somente esses Perfis poderão fazer as Ações
     * @return boolean
     */
    public function vPPlanejamentoUsuarioAcao() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO_USUARIO)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    /**
     * Verifica se o Usuário possui a permissão que o planejamento dá para utilizar o sistema para fazer pas/pta
     * @return boolean
     */
    public function vPPlanejamentoUsuarioExiste() {
        if ($this->verificaPermissao(PERFIL_PLANEJAMENTO_USUARIO)) {
            RETURN TRUE;
        } else {
            RETURN FALSE;
        }
    }

    /**
     * Perfil da Central de Demanda Validar os Itens da PAS
     * @return boolean
     */
    public function vPPlanejamentoCentral() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_ZEUS) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO_CENTRAL_DEMANDA) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO_ZEUS)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    /**
     * Perfil da Central de Demanda Validar os Itens da PAS
     * @return boolean
     */
    public function vPPlanejamentoCentralAcao() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO_CENTRAL_DEMANDA)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    /**
     * Perfil dos Usuários que podem Visualizar a Pre-LOA para autorizar
     * @return boolean
     */
    public function vPPlanejamentoPreLoa() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_ZEUS) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO_ZEUS) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO_SEC_ADJ_PLA_GESTAO) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO_SEC_ADJ_ADM_FINAN) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO_SEC_ADJ_ATE_SAUDE) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO_SEC_GERAL) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO_CONSELHO)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    /**
     * Perfil dos Usuários que podem Visualizar a Pre-LOA para autorizar
     * @return boolean
     */
    public function vPPlanejamentoPreLoaAcao() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO_SEC_ADJ_PLA_GESTAO) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO_SEC_ADJ_ADM_FINAN) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO_SEC_ADJ_ATE_SAUDE) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO_SEC_GERAL) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO_CONSELHO)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    /**
     * Verifica se o usuário tem permissão para o Sistema de Chamados
     * @return boolean
     */
    public function vPChamado() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_ZEUS) && !$this->verificaPermissao(PERFIL_CHAMADO_ZEUS) && !$this->verificaPermissao(PERFIL_CHAMADO)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    /**
     * Verifica se o usuário tem permissão para o sistema de Chamados
     * Caso o usuário seja, ZEUS, ele não poderá fazer nenhuma ação que modifique as informações.
     * Por isso somente esses Perfis poderão fazer as Ações
     * @return boolean
     */
    public function vPChamadoAcao() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_CHAMADO)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    /**
     * Verifica se o usuário tem permissão para utilizar o Sistema do Planejamento na parte
     * que compete os Usuários do Sistema, que fazem o PTA/PAS e etc
     * @return boolean
     */
    public function vPChamadoUsuario() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_ZEUS) && !$this->verificaPermissao(PERFIL_CHAMADO) && !$this->verificaPermissao(PERFIL_CHAMADO_ZEUS) && !$this->verificaPermissao(PERFIL_CHAMADO_USUARIO)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    /**
     * Verifica se o usuário tem permissão para utilizar o Sistema do Planejamento na parte
     * que compete os Usuários do Sistema, que fazem o PTA/PAS e etc
     * Caso o usuário seja, ZEUS, ele não poderá fazer nenhuma ação que modifique as informações.
     * Por isso somente esses Perfis poderão fazer as Ações
     * @return boolean
     */
    public function vPChamadoUsuarioAcao() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_CHAMADO) && !$this->verificaPermissao(PERFIL_CHAMADO_USUARIO)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    /**
     * Verifica se o Usuário possui a permissão que o planejamento dá para utilizar o sistema para fazer pas/pta
     * @return boolean
     */
    public function vPChamadoUsuarioExiste() {
        if ($this->verificaPermissao(PERFIL_CHAMADO_USUARIO)) {
            RETURN TRUE;
        } else {
            RETURN FALSE;
        }
    }

    /**
     * Verifica se o usuário tem permissão para utilizar o Modulo do QDD	 
     * @return boolean
     */
    public function vPQdd() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_ZEUS) && !$this->verificaPermissao(PERFIL_FINANCEIRO) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO_ZEUS) && !$this->verificaPermissao(PERFIL_FINANCEIRO_ZEUS)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    /**
     * Verifica se o usuário tem permissão para utilizar o Modulo do QDD	 
     * Caso o usuário seja, ZEUS, ele não poderá fazer nenhuma ação que modifique as informações.
     * Por isso somente esses Perfis poderão fazer as Ações
     * @return boolean
     */
    public function vPQddAcao() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_FINANCEIRO) && !$this->verificaPermissao(PERFIL_PLANEJAMENTO)) {
            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    //VERIFICA SE POSSUI ACESSO AO MÓDULO FINANCEIRO
    public function vPFinanceiro() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_FINANCEIRO) && !$this->verificaPermissao(PERFIL_FINANCEIRO_ZEUS)) {

            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    public function vPFinanceiroAcao() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_FINANCEIRO)) {

            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    public function vPFinanceiroCentral() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_FINANCEIRO) && !$this->verificaPermissao(PERFIL_FINANCEIRO_ZEUS) && !$this->verificaPermissao(PERFIL_FINANCEIRO_CENTRAL)) {

            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

    public function vPFinanceiroCentralAcao() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_FINANCEIRO) && !$this->verificaPermissao(PERFIL_FINANCEIRO_CENTRAL)) {

            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }
    
    //VERIFICA SE POSSUI ACESSO AO MÓDULO DIÁRIAS
    public function vPDiariasSolicitacao() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_DIARIA_SOLICITACAO) && !$this->verificaPermissao(PERFIL_DIARIA_ZEUS)) {

            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }
    //VERIFICA SE POSSUI ACESSO AO MÓDULO DIÁRIAS
    public function vPDiariasAutorizacao() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_DIARIA_AUTORIZACAO) && !$this->verificaPermissao(PERFIL_DIARIA_ZEUS)) {

            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }
    
    //VERIFICA SE POSSUI ACESSO AO MÓDULO DIÁRIAS
    public function vPDiariasPermissoes() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_DIARIA_PERMISSAO) && !$this->verificaPermissao(PERFIL_DIARIA_ZEUS)) {

            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }
    
    //VERIFICA SE POSSUI ACESSO AO MÓDULO CONTÁBIL
    public function vPContabilAdministracao() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_CONTABIL_ADMINISTRACAO) && !$this->verificaPermissao(PERFIL_CONTABIL_ZEUS)) {

            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }
    
    //VERIFICA SE POSSUI ACESSO AO MÓDULO CONTÁBIL - LIQUIDAÇÃO
    public function vPContabilLiquidacao() {
        if (!$this->verificaPermissao(PERFIL_TI) && !$this->verificaPermissao(PERFIL_CONTABIL_LIQUIDACAO) && !$this->verificaPermissao(PERFIL_CONTABIL_ZEUS)) {

            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }
    
     //VERIFICA SE POSSUI ACESSO AO MÓDULO CONTÁBIL - ANULAÇÃO DE EMEPENHO
    public function vPContabilEmpenhoAnulacao() {
        if (!$this->verificaPermissao(PERFIL_TI) 
                && !$this->verificaPermissao(PERFIL_CONTABIL_EMPENHO_ANULACAO) 
                && !$this->verificaPermissao(PERFIL_CONTABIL_ZEUS)) {

            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }
    
    //VERIFICA SE POSSUI ACESSO AO MÓDULO CONTÁBIL - EMPENHO
    public function vPContabilEmpenho() {
        if (!$this->verificaPermissao(PERFIL_TI)                 
                && !$this->verificaPermissao(PERFIL_CONTABIL_EMPENHO)
                && !$this->verificaPermissao(PERFIL_CONTABIL_ZEUS)) {

            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }
    
    //VERIFICA SE POSSUI ACESSO AO MÓDULO CONTÁBIL - EMPENHO
    public function vPContabilPagamento() {
        if (!$this->verificaPermissao(PERFIL_TI)                 
                && !$this->verificaPermissao(PERFIL_CONTABIL_PAGAMENTO)
                && !$this->verificaPermissao(PERFIL_CONTABIL_ZEUS)) {

            RETURN FALSE;
        } else {
            RETURN TRUE;
        }
        RETURN FALSE;
    }

}

?>
