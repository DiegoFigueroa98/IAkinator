<?php

require "conexion.php";

$consultas = [];

array_push($consultas,"CREATE TABLE arbol (nodo INT NOT NULL, texto VARCHAR(500), pregunta BOOL, PRIMARY KEY (nodo));");
array_push($consultas,"CREATE TABLE partida (id INT NOT NULL AUTO_INCREMENT, personaje VARCHAR(500), acierto BOOL, PRIMARY KEY (id));");

array_push($consultas,"INSERT INTO arbol (nodo,texto,pregunta) VALUES(1,'Un animal registrado', FALSE);");

$tam = count($consultas);

for($a=0; $a<$tam; $a++){
	
	echo "CONSULTA: " . $a . " ";
	
	if (mysqli_query($enlace, $consultas[$a])) {
		echo "OK";
	}
	else{
		echo "ERROR";
	}
	
	echo "<br>";
}

mysqli_close($enlace);
?>
