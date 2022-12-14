<?php
    require_once("../config/conn.php");
    require_once("../models/Usuario.php");
    $usuario = new Usuario();

    switch($_GET["op"]){
        case "salvareeditar":
            if(empty($_POST["usu_id"])){       
                $usuario->insert_usuario($_POST["usu_nom"],$_POST["usu_ape"],$_POST["usu_email"],$_POST["usu_pass"],$_POST["usu_nivel"]);     
            }
            else {
                $usuario->update_usuario($_POST["usu_id"],$_POST["usu_nom"],$_POST["usu_ape"],$_POST["usu_email"],$_POST["usu_pass"],$_POST["usu_nivel"]);
            }
            break;

        case "listar":
            $dados=$usuario->get_usuario();
            $data= Array();
            foreach($dados as $row){
                $sub_array = array();
                $sub_array[] = $row["usu_nom"];
                $sub_array[] = $row["usu_ape"];
                $sub_array[] = $row["usu_email"];
                $sub_array[] = $row["usu_pass"];

                if ($row["usu_nivel"]=="1"){
                    $sub_array[] = '<span class="label label-pill label-success">Usuario</span>';
                }else{
                    $sub_array[] = '<span class="label label-pill label-info">Suporte</span>';
                }

                $sub_array[] = '<button type="button" onClick="editar('.$row["usu_id"].');"  id="'.$row["usu_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["usu_id"].');"  id="'.$row["usu_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;

        case "eliminar":
            $usuario->delete_usuario($_POST["usu_id"]);
            break;

        case "mostrar";
            $dados=$usuario->get_usuario_x_id($_POST["usu_id"]);  
            if(is_array($dados)==true and count($dados)>0){
                foreach($dados as $row)
                {
                    $output["usu_id"] = $row["usu_id"];
                    $output["usu_nom"] = $row["usu_nom"];
                    $output["usu_ape"] = $row["usu_ape"];
                    $output["usu_email"] = $row["usu_email"];
                    $output["usu_pass"] = $row["usu_pass"];
                    $output["usu_nivel"] = $row["usu_nivel"];
                }
                echo json_encode($output);
            }   
            break;

        case "total";
            $dados=$usuario->get_usuario_total_x_id($_POST["usu_id"]);  
            if(is_array($dados)==true and count($dados)>0){
                foreach($dados as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;

        case "totalaberto";
            $dados=$usuario->get_usuario_totalaberto_x_id($_POST["usu_id"]);  
            if(is_array($dados)==true and count($dados)>0){
                foreach($dados as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;

        case "totalFechado";
            $dados=$usuario->get_usuario_totalFechado_x_id($_POST["usu_id"]);  
            if(is_array($dados)==true and count($dados)>0){
                foreach($dados as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;

        case "grafico";
            $dados=$usuario->get_usuario_grafico($_POST["usu_id"]);  
            echo json_encode($dados);
            break;

        case "combo";
            $dados = $usuario->get_usuario_x_rol();
            if(is_array($dados)==true and count($dados)>0){
                $html.= "<option label='Seleccionar'></option>";
                foreach($dados as $row)
                {
                    $html.= "<option value='".$row['usu_id']."'>".$row['usu_nom']."</option>";
                }
                echo $html;
            }
            break;
      
        case "password":
            $usuario->update_usuario_pass($_POST["usu_id"],$_POST["usu_pass"]);
            break;

    }
?>