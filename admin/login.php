<?php
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    
    //Incluir las funciones para la conexion a la base de datos
    include '../funciones.php';

    if (isset($_POST['login'])) { //Iniciar una sesión con PHP
      session_start();
      //Guardar variables con los datos ingresados para iniciar sesión
      $username=$_POST['username'];
      $password=$_POST['password'];

      $username = filter_var($username, FILTER_SANITIZE_STRING);
      $password = filter_var($password, FILTER_SANITIZE_STRING);

      //Guardar la variable de la conexión
      $Con=Conectar();

      //Seleccionar una columna de la tabla usuarios
      $SQL=("SELECT username,password FROM admin WHERE username='$username';");

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
        if($password==$Fila[1]){
          //Guardar variables de sesión
          $_SESSION['admin']=$Fila[0];
          $_SESSION['Bandera']="SI";
          echo "<script>
          alert('Inicio de sesión exitoso.');
          </script>";
          echo "<script>window.location.href='../admin?tab=regproductores';</script>";
            exit;
        }
        //Si la contraseña es incorrecta o no corresponde con el usuario
        else{
          //Notificar que los datos son incorrectos
          echo "<script>
          alert('Datos incorrectos.');
          </script>";
          header('Location: login.php');
        }
      }
      //Si no hubo resultados en la consulta
      else{
        //Mostrar que la cuenta no existe
        echo "<script>
        alert('La cuenta no esta registrada.');
        </script>";
        header('Location: ../login.php');
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
    <link rel="stylesheet" href="stylelogin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  </head>
  <body>
  <header>
      <nav class="navbar">
        <h2 class="logo"><a href="../"><img src="../imgs/Ceiba.webp" alt="Logo CEIBA" /></a></h2>
        <div class="social-nav">
          <a title="Facebook" href="#facebook"><i class="fa-brands fa-square-facebook"></i></a>
          <a title="Twitter" href="#twitter"><i class="fa-brands fa-square-twitter"></i></a>
          <a title="LinkedIn" href="#linkedin"><i class="fa-brands fa-linkedin"></i></a>
          <a title="Email" href="#email"><i class="fa-solid fa-envelope"></i></a>
        </div>
        <input title="menu" type="checkbox" id="menu-toggler">
        <label for="menu-toggler" id="hamburger-btn">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="24px" height="24px">
            <path d="M0 0h24v24H0z" fill="none"/>
            <path d="M3 18h18v-2H3v2zm0-5h18V11H3v2zm0-7v2h18V6H3z"/>
          </svg>
        </label>
        <ul class="all-links">
          <li><a href="../" class="active">Inicio</a></li>
          <li><a href="../#about">Nosotros</a></li>
          <li><a href="../#providers">Productos</a></li>
          <li><a href="../#contact">Contacto</a></li>
        </ul>
      </nav>
    </header>
    <main class="main">
        <section class="form">
            <form class="login" method="post" name="login">
                <h2 class="title">Inicia Sesión</h2>
                <div class="inputs">
                    <div class="input">
                        <input name="username" type="text" placeholder="Usuario" required>
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="input">
                        <input name="password" type="password" placeholder="Contraseña" required>
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <button type="submit" name="login" class="form-btn">Iniciar sesión</button>
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