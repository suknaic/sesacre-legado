<?php

declare(strict_types = 1);

class Metodos {

    /**
     * Utilizado para format uma mensagem que será entregue via requesição do ajax.
     * @param type $tipoMsg
     * @param type $tipoExibicao
     * @param type $msg
     * @return type
     */
    public static function retornoAjax($tipoMsg = null, $tipoExibicao = null, $msg = null) {
        $array = array();
        $array = array("tipoMsg" => $tipoMsg, "tipoExibicao" => $tipoExibicao, "msg" => $msg);
        $array = json_encode($array);
        return $array;
    }

    public static function retornaPasswordHash($senha = null) {
        return password_hash($senha, PASSWORD_DEFAULT, ['cost' => 14]);
    }

    public static function validaCPF($cpf = null) {
        $cpf = str_pad(preg_replace("/[^0-9]/", '', $cpf), 11, '0', STR_PAD_LEFT);
        // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
        if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999'
        ) {
            return false;
        } else {   // Calcula os números para verificar se o CPF é verdadeiro
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }

                $d = ((10 * $d) % 11) % 10;

                if ($cpf{$c} != $d) {
                    return false;
                }
            }

            return true;
        }
    }

    /**
     * Transforma o cpf a partir de seu estado inicial, caso "999.999.999-99" = "99999999999", caso "99999999999" = "999.999.999-99";
     * @param type $cpf estado inicial do cpf
     * @return string retorna o cpf formatado
     */
    public static function formataCpf($cpf) {
        $novoCpf = "";
        if (strlen($cpf) > 11) {
            $valorRetirar = array(".", "-");
            $novoCpf = str_replace($valorRetirar, "", $cpf);
        } else {
            $parte1 = substr($cpf, 0, 3);
            $parte2 = substr($cpf, 3, 3);
            $parte3 = substr($cpf, 6, 3);
            $parte4 = substr($cpf, 9, 3);
            $novoCpf = $parte1 . "." . $parte2 . "." . $parte3 . "-" . $parte4;
        }
        return $novoCpf;
    }

    /**
     * Transforma o cnpj a partir de seu estado inicial, caso "99.999.999/9999-99" = "99999999999", caso "99999999999" = "999.999.999-99";
     * @param type $cpf estado inicial do cpf
     * @return string retorna o cpf formatado
     */
    public static function formataCnpj($cnpj) {
        $novoCnpj = "";
        if (strlen($cnpj) > 14) {
            $valorRetirar1 = array(".", "-", "/");
            $novoCnpj = str_replace($valorRetirar1, "", $cnpj);
        } else {
            $parte1 = substr($cnpj, 0, 2);
            $parte2 = substr($cnpj, 2, 3);
            $parte3 = substr($cnpj, 5, 3);
            $parte4 = substr($cnpj, 8, 4);
            $parte5 = substr($cnpj, 12, 2);
            $novoCnpj = $parte1 . "." . $parte2 . "." . $parte3 . "/" . $parte4 . "-" . $parte5;
        }
        return $novoCnpj;
    }

    public static function formataTelefone(string $numero = null): string {
        if ($numero != null) {
            $numero = trim($numero);
            $prefixo = substr($numero, 0, 2);
            $x = substr($numero, 2, 4);
            $y = substr($numero, 6, 4);
            $numero = "(" . $prefixo . ") " . $x . "-" . $y;
            return $numero;
        } else {
            return $numero;
        }
    }

    //***********************(99)9 9999-9999***************************************************
    public static function formataCelular(string $numero = null): string {
        if ($numero != null) {
            $numero = trim($numero);
            $prefixo = substr($numero, 0, 2);
            $a = substr($numero, 2, 1);
            $b = substr($numero, 3, 4);
            $c = substr($numero, 7, 4);
            $numero = "(" . $prefixo . ") " . $a . " " . $b . "-" . $c;
            return $numero;
        } else {
            return $numero;
        }
    }

    /**
     * Limpa o CPF ou CNPJ";
     * @param type $cpf ou cnpj
     * @return string retorna o cpf ou cnpj sem nenhum caracter especial
     */
    public static function limpaCPF_CNPJ($valor = null) {
        if ($valor != null) {
            $valor = trim($valor);
            $valor = str_replace(".", "", $valor);
            $valor = str_replace(",", "", $valor);
            $valor = str_replace("-", "", $valor);
            $valor = str_replace("/", "", $valor);
            return $valor;
        } else {
            return $valor;
        }
    }

    public static function removeMascaraCel_Tel(string $valor = null): string {
        if ($valor != null) {
            $valor = trim($valor);
            $valor = str_replace("(", "", $valor);
            $valor = str_replace(")", "", $valor);
            $valor = str_replace("-", "", $valor);
            $valor = str_replace(" ", "", $valor);
            return $valor;
        } else {
            return $valor;
        }
    }

    public static function primerioNomePessoa(string $nmPessoa = null): string {
        if ($nmPessoa != NULL || $nmPessoa != "") {
            $string = explode(" ", $nmPessoa);
            $nome = ucfirst(strtolower($string[0]));
            if ($nome == NULL) {
                return "";
            } else {
                return $nome;
            }
        } else {
            return "";
        }
    }

    /**
     * 
     * @param type $date data 
     * @param type $format formato para verificaçao exemplo d/m/Y ou Y-m-d H:i:s
     * @return true caso a data seja valida ou false ser a data for invalida 
     */
    public static function ValidaData($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    /**
     * Recebe um Valor em Real e retorna o Valor em US(Dola), para salvar em banco.
     * @param string $numero
     * @return string
     */
    public static function ConverteValorIng(string $numero): string {
        $numero = str_replace(".", "", $numero);
        $numero = str_replace(",", ".", $numero);
        return $numero;
    }

    /**
     * 
     * @param float $numero
     * @param int $digitos
     * @return string
     */
    public static function ConverteValorBr(float $numero = null, int $digitos): string {
        switch ($digitos) {
            case 4:
                if ($numero != 0) {
                    $numero = number_format($numero, 4, ',', '.');
                    break;
                } else {
                    $numero = '0,0000';
                    break;
                }
            case 2:
                if ($numero != 0) {
                    $numero = number_format($numero, 2, ',', '.');
                } else {
                    $numero = '0,00';
                    break;
                }
        }

        return $numero;
    }

    public static function ConverteDataING(string $data): string {
        $explode = explode('/', $data);
        $dataBanco = $explode[2] . "-" . $explode[1] . "-" . $explode[0];
        return $dataBanco;
    }

    public static function ConverteDataBR(string $data): string {
        $explodida = explode("-", $data);
        $explodida01 = explode(" ", $explodida[2]);
        $dataIso = $explodida01[0] . "/" . $explodida[1] . "/" . $explodida[0];
        return $dataIso;
    }

    /**
     * Valida uma Data Br(dd/mm/YYYY) e converte para ING(YYYY-mm-dd)
     * Retorna vazio caso não dê certo
     * @param string $data Formato (mm/dd/YYYY)
     * @return string
     */
    public static function validaConverteDataING(string $data): string {
        $retorno = "";
        try {
            if ($data != '' || $data !== "" || $data != null) {
                $data = explode("/", trim($data)); // fatia a string $data em pedados, usando / como referência
                if (count($data) != 3) {
                    return $retorno;
                }
                $d = (int) $data[0];
                $m = (int) $data[1];
                $y = (int) $data[2];
                $res = checkdate($m, $d, $y);
                if ($res) {
                    $retorno = $data[2] . "-" . $data[1] . "-" . $data[0];
                }
            }
            return $retorno;
        } catch (Exception $exc) {
            return $retorno;
        }
    }

    /**
     * Retorna Um Array contendo todos os Meses
     * Formato 99 => nomeDoMês
     * @return array
     */
    public static function getMeses(): array {
        $arr_meses = array(
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro'
        );
        return $arr_meses;
    }

    /**
     * Retorna campos em Options para a TAG select contendo os possíveis anos que poderão ser trabalhados 
     * @param type $ano
     * @return string
     */
    public static function retornaAnosSelect($ano = ""): string {
        $anoMaximo = date("Y") + 1;
        $anoAtual = date("Y");
        $anosReturn = "";
        for ($i = $anoMaximo; $i >= ANO_INICIO_SISTEMA; $i--) {
            if ($i == $ano || ($ano == "" && $anoAtual == $i)) {
                $anosReturn .= "<option value=" . $i . " selected>" . $i . "</option>";
            } else {
                $anosReturn .= "<option value=" . $i . ">" . $i . "</option>";
            }
        }
        return $anosReturn;
    }

    public static function validaValoresNulos($dados = null) {
        if ($dados == "" || $dados == '' || $dados == null) {
            return null;
        } else {
            return $dados;
        }
    }

    public static function implodeComAspas(array $array = null) {

        $ids = implode("', '", array_map('strval', $array));
        $ids = "'" . $ids . "'";
        return $ids;
    }

    /**
     * Retorna um Array com os Tipos da Fonte
     * @return array
     */
    public static function retornaTpFonte(): array {
        $array = array(
            TP_FONTE_MAC => "MAC",
            TP_FONTE_CP => "Contra Partida"
        );
        return $array;
    }

    /**
     * Retorna campos em Options dos Tipos da Fonte
     * @return string
     */
    public static function retornaTpFonteSelect(): string {
        $retorno = "";
        $retorno .= "<option value='0'>Selecione um Tipo da Fonte</option>";
        foreach (self::retornaTpFonte() as $key => $value) {
            $retorno .= "<option value=" . $key . ">" . $value . "</option>";
        }
        return $retorno;
    }

    public static function retornaTpFonteTexto($tpFonte): string {
        if (empty($tpFonte)) {
            return "";
        } else {
            return self::retornaTpFonte()[$tpFonte];
        }
    }

    /**
     * 
     * Retorna Um Array contendo todos as Fontes
     * Formato 999 => Número da Fonte
     * @return array
     */
    public static function getFontes(): array {
        $arr_fontes = array(
            FONTE_100 => 100,
            FONTE_200 => 200,
            FONTE_400 => 400,
            FONTE_500 => 500
        );
        return $arr_fontes;
    }

    /**
     * Retorna campos em Options das Fonte
     * @return string
     */
    public static function retornaFonteSelect(): string {
        $retorno = "";
        $retorno .= "<option value='0'>Selecione uma Fonte</option>";
        foreach (self::getFontes() as $key => $value) {
            $retorno .= "<option value=" . $key . ">" . $value . "</option>";
        }
        return $retorno;
    }

    public static function valorPorExtenso($valor, $unidade = '') {
        switch ($unidade) {
            case '$':
                $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
                $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");
                break;

            case '-':
                $singular = array("", "", "", "", "o", "", "");
                $plural = array("", "", "", "", "", "", "");
                break;

            default:
                $singular = array("centavo", "litro", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
                $plural = array("centavos", "litros", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");
                break;
        }

        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");

        $z = 0;

        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);
        for ($i = 0; $i < count($inteiro); $i++)
            for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++)
                $inteiro[$i] = "0" . $inteiro[$i];

        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
        $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
        $rt = '';

        for ($i = 0; $i < count($inteiro); $i++) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count($inteiro) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ($valor == "000")
                $z++;
            elseif ($z > 0)
                $z--;
            if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
                $r .= (($z > 1) ? " de " : "") . $plural[$t];
            if ($r)
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }

        return($rt ? $rt : "zero");
    }

    public static function obterDataBRTimestamp($data) {
        if ($data != '') {
            $data = substr($data, 0, 10);
            $explodida = explode("-", $data);
            $dataIso = $explodida[2] . "/" . $explodida[1] . "/" . $explodida[0];
            return $dataIso;
        }
        return NULL;
    }

    public static function obterHoraTimestamp($data) {
        return substr($data, 11, 5);
    }

    public static function validaCNPJ($cnpj = null) {

        // Verifica se um número foi informado
        if(empty($cnpj)) {
            return false;
        }

        // Elimina possivel mascara
        $cnpj = preg_replace("/[^0-9]/", "", $cnpj);
        $cnpj = str_pad($cnpj, 14, '0', STR_PAD_LEFT);

        // Verifica se o numero de digitos informados é igual a 11
        if (strlen($cnpj) != 14) {
            return false;
        }

        // Verifica se nenhuma das sequências invalidas abaixo
        // foi digitada. Caso afirmativo, retorna falso
        else if ($cnpj == '00000000000000' ||
            $cnpj == '11111111111111' ||
            $cnpj == '22222222222222' ||
            $cnpj == '33333333333333' ||
            $cnpj == '44444444444444' ||
            $cnpj == '55555555555555' ||
            $cnpj == '66666666666666' ||
            $cnpj == '77777777777777' ||
            $cnpj == '88888888888888' ||
            $cnpj == '99999999999999') {
            return false;

            // Calcula os digitos verificadores para verificar se o
            // CPF é válido
        } else {

            $j = 5;
            $k = 6;
            $soma1 = "";
            $soma2 = "";

            for ($i = 0; $i < 13; $i++) {

                $j = $j == 1 ? 9 : $j;
                $k = $k == 1 ? 9 : $k;

                $soma2 += ($cnpj{$i} * $k);

                if ($i < 12) {
                    $soma1 += ($cnpj{$i} * $j);
                }

                $k--;
                $j--;

            }

            $digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
            $digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;

            return (($cnpj{12} == $digito1) and ($cnpj{13} == $digito2));

        }
    }

    public static function validaEmail($email = null) {
        if(preg_match("/^([[:alnum:]_.-]){3,}@([[:lower:][:digit:]_.-]{3,})(.[[:lower:]]{2,3})(.[[:lower:]]{2})?$/", $email)) {
            return true;
        }else{
            return false;
        }
    }

}

?>
