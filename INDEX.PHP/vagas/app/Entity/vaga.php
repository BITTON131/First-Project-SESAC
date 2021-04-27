<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;

class vaga{

     /**
     * Identificador único da vaga
     * @var integer
     */
    public $id;

    /**
     * Identificador único da vaga
     * @var integer
     */
    public $titulo;

    /**
     * descrição da vaga
     * @var string
     */
    public $descricao;

    /**
     * Define se a vaga é Status
     * @var string(s/n)
     */
    public $ativo;

    /**
     *Data de publição da vaga
     *@var string
     */
    public $data;


    /**
     * cadastar uma nova vaga no bd
     * @return boolen
     */
    public function cadastrar (){
    //DEFINE A DATA 
    $this->data = date('Y-m-d H:i:s');

    //INSERIR A VAGA NO DATABASE
    $obDatabase = new Database('vagas');
    $this->id = $obDatabase->insert([
        'titulo' => $this->titulo,
        'descricao' => $this->descricao,
        'ativo' => $this->ativo,
        'data' => $this->data
    ]);
    
    //RETONAR SUCCESS
    return true;
    }
    /**
     * atualizar vaga no database
     * @return boolean
     */
    public function atualizar(){
       return (new Database('vagas'))->update('id = '.$this->id,[
        'titulo' => $this->titulo,
        'descricao' => $this->descricao,
        'ativo' => $this->ativo,
        'data' => $this->data
       ]);
    }
    
    /**
    * EXCLUI A VAGA DO DATABASE
    *@return boolean
    */
    
    public function excluir(){
        return (new Database('vagas'))->delete('id='.$this->id);
    }


    /**
     * obter as vagas do banco de dados
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return array
     */
    public static function getVagas($where = null, $order = null, $limit = null){
        return (new Database('vagas'))->select($where,$order,$limit)
                                      ->fetchAll(PDO::FETCH_CLASS,self::class);
    }
    /**
     * buscar uma vaga com base no ID
     * @param integer
     * @return Vaga
     */
    public static function getVaga($id){
        return (new Database('vagas'))->select('id = '.$id)
                                      ->fetchObject(self::class);
    }


}