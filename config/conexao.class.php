<?php
  /**Classe de conexao**/
  class Conexao{
      /*Método construtor do banco de dados*/
      public function __construct(){}

      /*Evita que a classe seja clonada*/
      public function __clone(){}

      /*Método que destroi a conexão com banco de dados e remove da memória todas as variáveis setadas*/
      public function __destruct() {
          $this->disconnect();
          foreach ($this as $key => $value) {
              unset($this->$key);
          }
      }

      private static $dbtype   = "pgsql";
      private static $host     = null;
      private static $port     = null;
      private static $user     = null;
      private static $password = null;
      private static $db       = null;

      /*Metodos que trazem o conteudo da variavel desejada
      @return   conteudo da variavel solicitada*/
      private function getDBType()  {return self::$dbtype;}
      private function getHost()    {return self::$host;}
      private function getPort()    {return self::$port;}
      private function getUser()    {return self::$user;}
      private function getPassword(){return self::$password;}
      private function getDB()      {return self::$db;}

      public function connect(){
          if (self::$host === null) {
              self::$host     = getenv('DB_HOST') ?: 'localhost';
              self::$port     = getenv('DB_PORT') ?: '5432';
              self::$user     = getenv('DB_USER') ?: 'postgres';
              self::$password = getenv('DB_PASSWORD') ?: 'postgres';
              self::$db       = getenv('DB_NAME') ?: 'sesacre';
          }
          try
          {
              $this->conexao = new PDO($this->getDBType().":host=".$this->getHost().";port=".$this->getPort().";dbname=".$this->getDB(), $this->getUser(), $this->getPassword());
              $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
          }
          catch (PDOException $i)
          {
              //se houver exceção, exibe
              die("Erro: <code>" . $i->getMessage() . "</code>");
          }

          return ($this->conexao);
      }

      public function disconnect(){
          $this->conexao = null;
      }
  }
