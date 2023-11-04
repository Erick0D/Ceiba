<?php
	Function Conectar(){
		$Resultado=parse_ini_file("configuracionBD.ini");
		$Server=$Resultado['Server'];
		$User=$Resultado['User'];
		$Password=$Resultado['Password'];
		$BD=$Resultado['BD'];
		$Con=mysqli_connect($Server,$User,$Password,$BD);
		return $Con;
	}

	Function Consultar($Con,$SQL){
		$Query=mysqli_query($Con,$SQL) or die (mysqli_error($Con));
		return $Query;
	}

	Function Desconectar($Con){
		mysqli_close($Con);
	}

	
?>