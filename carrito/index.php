<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1

//Incluir las funciones para la conexion a la base de datos
include '../funciones.php';

@session_start();

$Con = Conectar();
if (isset($_SESSION['user'])) {
  $id = $_SESSION['id'];
  $user = $_SESSION['user'];
  $tipo = $_SESSION['tipo'];
  $cart = $_SESSION['cart'];
  //Seleccionar una columna de la tabla usuarios
  $SQL = "SELECT *
      FROM $tipo
      WHERE email='$user';";
  //Hacer la consulta con el comando SQL correspondiente
  $Resultado = Consultar($Con, $SQL);
  //Guardar los datos en un arreglo
  $fila = mysqli_fetch_row($Resultado);
  $name = $fila[1];
  $id = $fila[0];
  $SQL = "SELECT *
      FROM carrito_productos
      WHERE id_carrito='$cart';";
  $Resultado = Consultar($Con, $SQL);
  $items = mysqli_num_rows($Resultado);
}
if (isset($_SESSION['Bandera'])) {
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CEIBA - Carrito</title>
    <link rel="icon" href="../imgs/Ceiba.jpeg">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  </head>
  <body>
  <header>
      <nav class="navbar">
        <h2 class="logo"><a href="../"><img src="../imgs/Ceiba.webp" alt="Logo CEIBA" /></a></h2>
        <div class="social-nav">
          <a title="Facebook" href="#facebook"><i class="fa-brands fa-square-facebook fa-lg"></i></a>
          <a title="Twitter" href="#twitter"><i class="fa-brands fa-square-twitter fa-lg"></i></a>
          <a title="LinkedIn" href="#linkedin"><i class="fa-brands fa-linkedin fa-lg"></i></a>
          <a title="Email" href="#email"><i class="fa-solid fa-envelope fa-lg"></i></a>
        </div>
        <input title="menu" type="checkbox" id="menu-toggler">
        <label for="menu-toggler" id="hamburger-btn">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" width="24px" height="24px">
            <path d="M0 0h24v24H0z" fill="none"/>
            <path d="M3 18h18v-2H3v2zm0-5h18V11H3v2zm0-7v2h18V6H3z"/>
          </svg>
        </label>
        <ul class="all-links">
          <li><a href="#home" class="active">Inicio</a></li>
          <li><a href="#about">Nosotros</a></li>
          <li><div class="dropdown">
            <a href="#products">Productos <i class="fa-solid fa-sort-down"></i>
            </a>
            <div class="dropdown-content">
              <a href="../productos/?show=productos">Todos</a>
              <a href="../productos/?show=categorias">Categorías</a>
              <a href="../productos/?show=productores">Productores</a>
            </div>
          </div></li>
          <li><a href="#contact">Contacto</a></li>
          <?php
          if(!isset($_SESSION["Bandera"]))
            { 
              echo '<li><a href="../login" class="btn">Inicia Sesión</a></li>';
            } else {
              if($tipo==='usuarios'){
              echo '<li><a href="../carrito"><i class="fa-solid fa-cart-shopping"><sup>' . $items . '</sup></i> Carrito</a></li>
              <li>';
              }
              echo '
              <div class="dropdown">
                <a class="btn profile"><i class="fa-solid fa-circle-user fa-xl"></i> ' . $name . ' <i class="fa-solid fa-sort-down"></i>
                </a>
                <div class="dropdown-content">
                  <a href="../perfil/?tab=informacion">Perfil</a>
                  <a href="../perfil/?tab=pedidos">Pedidos</a>
                  <a href="close.php">Cerrar sesión</a>
                </div>
              </div>
            </li>';
            }
          ?>
        </ul>
      </nav>
    </header>
    <main class="main">
      <section class="cart">
        <form action="buy.php" method="post" name="buy">
          <h2 class="title">Carrito</h2>
          <?php
          if ($items >= 1) {
            $total = 0;
            echo '<table>
                        <thead>
                            <tr>
                                <td colspan="2">Producto</td>
                                <td>Precio</td>
                                <td>Cantidad</td>
                                <td>Total</td>
                            </tr>
                        </thead>
                        <tbody>
                        ';
            for ($f = 0; $f < $items; $f++) {
              $cart_products = mysqli_fetch_row($Resultado);
              $cart_id = $cart_products[0];
              $product_id = $cart_products[2];
              $SQL = "SELECT *
                    FROM productos
                    WHERE id='$product_id';";
              $products = Consultar($Con, $SQL);
              $product = mysqli_fetch_row($products);
              $product_name = $product[1];
              $product_img = $product[4];
              $product_price = $product[5];
              $product_max = $product[6];
              $quantity = $cart_products[3];
              $product_total = $product_price * $quantity;
              $total = $total + $product_total;
              echo '<tr>
                                <td class="img">
                                    <a href="../productos/?id=' . $product_id . '">
                                        <img src="../imgs/' . $product_img . '" width="50" height="50" alt="' . $product_name . '">
                                    </a>
                                </td>
                                <td>
                                    <a href="../productos/?id=' . $product_id . '">' . $product_name . '</a>
                                    <br>
                                    <a href="remove.php?id=' . $cart_id . '" class="remove"><i class="fa-solid fa-trash"></i>Quitar</a>
                                </td>
                                <td class="price">&dollar;' . $product_price . '</td>
                                <td class="quantity">
                                    <input type="number" method="get" id="quantity" name="quantity" value="' . $quantity . '" min="1" max="' . $product_max . '" required>
                                </td>
                                <td class="price">&dollar;' . $product_total . '</td>
                            </tr>';
            }
            echo '</tbody>
                </table>
              <label for="tipo"> Canasta?</label>
              <input id="tipo" name="tipo" value="1" checked="" class="check" type="checkbox">
              <div class="subtotal">
                  <span class="text">Subtotal</span>
                  <span class="price">&dollar;' . $total . '</span>
              </div>
              <div class="buttons">
                  <a href="../productos" class="btn-2">Volver</a>
                  <button type="submit" name="buy" class="btn" >Comprar</button>
              </div>';
          } else {
            echo '<h2>Vacio</h2><br>
                    <i class="fa-solid fa-cart-shopping fa-2xl"></i>
                    <a href="../productos" class="btn-2">Volver</a>';
          }
          Desconectar($Con);
          ?>
        </form>
      </section>
    </main>
    <footer>
      <div>
        <span>Copyright © 2023</span>
        <span class="link">
        </span>
      </div>
    </footer>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="scripts.js"></script>
  </body>

  </html>
  <?php
} else {
  header("Location: ../login");
}
?>