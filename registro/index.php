<?php
  if (isset($_POST['Registrar'])){
    $name=$_POST['name'];
    $lastname=$_POST['lastname'];
    $slastname=$_POST['slastname'];
    $pnumber=$_POST['pnumber'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $status=1;

    if (empty($slastname)) {
        $slastname = NULL;
    }
    include '../funciones.php';
    $Con=Conectar();
    $SQL="INSERT INTO usuarios (nombre, ap_pat, ap_mat, email, password, telefono, estatus) VALUES ('$name','$lastname','$slastname','$email','$password','$pnumber','$status')";
    $Resultado=Consultar($Con,$SQL);
    Desconectar($Con);
    if($Resultado==1){
      header("Location: ../login");
    }else{
      echo "<script>
          alert('Error! Revise los datos.');
          </script>";
    }
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
              <a href="../productos/?show=productos">Todos</a>
              <a href="../productos/?show=categorias">Categorías</a>
              <a href="../productos/?show=productores">Productores</a>
            </div>
          </div></li>
          <li><a href="#contact">Contacto</a></li>
          <li><a href="../login" class="btn">Inicia Sesión</a></li>
        </ul>
      </nav>
    </header>

    <main class="main">
        <section class="form">
            <form id="register" name="login" method="post" action="">
                <h2 class="title">Regístrate</h2>
                <div class="inputs">
                    <div class="input">
                      <input name="name" type="text" placeholder="Nombre(s)" required>
                      <i class="fa-solid fa-user"></i>
                    </div>
                    <div class="lastname">
                      <div class="input">
                        <input name="lastname" type="text" placeholder="Apellido Paterno" required>
                      </div>
                      <div class="input">
                        <input name="slastname" type="text" placeholder="Apellido Materno">
                      </div>
                    </div>
                    <div class="input">
                      <input name="pnumber" type="tel" placeholder="Teléfono" pattern="[0-9]{10}" maxlength="10" required>
                      <i class="fa-solid fa-phone"></i>
                    </div>
                    <div class="input">
                        <input name="email" type="email" placeholder="Correo electrónico" required>
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="input">
                        <input name="password" type="password" placeholder="Contraseña" required>
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <button type="submit" name="Registrar" class="form-btn">Registrarse</button>
                    <div class="alt">
                        Ya tienes cuenta? <a href="../login">Inicia sesión</a>
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