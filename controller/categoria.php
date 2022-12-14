<?php
    require_once("../config/conn.php");
    require_once("../models/Categoria.php");
    $categoria = new Categoria();

    switch($_GET["op"]){
        case "combo":
            $dados = $categoria->get_categoria();
            if(is_array($dados)==true and count($dados)>0){
                foreach($dados as $row)
                {
                    $html.= "<option value='".$row['cat_id']."'>".$row['cat_nom']."</option>";
                }
                echo $html;
            }
        break;
    }
?>