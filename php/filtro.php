<?php
//Incluindo a conexão do PHP.
include_once("conexao.php");


//Vai puxar da tabela tbregistro e vai incluir no sistema de consulta.
$result_usuario = "SELECT * FROM tbregistro ORDER BY data DESC , hora DESC";
$resultado_usuario = mysqli_query($conexao, $result_usuario);


//Verificar se encontrou resultado na tabela "tbregistro"
 if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
	?>

	<script>
		function limparFiltro(elemento){
			elemento.value = "";
		}
	</script>

	<!--Tabela que conterá os registros da tabela tbregistro -->
	<table class="table table-striped table-bordered table-hover float-lg-start table-light">
	<nav aria-label="paginacao">
	<ul class="pagination justify-content-center">
	<li class="page-item">
	<button class='page-link' onClick='window.print()'>Imprimir</button>
	</li>
	</ul>
	</nav>
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
			

			/*if(!empty($_POST)){
				$result_usuario .= "WHERE (1=1) ";
				if($_POST["filtro_rm"]!=""){
					$rm = $_POST["filtro_rm"];
					$result_usuario .= " AND filtro_rm LIKE '%$rm%' ";
				}
			}*/
			?>

		</tbody>
	</table>
	
<?php
	echo '';
}

//Este else é caso não tenha tenhum registro na tabeela, aí vai exibir essa mensagem.
else{
	echo "<div class='alert alert-danger' role='alert'>Nenhum aluno encontrado!</div>";
}