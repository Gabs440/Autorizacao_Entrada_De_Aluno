

<?php
//ESTE ARQUIVO É APENAS PARA TESTAR O SISTEMA DE REGISTROS NA TABELA E TESTAR O SISTEMA DE PAGINAÇÃO 
$cont = 2;
while($cont < 200){
	echo "INSERT INTO tbregistro (RM, nomealuno, serie, curso, motivo) VALUES
	(11113, 'Gabs$cont','3°','C', 'Fiquei ruim $cont vezes'),
	(11115, 'Luiz$cont','3°','C', 'Fiquei ruim $cont vezes'),
	(11117, 'Dom$cont', '3°','C','Fiquei ruim $cont vezes'); <br>";

	$cont = $cont + 1;
}