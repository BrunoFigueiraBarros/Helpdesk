<?php
    require_once("../../config/conn.php");
    session_destroy();
    header("Location:../../index.php");
    exit();
?>