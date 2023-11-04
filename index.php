<?php
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    //Incluir las funciones para la conexion a la base de datos
    include("funciones.php");
    //Reanudamos la sesión 
    @session_start(); 
    $Con=Conectar();
    //Guardar el usuario de la sesión activa
    if(isset($_SESSION['user'])){
      $user=$_SESSION['user'];
      $tipo=$_SESSION['tipo'];
      $cart = $_SESSION['cart'];
      //Seleccionar una columna de la tabla usuarios
      $SQL= "SELECT *
      FROM $tipo
      WHERE email='$user';";
        //Hacer la consulta con el comando SQL correspondiente
      $Resultado=Consultar($Con, $SQL);
        //Guardar los datos en un arreglo
      $fila=mysqli_fetch_row($Resultado);
      $name=$fila[1];
  $SQL= "SELECT *
      FROM carrito_productos
      WHERE id_carrito= '$cart';";
  $Resultado=Consultar($Con, $SQL);
  $items=mysqli_num_rows($Resultado);
        //Desconectar
      Desconectar($Con);
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CEIBA</title>
    <link rel="icon" href="imgs/Ceiba.jpeg">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  </head>
  <body>
    <header>
      <nav class="navbar">
        <h2 class="logo"><a href="#"><img src="imgs/Ceiba.webp" alt="Logo CEIBA" /></a></h2>
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
              <a href="productos/?show=productos">Todos</a>
              <a href="productos/?show=categorias">Categorías</a>
              <a href="productos/?show=productores">Productores</a>
            </div>
          </div></li>
          <li><a href="#contact">Contacto</a></li>
          <?php
          if(!isset($_SESSION["Bandera"]))
            { 
              echo '<li><a href="login" class="btn">Inicia Sesión</a></li>';
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
      <section class="homepage" id="home">
        <div class="content">
          <div class="text">
            <h1>El arte de vivir bien</h1>
            <p>
              Compra productos orgánicos directamente de los productores. <br> Apoya a los productores locales y consigue productos orgánicos frescos y de temporada.</p>
          </div>
          <div class="homepage-btns">
            <a class="btn" href="#products">Ver Productos</a>
            <?php
           if(!isset($_SESSION["Bandera"]))
            { 
              echo '<a class="btn-2" href="registro">Regístrate</a>';
            }
          ?>
          </div>
        </div>
      </section>

      <section class="about" id="about">
        <h2>¿Quiénes somos?</h2>
        <p>En <strong>CEIBA</strong> estamos orgullosos de ofrecer una amplia selección de productos orgánicos de alta calidad a precios asequibles.</p>
        <div class="row company-info">
          <div class="row about-info">
            <h3>Historia</h3>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Enim nulla ratione laboriosam iste, quidem delectus ipsa, architecto aliquam natus doloribus voluptatum deserunt non eum reprehenderit rerum velit explicabo aliquid nemo.</p>
            <h3>Misión</h3>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugit ipsa, necessitatibus deleniti tenetur assumenda omnis aperiam? Illo dolorum quam doloribus fugiat eius totam, eveniet excepturi, autem porro necessitatibus dolore quo!</p>
            <h3>Visión</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta, doloremque sapiente nesciunt illum voluptatibus corporis laboriosam quia quam vel officiis sint recusandae tenetur dignissimos nulla! Rerum officiis eligendi iure dignissimos.</p><br>
          </div>
          <div class="about-img">
            <img src="imgs/video.gif" title="img">
          </div>
        </div>
      </section>

      <section class="products" id="products">
        <h2>Productos</h2>
        <p>Encuentra rápidamente y fácilmente los productos que necesitas de cada categoría.</p>
        <ul class="cards">
          <li class="card">
            <img src="imgs/meat.webp" alt="Imagen carne">
            <h3>Carnes</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
            <a class="btn" href="productos/?cat=carnes">Ver proveedores</a>
          </li>
          <li class="card">
            <img src="imgs/leche.webp" alt="Imagen leche">
            <h3>Bebidas</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
            <a class="btn" href="productos/?cat=bebidas">Ver proveedores</a>
          </li>
        </ul>
          <a class="btn" href="productos">
            <h4>Ver todas las categorías</h4>
          </a>
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
              <a title="Email" href="#email"><i class="fa-solid fa-envelope fa-xl"></i></a>
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