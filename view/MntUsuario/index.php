<?php
  require_once("../../config/conn.php"); 
  if(isset($_SESSION["usu_id"])){ 
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>
	<title>BRUNOF</>::Manutenção do usuário</title>
</head>
<body class="with-side-menu">

    <?php require_once("../MainHeader/header.php");?>

    <div class="mobile-menu-left-overlay"></div>
    
    <?php require_once("../MainNav/nav.php");?>

	
	<div class="page-content">
		<div class="container-fluid">
			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Manutenção do usuário</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Home</a></li>
								<li class="active">Manutenção do usuário</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

			<div class="box-typical box-typical-padding">
				<button type="button" id="btnnuevo" class="btn btn-inline btn-primary">Novo Registro</button>
				<table id="usuario_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
					<thead>
						<tr>
							<th style="width: 10%;">Nome</th>
							<th style="width: 10%;">Apelido</th>
							<th class="d-none d-sm-table-cell" style="width: 40%;">E-mail</th>
							<th class="d-none d-sm-table-cell" style="width: 5%;">Senha</th>
							<th class="d-none d-sm-table-cell" style="width: 5%;">Tipo</th>
							<th class="text-center" style="width: 5%;"></th>
							<th class="text-center" style="width: 5%;"></th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>

		</div>
	</div>
	

	<?php require_once("modal.php");?>

	<?php require_once("../MainJs/js.php");?>
	
	<script type="text/javascript" src="mntusuario.js"></script>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::rota()."index.php");
  }
?>