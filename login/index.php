<?php
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    
  //Incluir las funciones para la conexion a la base de datos
  include '../funciones.php';

  if (isset($_POST['login'])) { //Iniciar una sesión con PHP
    session_start();

    //Guardar variables con los datos ingresados para iniciar sesión
    $email=$_POST['email'];
    $password=$_POST['password'];

    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $password = filter_var($password, FILTER_SANITIZE_STRING);

    //Guardar la variable de la conexión
    $Con=Conectar();

    //Seleccionar una columna de la tabla usuarios
    $SQL=("SELECT id,email,password, 'usuarios' as origen FROM usuarios WHERE email = '$email'
    UNION SELECT id,email,password, 'productores' as origen FROM productores WHERE email = '$email';");

    //Hacer la consulta con el comando SQL correspondiente
    $Resultado=Consultar($Con,$SQL);

    //Guardar una variables con el total de resultados que hubo
    $n=mysqli_num_rows($Resultado);
    //Si hubo un resultado
    if($n==1){
      //Continuar
      //Guardar los datos en un arreglo
      $Fila=mysqli_fetch_row($Resultado);
      //Si la contraseña que corresponde a ese usuario
      if($password==$Fila[2]){
        //Guardar variables de sesión
        $tipo=$Fila[3];
        $_SESSION['tipo']=$tipo;
        $id=$Fila[0];
        $_SESSION['id']=$id;
        $user=$Fila[1];
        $_SESSION['user']=$user;
        $_SESSION['Bandera']="SI";
        $SQL= "SELECT *
        FROM $tipo
        WHERE email='$user';";
        $ResultadoNombre=Consultar($Con, $SQL);
        $nombre=mysqli_fetch_row($ResultadoNombre);
        $_SESSION['name']=$nombre[1];
        $SQL=("SELECT id FROM carrito WHERE id_usuario='$Fila[0]';");
        $Resultado=Consultar($Con,$SQL);
        $cart=mysqli_fetch_row($Resultado);
        $_SESSION['cart']=$cart[0];
        echo "<script>
        alert('Inicio de sesión exitoso.');
        </script>";
        if($_SESSION['tipo']=="productores"){
          echo "<script>window.location.href='../perfil?tab=informacion';</script>";
        }else{
          echo "<script>window.location.href='../';</script>";
        }
          exit;
      }
      //Si la contraseña es incorrecta o no corresponde con el usuario
      else{
        //Notificar que los datos son incorrectos
        echo "<script>
        alert('Datos incorrectos.');
        </script>";
        header('Location: ../login');
      }
    }
    //Si no hubo resultados en la consulta
    else{
      //Mostrar que la cuenta no existe
      echo "<script>
      alert('Estas intentando entrar como $tipo. La cuenta no esta registrada.');
      </script>";
      header('Location: ../login');
    }
    //Desconectar
    Desconectar($Con);
  }
    ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CEIBA - Login</title>
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
              <a href="productos/?show=productos">Todos</a>
              <a href="productos/?show=categorias">Categorías</a>
              <a href="productos/?show=productores">Productores</a>
            </div>
          </div></li>
          <li><a href="#contact">Contacto</a></li>
          <li><a href="../registro" class="btn">Regístrate</a></li>
        </ul>
      </nav>
    </header>
    <main class="main">
        <section class="form">
            <form class="login" method="post" name="login">
                <h2 class="title">Inicia Sesión</h2>
                <div class="inputs">
                    <div class="input">
                        <input name="email" type="email" placeholder="Correo electrónico" required>
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="input">
                        <input name="password" type="password" placeholder="Contraseña" required>
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <div class="forgot">
                      <a href="#">Olvidé mi contraseña</a>
                    </div>
                    <button type="submit" name="login" class="form-btn">Iniciar sesión</button>
                    <div class="alt">
                        No tienes cuenta? <a href="../registro">Regístrate</a>
                    </div>
                </div>
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