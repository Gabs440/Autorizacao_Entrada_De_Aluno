<?php
//Incluindo a conexão do PHP.
include_once("conexao.php");


//Este bloco é responsável pelo sistema de paginação
$pagina = filter_input(INPUT_POST, 'pagina', FILTER_SANITIZE_NUMBER_INT);
$qnt_result_pg = filter_input(INPUT_POST, 'qnt_result_pg', FILTER_SANITIZE_NUMBER_INT);
//calcular o inicio visualização
$inicio = ($pagina * $qnt_result_pg) - $qnt_result_pg;


//Vai puxar da tabela tbregistro e vai incluir no sistema de consulta.
$result_usuario = "SELECT * FROM tbregistro ORDER BY data DESC , hora DESC LIMIT $inicio, $qnt_result_pg";
$resultado_usuario = mysqli_query($conexao, $result_usuario);



//Verificar se encontrou resultado na tabela "tbregistro"
 if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
	?>

	<script>
		function limparFiltro(elemento){
			elemento.value = "";
		}
	</script>

	
	<!--botão de filtro de registros. STATUS: NÃO FUNCIONANDO O SISTEMA DE FILTRAGEM.-->
	<div>
		<button class="button-filtrar">Filtrar</button>
	</div>


	<!--Tabela que conterá os registros da tabela tbregistro -->
	<table class="table table-striped table-bordered table-hover float-lg-start">
		<thead>
			<!--Esta é a primeira Linha da coluna, nela apresenta o nome da coluna e o campo para filtragem-->
			<tr>
				<th class="flex-container">RM 
					<div>
						<input type="text" name="filtro_rm" value="Filtrar" onclick="limparFiltro(this)" class="filtro-opaco">
					</div>
				</th>
				
				<th class="flex-container">Aluno
					<div>
						<input type="text" id="filtro-aluno" value="Filtrar" onclick="limparFiltro(this)" class="filtro-opaco">
					</div>
				</th>
				<th>Turma
					<div>
						<select id="filtro-turma" value="Filtrar" class="filtro-opaco">
							<option value="">Todos</option>
							<option value="1°A">1°A</option>
							<option value="1°B">1°B</option>
							<option value="1°C">1°C</option>
							<option value="1°D">1°D</option>
							<option value="1°E">1°E</option>
							<option value="1°F">1°F</option>
							<option value="1°I">1°I</option>
							<option value="1°K">1°K</option>
							<option value="1°L">1°L</option>
							<option value="1°M">1°M</option>

							<option value="2°A">2°A</option>
							<option value="2°B">2°B</option>
							<option value="2°C">2°C</option>
							<option value="2°D">2°D</option>
							<option value="2°E">2°E</option>
							<option value="2°F">2°F</option>
							<option value="2°I">2°I</option>
							<option value="2°K">2°K</option>
							<option value="2°L">2°L</option>
							<option value="2°M">2°M</option>

							<option value="3°A">3°A</option>
							<option value="3°B">3°B</option>
							<option value="3°C">3°C</option>
							<option value="3°D">3°D</option>
							<option value="3°E">3°E</option>
							<option value="3°F">3°F</option>
							<option value="3°I">3°I</option>
							<option value="3°K">3°K</option>
							<option value="3°L">3°L</option>
							<option value="3°M">3°M</option>
						</select>
					</div>
				</th>
                <th>Data de Atraso
					<div>
						<input type="date" id="filtro-data" class="filtro-opaco">
					</div>
				</th>
				<th>Horário de Entrada
					<div>
						<input type="time" id="filtro-hora" class="filtro-opaco">
					</div>
				</th>
                <th>Motivo
					<div>
						<select id="filtro-motivo" class="filtro-opaco">
							<option values="">Todos</option>
							<option values="Médico">Médico</option>
							<option values="Transporte">Transporte</option>
							<option values="Pessoaç">Pessoal</option>
						</select>
					</div>
					
				</th>
			</tr>
		</thead>
		<tbody>
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
			<?
			if(!empty($_POST)){
				$result_usuario .= "WHERE (1=1) ";
				if($_POST["filtro_rm"]!=""){
					$rm = $_POST["filtro_rm"];
					$result_usuario .= " AND filtro_rm LIKE '%$rm%' ";
				}
			}
			?>

			
		</tbody>
	</table>
	
<?php


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
	echo '</nav>';
}

//Este else é caso não tenha tenhum registro na tabeela, aí vai exibir essa mensagem.
else{
	echo "<div class='alert alert-danger' role='alert'>Nenhum aluno encontrado!</div>";
}