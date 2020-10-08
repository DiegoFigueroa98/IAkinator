<!DOCTYPE html>
<html lang="en">

	<head>
		<title>IA-kinator</title>
		<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/registry.css">
	</head>

	<body>
		<main class="registry-main-wrapper">
			<section class="registry-question-card">
				<article class="registry-question-card__header">
					<h2>IA-kinator</h2>
				</article>
				<article class="registry-question-card__body">

					<?php
					require "conexion.php";

					$respuesta = $_GET["r"];
					$nodo = $_GET["n"];
					$nombreAnterior = $_GET["p"];
					$numPregunta = $_GET["np"];

					function formularioRespuesta($n,$p){
						
						echo "<form action='crear.php' class='registry-form' id='formulario' method='POST'>";
							echo "<textarea id='nodo' name='nodo' form='formulario' placeholder='nombre' style='display:none;'>".$n."</textarea>";
							echo "<textarea id='nombreAnterior' name='nombreAnterior' form='formulario' placeholder='nombre' style='display:none;'>".$p."</textarea>";
									
							echo "<div class='registry-question-title'>";
								echo "<h2>¿En qué animal habías pensado?</h2>";
								echo "<input type='text' name='nombre' id='nombre' placeholder='Nombre del animal' class='registry-question-input' required>";
							echo "</div>";
							
							echo "<div class='registry-question-title'>";
								echo "<h2>¿Qué característica tiene este animal que no tenga  <span>".$p." </span>?</h2>";
								echo "<input type='text' name='caracteristicas' id='caracteristicas' placeholder='Caracteristica del animal' class='registry-question-input' required>";
							echo "</div>";

							echo "<div class='registry-answers-wrapper'>";
								echo "<button class='registry-answer-button' type='submit' name='ENVIAR'>Enviar</button>";
							echo "</div>";
						echo "</form>";
						
						
					}
					//----------------------------------------------


					//SI HA FALLADO
					if($respuesta == 0){
						
						session_start();			//iniciamos la sesión
						$nodosRepuesto =array();	//creamos el array
						
						//COMPROBAMOS SI EXISTE LA VARIABLE DE SESIÓN (ES DECIR, SI HEMOS GUARDADO ALGÚN NODO EN EL QUE DUDÁSEMOS)
						if(isset($_SESSION['nodosRepuesto'])){
							$nodosRepuesto = $_SESSION['nodosRepuesto'];
							$tamano = count($nodosRepuesto);			//medimos la longitud del array
							
							
							if($tamano != 0){
								//SI HAY ELEMENTOS EN EL ARRAY QUE PODAMOS USAR
								
								$nodoRevisar = array_pop($nodosRepuesto);	//obtenemos el último elemento del nodo y lo desapilamos
								$_SESSION['nodosRepuesto']=$nodosRepuesto;  //actualizamos el array con los valores nuevos
							
								header("Location:index.php?n=".$nodoRevisar."&r=0&np=".$numPregunta."");	//volvemos automáticamente al nodo
							
							}
							
							else{
								//SI EL ARRAY CON NODOS DE REPUESTO ESTÁ VACÍO
								formularioRespuesta($nodo,$nombreAnterior);
							}
							
						}
						
						else{
							//SI NO HAY VARIABLE DE SESIÓN
							formularioRespuesta($nodo,$nombreAnterior);
						}

					}

					//SI HA ACERTADO
					else{
						
						//--------------------------------------------------------
						//GUARDAMOS EL ACIERTO EN EL LOG DE LA BD (TABLA PARTIDA)
						
						$consulta = "INSERT INTO partida (personaje,acierto) VALUES('".$nombreAnterior."',TRUE);";
						mysqli_query($enlace, $consulta);
						
						
						//-----------------------------------------------------
						//BORRAMOS LA VARIABLE DE SESIÓN CON EL ARRAY
						session_start();		//iniciamos la sesión
						$arrayVacio =array();	
						
						if(isset($_SESSION['nodosRepuesto'])){
							$_SESSION['nodosRepuesto']=$arrayVacio;
						}
						//-----------------------------------------------------
						
						echo "<h2>¡GRACIAS POR JUGAR A IA-kinator! ;)</h2>";
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

