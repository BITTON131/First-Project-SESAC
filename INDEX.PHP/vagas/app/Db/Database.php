<?php

namespace App\Db;

use \PDO;
use \PDOException;

class Database{
    /**
     * host de conexao com database
     * @var string
     */
    const HOST ="localhost";
    /**
     * nome do database
     * @var string
     */
    const NAME = "br_vagas";
    /**
     * usuario do database
     * @var string
     */
    const USER = "root";
    /**
     * senha do dtabase
     * @var string
     */
    const PASS = "";
    /**
     * Nome da tabela a ser manipulada
     * @var string
     */
    private $table;

    /**
     * INSSTACI DE CONXÃO COM DATABASE
     * @var PDO 
     */
    private $connection;

    /**
     * define a table e instancia de conexao
     * @param string
     */
    public function __construct($table = null){
        $this->table= $table;
        $this->setConnection();
    }
    /**
     * metodo responsavel por cria uma conexao com database
     */
    private function setConnection(){
        try{
          $this->connection = new PDO('mysql:host='.self::HOST.';dbname='.self::NAME,self::USER,self::PASS);
          $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOExceptoin $e){
            die('ERROR: '.$e->getMessage());
        }
    }
    /**
     * executar queries dentro do database
     * @param string
     * @param array
     * @return PDOEstatement
     */
    public function execute($query,$params =[]){
        try{
          $statement = $this->connection->prepare($query);
          $statement->execute($params);
          return $statement;
        }catch(PDOExceptoin $e){
            die('ERROR: '.$e->getMessage());
        }
    }
    /**
     * inserir dados no banco
     * @param array $values [fiel => value ]
     * @return integer ID inserido
     */
    public function insert($values){
        //dados da querry
        $fields = array_keys($values);
        $binds  = array_pad([],count($fields),'?');
        
        
        //monta a querry
        $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';

        //EXECUTA O INSERT
        $this->execute($query,array_values($values));

        //RETORNA O ID ISERIDO 
        return $this->connection->lastInsertId();
    }

    /**
     * executar uma consultar no database
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public function select($where = null, $order = null, $limit = null, $fields = '*'){
        //DADOS DA QUERRY
        $where = strlen($where) ? 'WHERE '.$where : '';
        $order = strlen($order) ? 'ORDER BY '.$order : '';
        $limit = strlen($limit) ? 'LIMIT '.$limit : '';

        //monta a query
        $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;
        //EXECUTA A QUERY

        return $this->execute($query);
    }

    /**
     * executar atualizaçoes no banco de dados 
     * @param string $where
     * @param array array
     * @return boolean
     */
    public function update($where,$values){
        //DADOS DA QUERY
        $fields = array_keys($values);

        //MONTA A QUERY
      $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;
    
      //EXECUTAR A QUERY
      $this->execute($query,array_values($values));  
        //RETORNA SUCCESS
      return true;
    }
    /**
     * excluir dados do banco
     * @param string
     * @return boolean
     */
    public function delete($where){
        //MONTA A QUERY
        $query = 'DELETE FROM '.$this->table.' WHERE '.$where;

        //EXECUTAR A QUERY
        $this->execute($query);

        //RETORNA SUCCESS
        return true;
    }

}