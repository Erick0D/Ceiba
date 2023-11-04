<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//Incluir las funciones para la conexion a la base de datos
include("../funciones.php");
function addCart($product, $quantity)
{
    @session_start();
    $Con = Conectar();
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        $tipo = $_SESSION['tipo'];
        $cart = $_SESSION['cart'];
        $SQL = "SELECT * FROM carrito_productos WHERE id_carrito='$cart' AND id_producto='$product';";
        $ResultadoCarrito = Consultar($Con, $SQL);
        $n = mysqli_num_rows($ResultadoCarrito);
        $products = mysqli_fetch_row($ResultadoCarrito);
        if ($n >= 1) {
            $product_id = $products[2];
            $SQL = "SELECT cantidad FROM productos WHERE id='$product_id';";
            $CantidadProducto = Consultar($Con, $SQL);
            $product_quantity = mysqli_fetch_row($CantidadProducto);
            $product_max = $product_quantity[0];
            $SQL = "SELECT cantidad FROM carrito_productos WHERE id_carrito='$cart' AND id_producto='$product_id';";
            $CantidadCarrito = Consultar($Con, $SQL);
            $cart_quantity = mysqli_fetch_row($CantidadCarrito);
            $total_quantity = $quantity + $cart_quantity[0];
            if ($total_quantity >= $product_max) {
                $total_quantity = $product_max;
            }
            $SQL = "UPDATE carrito_productos SET cantidad = $total_quantity  
            WHERE id_carrito='$cart' AND id_producto='$product';";
            $Resultado = Consultar($Con, $SQL);
            if ($Resultado == 1) {
                header("Location: ../carrito");
            } else {
                echo "<script>
                alert('Error!');
                </script>";
            }
        } else {
            $SQL = "INSERT INTO carrito_productos (id_carrito, id_producto, cantidad) VALUES ('$cart','$product','$quantity')";
            $Resultado = Consultar($Con, $SQL);
            if ($Resultado == 1) {
                header("Location: ../carrito");
            } else {
                echo "<script>
                alert('Error!');
                </script>";
            }
        }
    } else {
        header("Location: ../login");
    }
}
$product = $_GET['product'];
$quantity = $_GET['quantity'];
// Obtener el carrito de compras de la sesión
addCart($product, $quantity);

?>