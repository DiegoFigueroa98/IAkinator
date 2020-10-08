<!DOCTYPE html>
<html lang="en">

<head>
	<title>IAkinator</title>
	<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@500;600;700;800&display=swap" rel="stylesheet"> 
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
	<main class="main-wrapper">
		<section class="question-card">
			<article class="question-card__header">
				<h2>IA-kinator</h2>
			</article>
			<article class="question-card__body">

<?php

require "conexion.php";

$nodo = 1;
$nodoRepuesto = 0;
$numPregunta = 1;
$proxPregunta = 2;

if(isset($_GET['n'])) {
	$nodo = $_GET["n"];
}

if(isset($_GET['r'])) {
	$nodoRepuesto = $_GET["r"];
}

if(isset($_GET['np'])) {
	$numPregunta = $_GET["np"];
	$proxPregunta = $numPregunta+1;
}

if($nodoRepuesto!=0){

	session_start();
	$nodosRepuesto =array();
 
	if(isset($_SESSION['nodosRepuesto'])){
		
		$nodosRepuesto = $_SESSION['nodosRepuesto'];
		array_push($nodosRepuesto,$nodoRepuesto);
		$_SESSION['nodosRepuesto']=$nodosRepuesto;
		
	}
	
	else{
		array_push($nodosRepuesto,$nodoRepuesto);
		$_SESSION['nodosRepuesto']=$nodosRepuesto;
	}
	
	
}

$nodoSi = $nodo * 2;
$nodoNo = $nodo * 2 + 1;

$nodoProbablementeSi = $nodoSi;
$nodoProbablementeNo = $nodoNo;

$aleatrio = rand(0,1);

$nodoAleatorio 	  = 0;
$nodoAleatorioAlt = 0;

if($aleatrio==0){
	$nodoAleatorio = $nodoNo;
	$nodoAleatorioAlt = $nodoSi;
}

else{
	$nodoAleatorio = $nodoSi;
	$nodoAleatorioAlt = $nodoNo;
}

$consulta = "SELECT texto,pregunta FROM arbol WHERE nodo = ".$nodo.";";

$texto = '';
$pregunta = true;
 
if ($resultado = mysqli_query($enlace, $consulta)) {
 
	if($resultado->num_rows === 0)
    {
        echo 'No existe el nodo';
    }

	else{
		while ($fila = mysqli_fetch_row($resultado)) {
			$texto 	  = $fila[0];
			$pregunta = $fila[1];
		}
		
		echo "<h2 class='question-number'>Pregunta #".$numPregunta."</h2>";
		
		if($pregunta == 0){
			
			echo "<div class='question-title'>";
			echo "<h2>¿Has pensado en <span>". $texto . "</span>?</h2>";
			echo "</div>";
			
			
			echo "<div class='answers-wrapper'>";
			echo "<a class='answer-button' href='respuesta.php?r=1&n=".$nodo."&p=".$texto."&np=".$proxPregunta."'>SÍ</a>";
			echo "<a class='answer-button' href='respuesta.php?r=0&n=".$nodo."&p=".$texto."&np=".$proxPregunta."'>NO</a>";
			echo "</div>";
		
		}
		
		else{
			echo "<div class='question-title'>";
			echo "<h2>¿Tu personaje puede/tiene <span>". $texto . "</span>?</h2>";
			echo "</div>";
			
			echo "<div class='answers-wrapper'>";
			
			echo "<a class='answer-button' href='index.php?n=".$nodoSi."&r=0&np=".$proxPregunta."'>SÍ</a>";
			echo "<a class='answer-button' href='index.php?n=".$nodoNo."&r=0&np=".$proxPregunta."'>NO</a>";
		
			echo "</div>";
		}
		
	}

    mysqli_free_result($resultado);
}

?>
				<footer class="footer">
<?php
					echo "<a href='index.php?n=1&r=0'>Volver a probar</a>";
					echo "<a href='datos.php'>Datos de IA-kinator</a>";
?>
				</footer>
			</article>
		</section>
	</main>
</body>

</html>