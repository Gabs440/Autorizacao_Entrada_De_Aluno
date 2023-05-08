<?php
//DEFINIÇÕES PADRÃO
    define('HOST' , "localhost");
    define('USUARIO' , "root");
    define('SENHA' , "");
    define('DB' , "bdauto"); 

//TESTE DE CONEXÃO
$conexao = mysqli_connect(HOST , USUARIO , SENHA , DB ) or die ('<p style=" font-size: 8vh;
align: center;
margin: 20vh 0 0 35vh;
font-family: Arial;
color: #d15757;">Não foi possível realizar a conexão com o Banco de Dados!</p>');
?>