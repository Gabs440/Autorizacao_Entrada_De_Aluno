<head>
	<meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" type="text/css"/>
    <link rel="icon" href="../img/etec.png" type="image/png"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <title>Consulta</title>
</head>

<?php
//Incluindo a conexão do PHP.
include_once("conexao.php");

//Este bloco é responsável pelo sistema de paginação
$pagina = filter_input(INPUT_POST, 'pagina', FILTER_SANITIZE_NUMBER_INT);
$qnt_result_pg = filter_input(INPUT_POST, 'qnt_result_pg', FILTER_SANITIZE_NUMBER_INT);
//calcular o inicio visualização
$inicio = ($pagina * $qnt_result_pg) - $qnt_result_pg;

if (isset($_POST['filtro_rm'])) {
	$rm = $_POST['filtro_rm'];
	$result_usuario = "SELECT * FROM tbregistro WHERE RM = '$rm' ORDER BY data DESC, hora DESC";
	$resultado_usuario = mysqli_query($conexao, $result_usuario);

	//Verificar se encontrou resultado na tabela "tbregistro"
	if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
		?>
			<div id="logos"style="">
				<!--<img id="eteclogo" src="img/etec.png">-->
				<img id="cpslogo" src="../img/sp.png">
			</div>

			<div class="headingconsulta">
				<b>AUTORIZAÇÕES DE ENTRADA</b>
			</div>

			<div class="container">
				<button class='page-link' onClick='window.print()'>Imprimir</button>
				<!--Tabela que conterá os registros da tabela tbregistro -->
				<table class="table table-striped table-bordered table-hover float-lg-start table-light">
					<thead>
						<!--Esta é a primeira Linha da coluna, nela apresenta o nome da coluna e o campo para filtragem-->
						<tr>
							<th>RM</th>
							<th>Aluno</th>
							<th>Turma</th>
							<th>Data</th>
							<th>Hora</th>
							<th>Motivo</th>
						</tr>
					</thead>

					<tbody class="table-group-divider">
						<?php
							//Sistema que irá percorrer as linhas da tabela e exibir os registros
							while($row_usuario = mysqli_fetch_assoc($resultado_usuario)){
						?>
								<tr>
									<th><?php echo $row_usuario['RM']; ?></th>
									<td><?php echo $row_usuario['nomealuno']; ?></td>
									<td><?php echo $row_usuario['serie_curso']; ?></td>
									<td><?php echo $row_usuario['data']; ?></td>
									<td><?php echo $row_usuario['hora']; ?></td>
									<td><?php echo $row_usuario['motivo']; ?></td>
								</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			</div>
		<?php

	}
	else{
		echo "<div class='alert alert-danger' role='alert'>Nenhum aluno encontrado!</div>";
	}

} else {
	$result_usuario = "SELECT * FROM tbregistro ORDER BY data DESC, hora DESC LIMIT $inicio, $qnt_result_pg";
	$resultado_usuario = mysqli_query($conexao, $result_usuario);
	//Verificar se encontrou resultado na tabela "tbregistro"
	if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
		?>
		<table class="table table-striped table-bordered table-hover float-lg-start table-light">
			<thead>
				<!--Esta é a primeira Linha da coluna, nela apresenta o nome da coluna e o campo para filtragem-->
				<tr>
					<th>RM</th>
					<th>Aluno</th>
					<th>Turma</th>
					<th>Data</th>
					<th>Hora</th>
					<th>Motivo</th>
				</tr>
			</thead>

			<tbody class="table-group-divider">
				<?php
				//Sistema que irá percorrer as linhas da tabela e exibir os registros
				while($row_usuario = mysqli_fetch_assoc($resultado_usuario)){
					?>
					<tr>
						<th><?php echo $row_usuario['RM']; ?></th>
						<td><?php echo $row_usuario['nomealuno']; ?></td>
						<td><?php echo $row_usuario['serie_curso']; ?></td>
						<td><?php echo $row_usuario['data']; ?></td>
						<td><?php echo $row_usuario['hora']; ?></td>
						<td><?php echo $row_usuario['motivo']; ?></td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	<?php

	if ($qnt_result_pg != 0) {

	//Daqui para baixo é todo o sistema de paginação.
	$result_pg = "SELECT COUNT(id) AS num_result FROM tbregistro";
	$resultado_pg = mysqli_query($conexao, $result_pg);
	$row_pg = mysqli_fetch_assoc($resultado_pg);

	//Quantidade de pagina
	$quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);

	//Limitar os link antes depois
	$max_links = 2;

		echo '<nav aria-label="paginacao">';
		echo '<ul class="pagination justify-content-center">';
		echo '<li class="page-item">';
		echo "<span class='page-link'><a href='#' onclick='listar_usuario(1, $qnt_result_pg)'>Primeira</a> </span>";
		echo '</li>';
		for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
			if($pag_ant >= 1){
				echo "<li class='page-item'><a class='page-link' href='#' onclick='listar_usuario($pag_ant, $qnt_result_pg)'>$pag_ant </a></li>";
			}
		}
		echo '<li class="page-item active">';
		echo '<span class="page-link">';
		echo "$pagina";
		echo '</span>';
		echo '</li>';

		for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
			if($pag_dep <= $quantidade_pg){
				echo "<li class='page-item'><a class='page-link' href='#' onclick='listar_usuario($pag_dep, $qnt_result_pg)'>$pag_dep</a></li>";
			}
		}
		echo '<li class="page-item">';
		echo "<span class='page-link'><a href='#' onclick='listar_usuario($quantidade_pg, $qnt_result_pg)'>Última</a></span>";
		echo '</li>';
		echo '</ul>';
		echo '<ul class="pagination justify-content-center">';
		echo '<li class="page-item">';
		echo "<button class='page-link' onClick='window.print()'>Imprimir</button>";
		echo '</li>';
		echo '</ul>';
		echo '</nav>';
	} else{
		$quantidade_pg = 0;
	}
	}
	//Este else é caso não tenha tenhum registro na tabeela, aí vai exibir essa mensagem.
	else{
		echo "<div class='alert alert-danger' role='alert'>Nenhum aluno encontrado!</div>";
	}
}