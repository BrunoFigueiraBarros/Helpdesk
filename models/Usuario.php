<?php
    class Usuario extends Conectar{

        public function login(){
            $conectar=parent::conexao();
            parent::set_names();
            if(isset($_POST["enviar"])){
                $email = $_POST["usu_email"];
                $pass = $_POST["usu_pass"];
                $nivel = $_POST["usu_nivel"];
                if(empty($email) and empty($pass)){
                    header("Location:".conectar::rota()."index.php?m=2");
					exit();
                }else{
                    $sql = "SELECT * FROM tm_usuario WHERE usu_email=? and usu_pass=MD5(?) and usu_nivel=? and est=1";
                    $stmt=$conectar->prepare($sql);
                    $stmt->bindValue(1, $email);
                    $stmt->bindValue(2, $pass);
                    $stmt->bindValue(3, $nivel);
                    $stmt->execute();
                    $resultado = $stmt->fetch();
                    if (is_array($resultado) and count($resultado)>0){
                        $_SESSION["usu_id"]=$resultado["usu_id"];
                        $_SESSION["usu_nom"]=$resultado["usu_nom"];
                        $_SESSION["usu_ape"]=$resultado["usu_ape"];
                        $_SESSION["nivel"]=$resultado["usu_nivel"];
                        header("Location:".Conectar::rota()."view/Home/");
                        exit(); 
                    }else{
                        header("Location:".Conectar::rota()."index.php?m=1");
                        exit();
                    }
                }
            }
        }

        public function insert_usuario($usu_nom,$usu_ape,$usu_email,$usu_pass,$usu_nivel){
            $conectar= parent::conexao();
            parent::set_names();
            $sql="INSERT INTO tm_usuario (usu_id, usu_nom, usu_ape, usu_email, usu_pass, usu_nivel, fech_crea, fech_modi, fech_elim, est) VALUES (NULL,?,?,?,MD5(?),?,now(), NULL, NULL, '1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_nom);
            $sql->bindValue(2, $usu_ape);
            $sql->bindValue(3, $usu_email);
            $sql->bindValue(4, $usu_pass);
            $sql->bindValue(5, $usu_nivel);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_usuario($usu_id,$usu_nom,$usu_ape,$usu_email,$usu_pass,$usu_nivel){
            $conectar= parent::conexao();
            parent::set_names();
            $sql="UPDATE tm_usuario set
                usu_nom = ?,
                usu_ape = ?,
                usu_email = ?,
                usu_pass = ?,
                usu_nivel = ?
                WHERE
                usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_nom);
            $sql->bindValue(2, $usu_ape);
            $sql->bindValue(3, $usu_email);
            $sql->bindValue(4, $usu_pass);
            $sql->bindValue(5, $usu_nivel);
            $sql->bindValue(6, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_usuario($usu_id){
            $conectar= parent::conexao();
            parent::set_names();
            $sql="DELETE FROM tm_usuario WHERE usu_id = ?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario(){
            $conectar= parent::conexao();
            parent::set_names();
            $sql="SELECT * FROM tm_usuario";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_x_rol(){
            $conectar= parent::conexao();
            parent::set_names();
            $sql="SELECT * FROM tm_usuario where est=1 and usu_nivel=2";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_x_id($usu_id){
            $conectar= parent::conexao();
            parent::set_names();
            $sql="SELECT * FROM tm_usuario WHERE usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_total_x_id($usu_id){
            $conectar= parent::conexao();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_totalaberto_x_id($usu_id){
            $conectar= parent::conexao();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ? and tick_estado='Aberto'";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_totalFechado_x_id($usu_id){
            $conectar= parent::conexao();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ? and tick_estado='Fechado'";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_grafico($usu_id){
            $conectar= parent::conexao();
            parent::set_names();
            $sql="SELECT tm_categoria.cat_nom as nom,COUNT(*) AS total
                FROM   tm_ticket  JOIN  
                    tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id  
                WHERE    
                tm_ticket.est = 1
                and tm_ticket.usu_id = ?
                GROUP BY 
                tm_categoria.cat_nom 
                ORDER BY total DESC";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_usuario_pass($usu_id,$usu_pass){
            $conectar= parent::conexao();
            parent::set_names();
            $sql="UPDATE tm_usuario
                SET
                    usu_pass = MD5(?)
                WHERE
                    usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_pass);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }


    }
?>