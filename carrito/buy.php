<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//Incluir las funciones para la conexion a la base de datos
include("../funciones.php");
@session_start();
$Con = Conectar();
if (isset($_SESSION['user'])) {
    $id_usuario = $_SESSION['id'];
    $cart = $_SESSION['cart'];
    $tipoPedido = $_POST['tipo'];
    $SQL = "SELECT * FROM carrito_productos WHERE id_carrito='$cart';";
    $ResultadoCarrito = Consultar($Con, $SQL);
    $n = mysqli_num_rows($ResultadoCarrito);
    $products = mysqli_fetch_row($ResultadoCarrito);
    $id_pedido = hexdec(uniqid());
    $date = date("Y-m-d");
    $SQL = "SELECT carrito_productos.id,carrito_productos.id_producto, carrito_productos.cantidad, productos.precio, (carrito_productos.cantidad * productos.precio) AS total 
    FROM carrito_productos JOIN productos ON carrito_productos.id_producto = productos.id 
    WHERE carrito_productos.id_carrito = '$cart';";
    $pedidos = Consultar($Con, $SQL);
    if ($n >= 1) {
        $SQL = "INSERT INTO pedidos (id, fecha, id_usuario, estatus, tipo) VALUES ('$id_pedido','$date','$id_usuario','1','$tipoPedido');";
        $crearPedido = Consultar($Con, $SQL);
        $totalPedido = 0;
        for ($f = 0; $f < $n; $f++) {
            $productos = mysqli_fetch_array($pedidos);
            $id_producto = $productos[1];
            $cantidad = $productos[2];
            $precio = $productos[4];
            $totalPedido = $productos[4] + $totalPedido;;
            $SQL = "INSERT INTO detalle_pedido (id_pedido,id_producto,cantidad,precio) VALUES ('$id_pedido','$id_producto','$cantidad','$precio');";
            $detallesPedido = Consultar($Con, $SQL);
            $SQL = "UPDATE productos SET cantidad=cantidad-$cantidad WHERE id='$id_producto';";
            $restarCantidad = Consultar($Con, $SQL);
        }
        $SQL = "UPDATE pedidos SET total=$totalPedido WHERE id = '$id_pedido';";
        $total = Consultar($Con, $SQL);
        $SQL = "DELETE FROM carrito_productos WHERE id_carrito = '$cart';";
        $borrar = Consultar($Con, $SQL);
        header("Location: ../perfil/?tab=pedidos");
        echo "<script>
        alert('Pedido realizado con éxito.');
        </script>";
        exit();
    }
} else {
    header("Location: ../login");
    exit();
}
?>