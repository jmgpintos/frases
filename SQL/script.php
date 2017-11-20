<?php
//http://www.frasesde.org/index.php

//SCRIPT constants
define('DEBUG', false);
define('DIR', '/home/tatooine/Documentos/citas_celebres/');
define('FILE_IN', 'citas.txt');
define('FILE_OUT', 'citas_out.txt');
define('FILE_DB', 'script.sql');

//DB Constants
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'kodak80');
define('DB_NAME', 'citas');

//DEBUG Constants
define('MAX_LINES_DEBUG', 1);
define('CR', PHP_EOL); //Salto de linea
define('TAB', "\t"); //Tabulador
define('SEPARATOR', CR . '-----------------' . CR);

//barra de progreso
include 'progress_bar.php';


//variables globales
$conn; $nEtiqueta=0; $nCategoria=0; $nAutor=0; $nCita=0;$tPalabras=[]; $tExcepciones=getExcepciones();

	function debug_msg(String $str, bool $always_show = FALSE) {
		if (DEBUG || $always_show) {
			if ($str != null) {
				print $str;
			}
			print CR ;
		}
	}

	function getExcepciones(){

		$preposiciones=['a','ante','bajo','cabe','con','contra','de','desde','durante','en','entre','hacia','hasta','mediante','para','por','según','sin','sobre','tras','versus','vía'];
		$tiempo = ['ayer', 'hoy', 'mañana', 'siempre', 'nunca', 'luego', 'ya', 'ahora', 'frecuentemente', 'antes'];
		$lugar = ['aquí', 'ahí', 'allí', 'allá', 'acá', 'cerca', 'lejos', 'arriba', 'abajo', 'delante', 'detrás', 'enfrente', 'encima', 'debajo', 'donde', 'antes'];
		$modo = ['así', 'bien', 'mal', 'cuidadosamente', 'mejor', 'peor', 'como'];
		$cantidad = ['mucho', 'poco', 'más', 'menos', 'bastante', 'nada', 'cuanto'];
		$afirmacion = ['sí', 'claro', 'bueno', 'obviamente', 'también'];
		$negacion = ['no', 'tampoco', 'nada', 'apenas', 'jamás', 'nunca', 'ningún'];
		$duda = ['quizá', 'probablemente', 'seguramente', 'acaso'];
		$otros = ['demás', 'inclusive', 'aún'];
		$excepciones = array_merge($preposiciones, $tiempo, $lugar, $modo, $cantidad, $afirmacion, $negacion, $afirmacion, $duda, $otros);
		//print_r($excepciones);
		return $excepciones;
	}

	function conectar(){
		$mysqli = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ($mysqli->connect_errno) {
			debug_msg("Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error, true);
			return false;
		}
		else{
			$mysqli->query("SET NAMES 'utf8'"); 
			return $mysqli;
		}
	}

	function crearDB(){
		debug_msg('Inicializando Base de Datos...', true);

		$command = 'mysql'
		. ' --host=' . DB_HOST
		. ' --user=' . DB_USER
		. ' --password=' . DB_PASS
		. ' --database=' . DB_NAME
		. ' --execute="SOURCE ' . FILE_DB . '"'
		;
		debug_msg('command: ' . $command);
		$output = shell_exec($command);
		//var_dump($output);
	}

	function poblarDB($file_in){

		$i=1;
		$handle = fopen($file_in, "r");
		$frases = [];
		$lines = count(file($file_in)) - 1;

		if ($handle) {
			debug_msg('Poblando Base de Datos...', true);
			while (($line = fgets($handle)) !== false) {
				debug_msg($i.": ".$line);

				if(strlen($line) > 1){
					$i++;

					preg_match('@^(.*)\((.*)\) \- (.*)@i',$line, $frase);
					if(count($frase)){
						$id_categoria = tratar_categoria($frase[3]);

						$id_autor = tratar_autor(trim($frase[2]));
						tratar_frase($frase[1], $id_autor, $id_categoria);
						if(!DEBUG){
							show_status($i, $lines, 30);
						}
						debug_msg(SEPARATOR);
					}

					if(DEBUG && $i > MAX_LINES_DEBUG) {
						break;
					}
				}
				else{
					debug_msg('LINE_VACIA');
				}

			}

			fclose($handle);
			return true;
		} else {
			debug_msg("error opening the file.", true);
			return false;
		} 
	}

	function tratar_etiqueta($etiqueta) {
		global $conn, $nEtiqueta;

		//Mirar si existe etiqueta
		$etiqueta = $conn->real_escape_string($etiqueta);
		$sql = "SELECT id FROM etiqueta WHERE texto = '".$etiqueta."'";
		debug_msg(TAB.'sql: '.$sql);
		$resultado = $conn->query($sql);
		debug_msg(TAB.'resultado:'.$conn->affected_rows);
		//print_r($resultado);

		$existe = $conn->affected_rows;

		//Si existe, guardar id
		if($existe){
			$fetch = $resultado->fetch_assoc();
			$id_etiqueta = $fetch['id'];
		}
		else{
			//si no existe, crearla y guardar id
			$id_etiqueta = NULL;
			$sql = "INSERT INTO etiqueta(texto) VALUES('".$etiqueta."')";
			//debug_msg(TAB.'sql: '.$sql);

			if ($conn->query($sql) === TRUE) {
				$nEtiqueta++;
				debug_msg(TAB."Nueva etiqueta '".$etiqueta."'' CREADA");
				$id_etiqueta = $conn->insert_id;
			} else {
				debug_msg("Error: " . $sql . CR . $conn->error, true);
			}
			
		}

		debug_msg(TAB.'id_etiqueta: ' . $id_etiqueta);
		//devolver id de etiqueta en BD
		return $id_etiqueta;
	}

	function tratar_etiquetas($frase) {
		global $nCategoria, $tExcepciones;
		debug_msg(SEPARATOR);
		debug_msg('tratar_etiquetas - ' . $frase);

		$etiquetas = explode(" ", $frase);
		$signos = [".",",",";",":","'","\"", "(",")","-","_","{","}"];
		$tEtiquetas = [];
		debug_msg("Etiquetas: ");

		//extraer etiquetas de la frase
		foreach($etiquetas as $etiqueta){
			$etiqueta = trim(strtolower(str_replace($signos,"",$etiqueta)));
			if(mb_strlen($etiqueta) > 4 && mb_strlen($etiqueta) < 25) {//menores de 4 no nos interesan y el campo en BD es varchar(25)
				if(!in_array($etiqueta, $tExcepciones)){
					$tEtiquetas[] = $etiqueta;
				}
			}
		}

		debug_msg(implode($tEtiquetas, ","));

		//insertar etiquetas en BD
		$id_etiquetas = [];
		foreach($tEtiquetas as $etiqueta){
			$id_etiquetas[] = tratar_etiqueta($etiqueta);
		}

		return $id_etiquetas;
	}

	function tratar_categoria($categoria) {
		/*
		 * Separar etiquetas por coma (si es que vienen varias)
		 * y quedarnos con la primera
		 */
		global $conn, $nCategoria;
		//debug_msg(TAB.'CATEGORIA: '.$categoria);
		$a_categoria = explode ( "," , $categoria );
		$categoria = mb_strtolower(trim($a_categoria[0]));
		$categoria = $conn ->real_escape_string($categoria);


		//Mirar si existe categoria
		$sql = "SELECT id FROM categoria WHERE nombre = '".$categoria."'";
		//debug_msg(TAB.'sql: '.$sql);
		$resultado = $conn->query($sql);
		//debug_msg(TAB.'resultado:'.$conn->affected_rows);
		//print_r($resultado);

		$existe = $conn->affected_rows;

		//Si existe, guardar id
		if($existe){
			$fetch = $resultado->fetch_assoc();
			$id_categoria = $fetch['id'];
		}
		else{
			//si no existe, crearla y guardar id
			$id_categoria = NULL;
			$sql = "INSERT INTO categoria(nombre) VALUES('".$categoria."')";
			//debug_msg(TAB.'sql: '.$sql);

			if ($conn->query($sql) === TRUE) {
				$nCategoria++;
				//debug_msg(TAB."Nueva categoria ".$categoria." CREADA");
				$id_categoria = $conn->insert_id;
			} else {
				debug_msg("Error: " . $sql . CR . $conn->error, true);
			}
			
		}

		//devolver id de categoria
		return $id_categoria;
	}

	function tratar_autor($autor) {
		/*
		 * Insertar autor en BD (si no existe)
		 */
		global $conn, $nAutor;
		//debug_msg(SEPARATOR);
		//debug_msg(TAB.'AUTOR: '.$autor);
		$autor = $conn->real_escape_string($autor);
		if(strpos($autor, ",")){
			$autor = substr($autor, 0, strpos($autor, ","));//cortar el nombre en la primera coma
		}

		//debug_msg(TAB.'AUTOR: '.$autor);
		$sql = "SELECT id FROM autor WHERE nombre = '".$autor."'";
		//debug_msg(TAB.'sql: '.$sql);
		$resultado = $conn->query($sql);
		//debug_msg(TAB.'resultado:'.$conn->affected_rows);
		$existe = $conn->affected_rows;
		if($existe){
			$fetch = $resultado->fetch_assoc();
			$id_autor = $fetch['id'];
		}
		else{
			$id_autor = NULL;
			$sql = "INSERT INTO autor(nombre) VALUES('".$autor."')";
			//debug_msg(TAB.'sql: '.$sql);
			if ($conn->query($sql) === TRUE) {
				$nAutor++;
				//debug_msg(TAB."Nuevo autor ".$autor." CREADO");
				$id_autor = $conn->insert_id;
			} else {
				debug_msg("Error: " . $sql . CR . $conn->error, true);
			}

		}
		//debug_msg(TAB.'id_autor: ' . $id_autor);
		//devolver id del autor en BD
		return $id_autor;
	}

	function tratar_frase($frase, $id_autor, $id_categoria) {
		/*
		 * Insertar frase en BD y actualizar tabla frases_etiquetas
		 */
		global $conn, $nCita, $tPalabras;
		//debug_msg(TAB.'FRASE: '.$frase);
		//debug_msg(TAB.'etiquetas:');
		//print_r($id_etiquetas);
		$safe_frase = $conn->real_escape_string($frase);
		$sql = "INSERT INTO cita(frase, id_autor, id_categoria) VALUES('$safe_frase', $id_autor, $id_categoria)";
		//debug_msg(TAB.'sql: '.$sql);
		if ($conn->query($sql) === TRUE) {
			$nCita++;
			//debug_msg(TAB."Nueva cita CREADA");
			$id_cita = $conn->insert_id;

			$id_etiquetas = tratar_etiquetas($frase); //Hay que enviar la clase original para que no tenga caracteres de escape
			foreach ($id_etiquetas as $id_etiqueta) {				
				$sql = "INSERT INTO cita_etiqueta(id_cita, id_etiqueta) VALUES($id_cita, $id_etiqueta)";
				//debug_msg(TAB.'sql: '.$sql);
				$conn->query($sql);
			}

		} else {
			debug_msg("Error: " . $sql . CR . $conn->error, true);
		}
	}

	function mostrar_resumen(){
		global $nCita, $nAutor, $nCategoria,$nEtiqueta,$tPalabras;
		debug_msg(SEPARATOR, true);
		debug_msg("Categorías insertadas: ". $nCategoria, true);
		debug_msg("Autores insertados: ". $nAutor, true);
		debug_msg("Citas insertadas: ". $nCita, true);
		debug_msg("Etiquetas insertadas: ". $nEtiqueta, true);
		//print_r($tPalabras);
	}

echo "\r";
	if(!($conn = conectar())) {
		die;
	}

	crearDB();

	$file_in = DIR.FILE_IN;
	//@TODO comprobar que el fichero existe

	if(poblarDB($file_in)) {
		mostrar_resumen();
	}



	
	
	
	
	
	
	