<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//Incluir las funciones para la conexion a la base de datos
include("../funciones.php");
//Reanudamos la sesión 
@session_start();
$Con = Conectar();
//Guardar el usuario de la sesión activa
if (isset($_SESSION['user'])) {
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
  $SQL= "SELECT *
      FROM carrito_productos
      WHERE id_carrito='$cart';";
  $Resultado=Consultar($Con, $SQL);
  $items=mysqli_num_rows($Resultado);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CEIBA - Productos</title>
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
              <a href="?show=productos">Todos</a>
              <a href="?show=categorias">Categorías</a>
              <a href="?show=productores">Productores</a>
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
                  <a href="../close.php">Cerrar sesión</a>
                </div>
              </div>
            </li>';
            }
          ?>
        </ul>
      </nav>
    </header>

  <main class="main">
    <section class="products" id="products">
      <div class="search">
        <form action="" method="get" name="search">
            <input type="text" name="search" class="search-data" placeholder="Buscar" required>
            <button title="search" type="submit" class="fas fa-search"></button>
        </form>
      </div>
      <?php
      if (isset($_GET['cat'])) {
        $cat = $_GET['cat'];
        $Con = Conectar();
        //Seleccionar una columna de la tabla usuarios
        $SQL = "SELECT *
          FROM productos
          WHERE id_categoria = (
            SELECT id FROM categorias
            WHERE nombre = '$cat'
          )";
        //Hacer la consulta con el comando SQL correspondiente
        $Resultado = Consultar($Con, $SQL);
        //Guardar los datos en un arreglo
        $n = mysqli_num_rows($Resultado);
        //Si hubo un resultado
        if ($n >= 1) {
          echo '<ul class="cards">';
          //Guardar los datos en un arreglo
          for ($f = 0; $f < $n; $f++) {
            $productos = mysqli_fetch_row($Resultado);
            echo '
            <li class="card">
              <img src="../imgs/' . $productos[4] . '" alt="Imagen ' . $productos[0] . '">
              <h3>' . $productos[1] . '</h3>
              <p>' . $productos[2] . '</p>
              <p>$' . $productos[5] . '</p>
              <a class="btn" href="?id=' . $productos[0] . '">Ver producto</a>
            </li>';
          }
          echo '</ul>';
        } else {
          echo '<h2>No hay productos</h2>';
        }
      } elseif (isset($_GET['id'])) {
        $product = $_GET['id'];
        $Con = Conectar();
        $SQL = "SELECT *
          FROM productos
          WHERE id = '$product'";
        //Hacer la consulta con el comando SQL correspondiente
        $Resultado = Consultar($Con, $SQL);
        //Guardar los datos en un arreglo
        $n = mysqli_num_rows($Resultado);
        //Si hubo un resultado
        if ($n == 1) {
          //Guardar los datos en un arreglo
          $producto = mysqli_fetch_row($Resultado);
          $productor_id = $producto[8];
          $SQL = "SELECT empresa
          FROM productores
          WHERE id = '$productor_id';";
          //Hacer la consulta con el comando SQL correspondiente
          $Resultado = Consultar($Con, $SQL);
          $productor = mysqli_fetch_row($Resultado);
          echo '
            <div class="product">
              <div class="images">
                <img src="../imgs/' . $producto[4] . '" alt="Imagen ' . $producto[0] . '">
              </div>
              <div class="details">
                <a href="?productor=' . $productor_id . '">' . $productor[0] . '</a>
                <h2>' . $producto[1] . '</h2>
                <p>' . $producto[2] . '</p>
                <h3>$' . $producto[5] . '</h3>
                <form method="get" name="addCart" action="addCart.php">
                  <div class="quantity">
                    <p>Cantidad</p>
                    <input type="number" name="quantity" value="1" min="0" max="' . $producto[6] . '">
                  </div>
                  <p>Disponibles: ' . $producto[6] . '</p>
                  <input type="hidden" name="product" value="'.$producto[0].'">
                  <button class="btn" type="submit" name="addCart">Agregar al carrito</button>
                </form>
              </div>
            </div>';
        }else {
          echo '<h2>No existe este producto</h2>';
        }
      } elseif (isset($_GET['show'])) {
        $filter = $_GET['show'];
        if($filter == 'categorias'){
          echo '<h1>Todas las categorías</h1>
        <p>Encuentra rápidamente y fácilmente los productos que necesitas de cada categoría.</p>
        <ul class="cards">
          <li class="card">
            <img src="../imgs/meat.webp" alt="Imagen carne">
            <h3>Carnes</h3>
            <p>La mejor carne</p>
            <a class="btn" href="?cat=carnes">Ver productos</a>
          </li>
          <li class="card">
            <img src="../imgs/leche.webp" alt="Imagen leche">
            <h3>Bebidas</h3>
            <p>La mejor bebida</p>
            <a class="btn" href="?cat=bebidas">Ver productos</a>
          </li>
        </ul>';
        }elseif($filter=='productos'){
          $SQL = "SELECT *
          FROM productos";
          //Hacer la consulta con el comando SQL correspondiente
          $Resultado = Consultar($Con, $SQL);
          //Guardar los datos en un arreglo
          $n = mysqli_num_rows($Resultado);
          //Si hubo un resultado
          if ($n >= 1) {
            echo '<h1>Todos los productos</h1>
            <p>Explora nuestro amplio catálogo de productos.</p>
            <ul class="cards">';
            //Guardar los datos en un arreglo
            for ($f = 0; $f < $n; $f++) {
              $productos = mysqli_fetch_row($Resultado);
              echo '
              <li class="card">
                <img src="../imgs/' . $productos[4] . '" alt="Imagen ' . $productos[0] . '">
                <h3>' . $productos[1] . '</h3>
                <p>' . $productos[2] . '</p>
                <p>$' . $productos[5] . '</p>
                <a class="btn" href="?id=' . $productos[0] . '">Ver producto</a>
              </li> ';
            }
            echo '</ul>';
          } else {
            echo '<h2>No hay productos</h2>';
          }
        }elseif($filter=='productores'){
          $SQL = "SELECT *
          FROM productores";
          //Hacer la consulta con el comando SQL correspondiente
          $Resultado = Consultar($Con, $SQL);
          //Guardar los datos en un arreglo
          $n = mysqli_num_rows($Resultado);
          //Si hubo un resultado
          if ($n >= 1) {
            echo '<h1>Todos los productores</h1>
            <p>Conoce a todos nuestros productores.</p>
            <ul class="cards">';
            //Guardar los datos en un arreglo
            for ($f = 0; $f < $n; $f++) {
              $productor = mysqli_fetch_row($Resultado);
              echo '
              <li class="card">
                <img src="../imgs/'.$productor[6].'" alt="Imagen ' . $productor[0] . '">
                <h3>' . $productor[1] . '</h3>
                <p>Teléfono: ' . $productor[2] . '</p>
                <p>Email: ' . $productor[3] . '</p>
                <a class="btn" href="?productor=' . $productor[0] . '">Ver productos</a>
              </li>';
            }
            echo '</ul>';
          } else {
            echo '<h2>No hay productores</h2>';
          }
        }
      }elseif(isset($_GET['productor'])){
        $productor = $_GET['productor'];
        $SQL = "SELECT *
        FROM productos WHERE id_productor='$productor'";
        //Hacer la consulta con el comando SQL correspondiente
        $Resultado = Consultar($Con, $SQL);
        //Guardar los datos en un arreglo
        $n = mysqli_num_rows($Resultado);
        //Si hubo un resultado
        if ($n >= 1) {
          
          echo '<ul class="cards">';
          //Guardar los datos en un arreglo
          for ($f = 0; $f < $n; $f++) {
            $productos = mysqli_fetch_row($Resultado);
            echo '
            <li class="card">
              <img src="../imgs/'.$productos[4].'" alt="Imagen ' . $productos[0] . '">
              <h3>' . $productos[1] . '</h3>
              <p>' . $productos[2] . '</p>
              <p>$' . $productos[5] . '</p>
              <a class="btn" href="?id=' . $productos[0] . '">Ver productos</a>
            </li>';
          }
          echo '</ul>';
        } else {
          echo '<h2>No hay productores</h2>';
        }
      }elseif(isset($_GET['search'])){
        $search = $_GET['search'];
        $SQL = "SELECT *
          FROM productos 
          WHERE nombre LIKE '%$search%' 
          OR descripcion LIKE '%$search%'";
          //Hacer la consulta con el comando SQL correspondiente
          $Resultado = Consultar($Con, $SQL);
          //Guardar los datos en un arreglo
          $n = mysqli_num_rows($Resultado);
          //Si hubo un resultado
          if ($n >= 1) {
            echo '<ul class="cards">';
            //Guardar los datos en un arreglo
            for ($f = 0; $f < $n; $f++) {
              $productos = mysqli_fetch_row($Resultado);
              echo '
              <li class="card">
                <img src="../imgs/' . $productos[4] . '" alt="Imagen ' . $productos[0] . '">
                <h3>' . $productos[1] . '</h3>
                <p>' . $productos[2] . '</p>
                <p>$' . $productos[5] . '</p>
                <a class="btn" href="?id=' . $productos[0] . '">Ver producto</a>
              </li> ';
            }
            echo '</ul>';
          } else {
            echo '<h2>No hay productos</h2>';
          }
      }
      else{
        $SQL = "SELECT *
          FROM productos";
          //Hacer la consulta con el comando SQL correspondiente
          $Resultado = Consultar($Con, $SQL);
          //Guardar los datos en un arreglo
          $n = mysqli_num_rows($Resultado);
          //Si hubo un resultado
          if ($n >= 1) {
            echo '<ul class="cards">';
            //Guardar los datos en un arreglo
            for ($f = 0; $f < $n; $f++) {
              $productos = mysqli_fetch_row($Resultado);
              echo '
              <li class="card">
                <img src="../imgs/' . $productos[4] . '" alt="Imagen ' . $productos[0] . '">
                <h3>' . $productos[1] . '</h3>
                <p>' . $productos[2] . '</p>
                <p>$' . $productos[5] . '</p>
                <a class="btn" href="?id=' . $productos[0] . '">Ver producto</a>
              </li> ';
            }
            echo '</ul>';
          } else {
            echo '<h2>No hay productos</h2>';
          }
      }
      ?>

    </section>

    <section class="contact" id="contact">
      <h2>Contacto</h2>
      <p>¿Tienes alguna pregunta o comentario? ¡Contáctanos y estaremos encantados de ayudarte!</p>
      <div class="row">
        <div class="col information">
          <div class="social-icons">
            <h3>Redes Sociales</h3>
            <a title="Facebook" href="#facebook"><i class="fa-brands fa-square-facebook fa-xl"></i></a>
            <a title="Twitter" href="#twitter"><i class="fa-brands fa-square-twitter fa-xl"></i></a>
            <a title="LinkedIn" href="#linkedin"><i class="fa-brands fa-linkedin fa-xl"></i></a>
            <a title="Email" href="#email"><i class="fa-solid fa-envelope fa-xl"></i></i></a>
          </div>
        </div>
        <div class="col form">
          <form>
            <h3>Déjanos un mensaje</h3>
            <input type="text" placeholder="Nombre*" required>
            <input type="email" placeholder="Correo*" required>
            <textarea placeholder="Mensaje*" required></textarea>
            <button id="submit" type="submit">Enviar mensaje</button>
          </form>
        </div>
      </div>
    </section>
  </main>
  <footer>
    <div>
      <span>Soluciones Dinámicas © 2023</span>
      <span class="link">
      </span>
    </div>
  </footer>
  <script src="https://unpkg.com/scrollreveal"></script>
  <script src="scripts.js"></script>
</body>

</html>