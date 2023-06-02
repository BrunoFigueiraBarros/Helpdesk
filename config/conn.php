<?php
    session_start();

    class Conectar{
        protected $dbh;

        protected function Conexao(){
            try {
        
				$conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=","","");
           
				return $conectar;
			} catch (Exception $e) {
				print "Erro: " . $e->getMessage() . "<br/>";
				die();
			}
        }

        public function set_names(){
			return $this->dbh->query("SET NAMES 'utf8'");
        }

        public static function rota(){
			return "";      
		}

    }
?>