<?php
// CAMADA DE CONEXÃO
include_once("conexao.php");

$RM         = $_POST['RM'];
$nomealuno  = $_POST['nomealuno'];
$serie      = $_POST['serie'];
$curso      = $_POST['curso'];
$serie_curso= $serie . "" . $curso;
$motivo     = isset($_POST['motivo']) ? $_POST['motivo'] : (isset($_POST['outro_motivo']) ? $_POST['outro_motivo'] : '');

//INSERÇÃO DOS REGISTROS QUE O USUÁRIO PREENCHEU NO INDEX
$sql = "INSERT INTO tbregistro (RM, nomealuno, serie_curso, motivo) VALUES";
$sql .= " ('$RM', '$nomealuno', '$serie_curso', '$motivo')";
 

/* EFUTA CONEXÃO COM O BANCO*/
if(mysqli_query($conexao, $sql)) {
    mysqli_close($conexao);
    $mensagem = '<p>Registro efetuado com sucesso!</p>';
} else {
    mysqli_close($conexao);
    $mensagem = '<p>Erro ao tentar cadastrar registro!</p>';
}

//SISTEMA DE VAI ENVIAR PARA O ARQUIVO DE INDEX E EXIBIR A MENSAGEM NA DIV COM NOME MENSAGEM.
echo json_encode(array("mensagem" => $mensagem));

?>