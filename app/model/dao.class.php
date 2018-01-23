<?php

    class dao{

        private $obj_db;
        private $objetoConexao;

        function __construct ($caminho){

            require_once($caminho."/model/db.class.php");
            
            $this->obj_db = new db();
            
            //Pega o resultado de conecta_mysql, e atribui no objeto conexao
            $this->objetoConexao = $this->obj_db->conecta_mysql();

        }

        public function executeSelect($query){
            
            $resultado_id = mysqli_query($this->objetoConexao, $query);
            
            if($resultado_id){
                
                //Passa para um vetor o resultado da query
                $dados_usuario = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);

                return $dados_usuario;
            }
            else{
                return null;
            }
            
        }

        public function executeSelectAssoc($query){
            
            return mysqli_query($this->objetoConexao, $query); 
            
        }
        

        public function executeInsert($query){
            
            if(mysqli_query($this->objetoConexao, $query)){
                return true;   
            }
            else return false;

        }

        public function executeUpdate($query){
            if(mysqli_query($this->objetoConexao, $query)){
                return true;
            }
            else{
                false;
            }
        }

        public function executeDelete($query){
            
            

        }

    }

?>