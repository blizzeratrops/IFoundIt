<?php 
require_once('busqueda.php');
require_once('user.php');

if( isset($_GET['buscar']) )
{
    //be sure to validate and clean your variables
    $texto = htmlentities($_GET['busqueda']);
    //then you can use them in a PHP function. 
	$search_results = search($texto);
	if ($search_results) {
		echo "<table>";
			echo "<tr>";
				echo "<td style='border: 1px solid black; background-color:blue;'> Titulo </td>";
				echo "<td style='border: 1px solid black; background-color:blue;'> Fecha </td>";
				echo "<td style='border: 1px solid black; background-color:blue;'> Ciudad </td>";
				echo "<td style='border: 1px solid black; background-color:blue;'> Descripcion </td>";
				echo "<td style='border: 1px solid black; background-color:blue;'> Monto </td>";
				echo "<td style='border: 1px solid black; background-color:blue;'> Usuario </td>";
			echo "</tr>";

		foreach ($search_results as $row) {
			
			echo "<tr>";
				echo "<td style='border: 1px solid black;'>".$row['titulo']."</td>";
				echo "<td style='border: 1px solid black;'>".$row['fecha']."</td>";
				echo "<td style='border: 1px solid black;'>".$row['ciudad']."</td>";
				echo "<td style='border: 1px solid black;'>".$row['descripcion']."</td>";
				echo "<td style='border: 1px solid black;'>".$row['monto']."</td>";
				echo "<td style='border: 1px solid black;'>".$row['usuario']."</td>";
			echo "</tr>";
		}
		echo "</table>";
	}else{
		echo "No se encontraron resultados para su busqueda.";
	}
}
?>