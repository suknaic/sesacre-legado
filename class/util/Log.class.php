<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/sistema/DaoSesLog.class.php";

class Log {

    public $ds_tabela = NULL;
    public $id_tabela_pk = NULL;
    public $tp_log = NULL;
    public $id_pessoa = NULL;
    public $ds_ip = NULL;
    public $ds_campos_atual = NULL;
    public $ds_campos_antigos = NULL;

    public static function getIp() {

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) { //se possível, obtém o endereço ip da máquina do cliente
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { //verifica se o ip está passando pelo proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    /**
     * Cria o Log para o INSERT
     * @param type $ds_tabela nome da tabela que foi afetada
     * @param type $id_tabela_pk chave primária da tabela afetada
     * @param type $id_func id do funcionário que provocou o Evento
     * @param type $ds_ip IP da máquina
     * @param type $pdo instancia do pdo
     * @return Boolean retorno true ou false
     */
    public static function SalvaLogI($ds_tabela, $id_tabela_pk, $pdo) {

        $ds_tabela = $ds_tabela;
        $id_tabela_pk = $id_tabela_pk;
        $tp_log = "I";
        $id_pessoa = $_SESSION['idUser'];
        $ds_ip = self::getIp();
        $pref = explode("_", $ds_tabela);
        $pref = $pref[0];
        $where = preg_replace('/'.$pref.'/', 'id', $ds_tabela, 1);
        $row = $pdo->query("SELECT * FROM " . $ds_tabela . "  WHERE " . $where . " = $id_tabela_pk");
        $reg = $row->fetch(PDO::FETCH_ASSOC);

        $ds_campos_atual = $reg;

        $ds_campos_atual = json_encode($ds_campos_atual, JSON_UNESCAPED_UNICODE);
        $ds_campos_antigos = NULL;
        try {

            $log = $pdo->prepare("INSERT INTO ses_log("
                    . "ds_tabela, "
                    . "id_tabela_pk, "
                    . "tp_log, "
                    . "id_pessoa, "
                    . "ds_ip, "
                    . "ds_campos_atuais, "
                    . "ds_campos_antigos) VALUES("
                    . ":ds_tabela, "
                    . ":id_tabela_pk, "
                    . ":tp_log, "
                    . ":id_pessoa, "
                    . ":ds_ip, "
                    . ":ds_campos_atual, "
                    . ":ds_campos_antigos)");

            $log->bindParam(":ds_tabela", $ds_tabela);
            $log->bindParam(":id_tabela_pk", $id_tabela_pk);
            $log->bindParam(":tp_log", $tp_log);
            $log->bindParam(":id_pessoa", $id_pessoa);
            $log->bindParam(":ds_ip", $ds_ip);
            $log->bindParam(":ds_campos_atual", $ds_campos_atual);
            $log->bindParam(":ds_campos_antigos", $ds_campos_antigos);
            $log->execute();


            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }

    /**
     * Cria o Log para o DELETE
     * @param type $ds_tabela nome da tabela que foi afetada
     * @param type $id_tabela_pk chave primária da tabela afetada
     * @param type $id_func id do funcionário que provocou o Evento
     * @param type $ds_ip IP da máquina
     * @param type $pdo instancia do pdo
     * @return Boolean retorno true ou false
     */
    public static function SalvaLogD($ds_tabela, $id_tabela_pk, $pdo) {

        $ds_tabela = $ds_tabela;
        $id_tabela_pk = $id_tabela_pk;
        $tp_log = "D";
        $id_pessoa = $_SESSION['idUser'];
        $ds_ip = self::getIp();
        $pref = explode("_", $ds_tabela);
        $pref = $pref[0];
        $where = preg_replace('/'.$pref.'/', 'id', $ds_tabela, 1);
        $row = $pdo->query("SELECT * FROM " . $ds_tabela . "  WHERE " . $where . " = $id_tabela_pk");
        $reg = $row->fetch(PDO::FETCH_ASSOC);

        $ds_campos_atual = $reg;

        $ds_campos_atual = json_encode($ds_campos_atual, JSON_UNESCAPED_UNICODE);

        $ds_campos_antigos = NULL;


        try {

            $log = $pdo->prepare("INSERT INTO ses_log("
                    . "ds_tabela, "
                    . "id_tabela_pk, "
                    . "tp_log, "
                    . "id_pessoa, "
                    . "ds_ip, "
                    . "ds_campos_atuais, "
                    . "ds_campos_antigos) VALUES("
                    . ":ds_tabela, "
                    . ":id_tabela_pk, "
                    . ":tp_log, "
                    . ":id_pessoa, "
                    . ":ds_ip, "
                    . ":ds_campos_atual, "
                    . ":ds_campos_antigos)");

            $log->bindParam(":ds_tabela", $ds_tabela);
            $log->bindParam(":id_tabela_pk", $id_tabela_pk);
            $log->bindParam(":tp_log", $tp_log);
            $log->bindParam(":id_pessoa", $id_pessoa);
            $log->bindParam(":ds_ip", $ds_ip);
            $log->bindParam(":ds_campos_atual", $ds_campos_antigos);
            $log->bindParam(":ds_campos_antigos", $ds_campos_atual);
            $log->execute();


            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }



    /**
     * Cria o Log para o UPDATE
     * @param type $ds_tabela nome da tabela que foi afetada
     * @param type $id_tabela_pk chave primária da tabela afetada
     * @param type $id_func id do funcionário que provocou o Evento
     * @param type $ds_campos_antigos array que contém os campos anteriores ao Evento
     * @param type $ds_ip IP da máquina
     * @param type $pdo instancia do pdo
     * @return Boolean retorno true ou false
     */
    public static function SalvaLogU($ds_tabela, $id_tabela_pk, $ds_campos_antigos, $pdo) {

        $ds_tabela = $ds_tabela;
        $id_tabela_pk = $id_tabela_pk;
        $tp_log = "U";
        $id_pessoa = $_SESSION['idUser'];
        $ds_ip = self::getIp();
        $pref = explode("_", $ds_tabela);
        $pref = $pref[0];
        $where = preg_replace('/'.$pref.'/', 'id', $ds_tabela, 1);
        $row = $pdo->query("SELECT * FROM " . $ds_tabela . "  WHERE " . $where . " = $id_tabela_pk");
        $reg = $row->fetch(PDO::FETCH_ASSOC);

        $ds_campos_atual = $reg;

        $ds_campos_atualAux = array_diff_assoc($ds_campos_atual, $ds_campos_antigos);
        $ds_campos_antigosAux = array_diff_assoc($ds_campos_antigos, $ds_campos_atual);

        $ds_campos_atual = $ds_campos_atualAux;
        $ds_campos_antigos = $ds_campos_antigosAux;


        $ds_campos_atual = json_encode($ds_campos_atual, JSON_UNESCAPED_UNICODE);
        $ds_campos_antigos = json_encode($ds_campos_antigos, JSON_UNESCAPED_UNICODE);

        if (strcmp($ds_campos_atual, $ds_campos_antigos)!= 0) {
            try {

                $log = $pdo->prepare("INSERT INTO ses_log("
                        . "ds_tabela, "
                        . "id_tabela_pk, "
                        . "tp_log, "
                        . "id_pessoa, "
                        . "ds_ip, "
                        . "ds_campos_atuais, "
                        . "ds_campos_antigos) VALUES("
                        . ":ds_tabela, "
                        . ":id_tabela_pk, "
                        . ":tp_log, "
                        . ":id_pessoa, "
                        . ":ds_ip, "
                        . ":ds_campos_atual, "
                        . ":ds_campos_antigos)");

                $log->bindParam(":ds_tabela", $ds_tabela);
                $log->bindParam(":id_tabela_pk", $id_tabela_pk);
                $log->bindParam(":tp_log", $tp_log);
                $log->bindParam(":id_pessoa", $id_pessoa);
                $log->bindParam(":ds_ip", $ds_ip);
                $log->bindParam(":ds_campos_atual", $ds_campos_atual);
                $log->bindParam(":ds_campos_antigos", $ds_campos_antigos);
                $log->execute();


                return true;
            } catch (PDOException $ex) {
                echo $ex->getMessage();
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     * Cria o Log para o Login dos Usuarios
     * @param type $pdo instancia do pdo
     * @return Boolean retorno true ou false
     */
    public static function SalvaLogLogin($pdo) {

        $ds_tabela = "ses_pessoa";
        $id_tabela_pk = $_SESSION['idUser'];
        $tp_log = "L";
        $id_pessoa = $_SESSION['idUser'];
        $ds_ip = self::getIp();
        try {

            $log = $pdo->prepare("INSERT INTO ses_log("
                . "ds_tabela, "
                . "id_tabela_pk, "
                . "tp_log, "
                . "id_pessoa, "
                . "ds_ip) VALUES("
                . ":ds_tabela, "
                . ":id_tabela_pk, "
                . ":tp_log, "
                . ":id_pessoa, "
                . ":ds_ip)");

            $log->bindParam(":ds_tabela", $ds_tabela);
            $log->bindParam(":id_tabela_pk", $id_tabela_pk);
            $log->bindParam(":tp_log", $tp_log);
            $log->bindParam(":id_pessoa", $id_pessoa);
            $log->bindParam(":ds_ip", $ds_ip);
            $log->execute();

            return true;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return false;
        }

    }


    /**
     * Retornas as informações do Log em TR
     * @param array $pesquisa
     * @return string
     */
    public static function retornaTrLogs(array $pesquisa){
        $retorno = "";
        try{

            $idPessoa = (int)$pesquisa['idPessoa'];
            $acoes = $pesquisa['acoes'];
            $dtInicio = $pesquisa['dt_inicio'];
            $dtFim = $pesquisa['dt_fim'];
            $limite = (int)$pesquisa['limite'];
            if($limite == 0 || $limite > 50) $limite = 20;

            //Verificar Dados da Pesquisa, Se Foi selecionado alguma Pessoa e se possui ao menos um Ação para a pesquisa
            if($idPessoa == 0
                    ||$idPessoa == ""
                    || count($acoes) == 0){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }


            //Validando as Datas e Formatando as Datas para padrão YYYY-mm-dd
            $dtInicio = Metodos::validaConverteDataING($dtInicio);
            $dtFim = Metodos::validaConverteDataING($dtFim);

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $log = new DaoSesLog();

            $result = $log->retornaLogsPorUsuario($idPessoa, $dtInicio, $dtFim, $limite, $acoes, $pdo);

            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {

                    $idLog = $v['id_log'];
                    $tpLog = array("D" => "Removeu", "I" => "Inseriu", "U" => "Alterou", "L" => "Login");
                    $label = "default";
                    if($v['tp_log'] == "L") $label = "mint";
                    if($v['tp_log'] == "D") $label = "danger";
                    if($v['tp_log'] == "U") $label = "primary";
                    if($v['tp_log'] == "I") $label = "success";
                    $retorno .= "<tr>";
                    $retorno .= "<td class=\"text-center\"><div class=\"label label-table label-".$label."\"> " . $tpLog[$v['tp_log']] . "</div></td>"
                            . '<td class="text-center">' . $v['ds_tabela'] . '</td>'
                            . '<td class="text-center">' . $v['ds_ip'] . '</td>'
                            . '<td class="text-center">' . $v['dh_log_format'] . '</td>'
                            . '<td class="text-center">' . $v['ds_campos_atuais'] . '</td>'
                            . '<td class="text-center">' . $v['ds_campos_antigos'] . '</td>';
                    $retorno .= "</tr>";
                }
            }

            return $retorno;




        } catch (Exception $ex) {
            $retorno = "";
        }
    }

}

?>
