<?php
//ini_set("soap.wsdl_cache_enabled", "1"); // Set to zero to avoid caching WSDL
require_once('nusoap.php');

class ws_sga {

    private function conecta() {
        //$client = new SoapClient('http://10.1.2.69:9081/grpServiceHttpRouter/services/GrpService/wsdl/GrpService.wsdl', true);
        $client = new nusoap_client('http://10.1.2.69:9081/grpServiceHttpRouter/services/GrpService/wsdl/GrpService.wsdl', true);
        
        // verifica se ocorreu erro na cria��o do objeto
        $err = $client->getError();
        if ($err) {
            echo "Erro no construtor<pre>" . $err . "</pre>";
        }else
            return $client;
    }
    
    private function pesquisa($metodo, $array) {
        try{
            
        
        $cliente = $this->conecta();     
        
        $res = $cliente->call($metodo, $array); // chamada do m�todo SOAP 
        
        if ($res[$metodo.'Return'] != '')
            return $res[$metodo.'Return']['CatalagoMaterial'];
        else
            return false;
        
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    //Tratar o token de pesquisa
    private function tratarToken($key, $token){
        $str_pesq = array();
        if (is_array($token)){
            foreach ($token as $key => $value) {
                $str_pesq[] = array($key => $value);
            }
        } else {
            $str_pesq[] = array($key => $token);
        }
        return $str_pesq;
    }
    
    //C�DIGO DO GRUPO
    public function pesquisaCodigoGrupo($token) {
        return $this->pesquisa('getCatalagoMaterialByCodigoGrupo', $this->tratarToken('codigoGrupo', $token));
    }

    //NOME DO GRUPO
    public function pesquisaNomeGrupo($token) {
        return $this->pesquisa('getCatalagoMaterialByNomeGrupo', $this->tratarToken('nomeGrupo', $token));
    }

    //C�DIGO DO SUB-GRUPO
    public function pesquisaCodigoSubGrupo($token) {
        return $this->pesquisa('getCatalagoMaterialByCodigoSubGrupo', $this->tratarToken('codigoSubGrupo', $token));
    }

    //NOME DO SUB-GRUPO
    public function pesquisaNomeSubGrupo($token) {
        return $this->pesquisa('getCatalagoMaterialByNomeSubGrupo', $this->tratarToken('nomeSubGrupo', $token));
    }

    //C�DIGO DO MATERIAL
    public function pesquisaCodigoMaterial($token) {
        return $this->pesquisa('getCatalagoMaterialByCodigoMaterial', $this->tratarToken('codigoMaterial', $token));
    }

    //NOME DO MATERIAL
    public function pesquisaNomeMaterial($token) {
        return $this->pesquisa('getCatalagoMaterialByNomeMaterial', $this->tratarToken('nomeMaterial', $token));
    }

    //C�DIGO DA DESCRI��O DO MATERIAL
    public function pesquisaCodigoDescMaterial($token) {
        return $this->pesquisa('getCatalagoMaterialByCodigoDescMaterial', $this->tratarToken('codigoDescMaterial', $token));
    }

    //DESCRU��O DO MATERIAL
    public function pesquisaDescricaoMaterial($token) {
        return $this->pesquisa('getCatalagoMaterialByDescricaoMaterial', $this->tratarToken('descricaoMaterial',$token));
    }

    //TIPO DE MATERIAL
    public function pesquisaTipoMaterial($token) {
        return $this->pesquisa('getCatalagoMaterialByTipoMaterial', $this->tratarToken('tipoMaterial', $token));
    }

    //ELEMENTO DESPESA
    public function pesquisaElementoDespesa($token) {
        return $this->pesquisa('getCatalagoMaterialByElementoDespesa', $this->tratarToken('elementoDespesa', $token));
    }
}