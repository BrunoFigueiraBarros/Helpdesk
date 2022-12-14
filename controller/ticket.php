<?php
    require_once("../config/conn.php");
    require_once("../models/Ticket.php");
    $ticket = new Ticket();

    require_once("../models/Usuario.php");
    $usuario = new Usuario();

    require_once("../models/Documento.php");
    $documento = new Documento();

    switch($_GET["op"]){

        case "insert":
            $dados=$ticket->insert_ticket($_POST["usu_id"],$_POST["cat_id"],$_POST["tick_titulo"],$_POST["tick_descrip"]);
            if (is_array($dados)==true and count($dados)>0){
                foreach ($dados as $row){
                    $output["tick_id"] = $row["tick_id"];            
                }
            }
            echo json_encode($dados);
        break;

        case "update":
            $ticket->update_ticket($_POST["tick_id"]);
            $ticket->insert_ticketdatalhe_cerrar($_POST["tick_id"],$_POST["usu_id"]);
        break;

        case "reabrir":
            $ticket->reabrir_ticket($_POST["tick_id"]);
            $ticket->insert_ticketdatalhe_reabrir($_POST["tick_id"],$_POST["usu_id"]);
        break;

        case "atribuir":
            $ticket->update_ticket_asignacion($_POST["tick_id"],$_POST["usu_asig"]);
        break;

        case "listar_x_usu":
            $dados=$ticket->listar_ticket_x_usu($_POST["usu_id"]);
            $data= Array();
            foreach($dados as $row){
                $sub_array = array();
                $sub_array[] = $row["tick_id"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["tick_titulo"];

                if ($row["tick_estado"] == "Aberto"){
                    $sub_array[] = '<span class="label label-pill label-success">Aberto</span>';
                }else{
                    $sub_array[] = '<a onClick="CambiarEstado('.$row["tick_id"].')"><span class="label label-pill label-danger">Fechado</span></a>';
                }

                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

                if($row["fech_asig"] == null || $row["fech_asig"] == ""){
                    $sub_array[] = '<span class="label label-pill label-default">Não atribuído</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
                }

                if($row["usu_asig"]==null || $row["fech_asig"] == ""){
                    $sub_array[] = '<span class="label label-pill label-warning">Não atribuído</span>';
                }else{
                    $dados1=$usuario->get_usuario_x_id($row["usu_asig"]);
                    foreach($dados1 as $row1){
                        $sub_array[] = '<span class="label label-pill label-success">'. $row1["usu_nom"].'</span>';
                    }
                }

                $sub_array[] = '<button type="button" onClick="ver('.$row["tick_id"].');"  id="'.$row["tick_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;

        case "listar":
            $dados=$ticket->listar_ticket();
            $data= Array();
            foreach($dados as $row){
                $sub_array = array();
                $sub_array[] = $row["tick_id"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["tick_titulo"];

                if ($row["tick_estado"]=="Aberto"){
                    $sub_array[] = '<span class="label label-pill label-success">Aberto</span>';
                }else{
                    $sub_array[] = '<a onClick="CambiarEstado('.$row["tick_id"].')"><span class="label label-pill label-danger">Fechado</span><a>';
                }

                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

                if($row["fech_asig"]==null){
                    $sub_array[] = '<span class="label label-pill label-default">Não atribuído</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
                }

                if($row["usu_asig"]==null){
                    $sub_array[] = '<a onClick="atribuir('.$row["tick_id"].');"><span class="label label-pill label-warning">Não atribuído</span></a>';
                }else{
                    $dados1=$usuario->get_usuario_x_id($row["usu_asig"]);
                    foreach($dados1 as $row1){
                        $sub_array[] = '<span class="label label-pill label-success">'. $row1["usu_nom"].'</span>';
                    }
                }

                $sub_array[] = '<button type="button" onClick="ver('.$row["tick_id"].');"  id="'.$row["tick_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;

        case "listardetalle":
            $dados=$ticket->listar_ticketdetalle_x_ticket($_POST["tick_id"]);
            ?>
                <?php
                    foreach($dados as $row){
                        ?>
                            <article class="activity-line-item box-typical">
                                <div class="activity-line-date">
                                    <?php echo date("d/m/Y", strtotime($row["fech_crea"]));?>
                                </div>
                                <header class="activity-line-item-header">
                                    <div class="activity-line-item-user">
                                        <div class="activity-line-item-user-photo">
                                            <a href="#">
                                                <img src="../../public/<?php echo $row['usu_nivel'] ?>.jpg" alt="">
                                            </a>
                                        </div>
                                        <div class="activity-line-item-user-name"><?php echo $row['usu_nom'].' '.$row['usu_ape'];?></div>
                                        <div class="activity-line-item-user-status">
                                            <?php 
                                                if ($row['usu_nivel']==1){
                                                    echo 'Usuario';
                                                }else{
                                                    echo 'Suporte';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </header>
                                <div class="activity-line-action-list">
                                    <section class="activity-line-action">
                                        <div class="time"><?php echo date("H:i:s", strtotime($row["fech_crea"]));?></div>
                                        <div class="cont">
                                            <div class="cont-in">
                                                <p>
                                                    <?php echo $row["tickd_descrip"];?>
                                                </p>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </article>
                        <?php
                    }
                ?>
            <?php
        break;

        case "mostrar";
            $dados=$ticket->listar_ticket_x_id($_POST["tick_id"]);  
            if(is_array($dados)==true and count($dados)>0){
                foreach($dados as $row)
                {
                    $output["tick_id"] = $row["tick_id"];
                    $output["usu_id"] = $row["usu_id"];
                    $output["cat_id"] = $row["cat_id"];

                    $output["tick_titulo"] = $row["tick_titulo"];
                    $output["tick_descrip"] = $row["tick_descrip"];

                    if ($row["tick_estado"]=="Aberto"){
                        $output["tick_estado"] = '<span class="label label-pill label-success">Aberto</span>';
                    }else{
                        $output["tick_estado"] = '<span class="label label-pill label-danger">Fechado</span>';
                    }

                    $output["tick_estado_texto"] = $row["tick_estado"];

                    $output["fech_crea"] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));
                    $output["usu_nom"] = $row["usu_nom"];
                    $output["usu_ape"] = $row["usu_ape"];
                    $output["cat_nom"] = $row["cat_nom"];
                }
                echo json_encode($output);
            }   
        break;

        case "insertdetalhe":
            $ticket->insert_ticketdatalhe($_POST["tick_id"],$_POST["usu_id"],$_POST["tickd_descrip"]);
        break;

        case "total";
            $dados=$ticket->get_ticket_total();  
            if(is_array($dados)==true and count($dados)>0){
                foreach($dados as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
        break;

        case "totalaberto";
            $dados=$ticket->get_ticket_totalaberto();  
            if(is_array($dados)==true and count($dados)>0){
                foreach($dados as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
        break;

        case "totalFechado";
            $dados=$ticket->get_ticket_totalFechado();  
            if(is_array($dados)==true and count($dados)>0){
                foreach($dados as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
        break;

        case "grafico";
            $dados=$ticket->get_ticket_grafico();  
            echo json_encode($dados);
        break;

    }
?>