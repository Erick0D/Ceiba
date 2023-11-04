<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//Incluir las funciones para la conexion a la base de datos
include("../funciones.php");
function remove($cart) {
    @session_start();
    $Con = Conectar();
    if (isset($_SESSION['user'])) {
        $SQL="DELETE FROM carrito_productos WHERE id='$cart';";
        $Resultado=Consultar($Con,$SQL);
        if($Resultado==1){
        header("Location: ../carrito");
        }else{
        echo "<script>
            alert('Error!');
            </script>";
        }
    }else{
        header("Location: ../login");
    }
}
$cart=$_GET['id'];
remove($cart)
?>