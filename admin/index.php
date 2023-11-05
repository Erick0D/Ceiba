<?php
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    //Incluir las funciones para la conexion a la base de datos
    include("../funciones.php");
    //Reanudamos la sesión 
    @session_start(); 
    $Con=Conectar();
    //Guardar el usuario de la sesión activa
    if(isset($_SESSION['admin'])){
      $admin=$_SESSION['admin'];
        //Guardar los datos en un arreglo
      $name=$admin;
        //Desconectar
      Desconectar($Con);
    }
    if (isset($_SESSION['Bandera']) && $_SESSION['admin']==='admin') {
  ?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CEIBA - Login</title>
    <link rel="icon" href="../imgs/Ceiba.jpeg">
    <link rel="stylesheet" href="style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
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
          <li><a href="../">Inicio</a></li>
          <li><a href="../productos">Productos</a></li>
          <?php
            echo '<li>
                    <div class="dropdown">
                      <a class="btn profile"><i class="fa-solid fa-circle-user fa-xl"></i> '.$name.' <i class="fa-solid fa-sort-down"></i>
                      </a>
                      <div class="dropdown-content">
                        <a href="../close.php">Cerrar sesión</a>
                      </div>
                    </div>
                  </li>';
            ?>
        </ul>
      </nav>
    </header>
    <main class="main">
      <sidebar class="sidebar">
        <div class="menu_content">
          <ul class="menu_items">
            <div class="menu_title menu_profile"></div>
            <li class="item">
              <a href="?tab=regproductores" class="nav_link submenu_item">
                <span class="navlink_icon">
                <i class='bx bxs-user-detail' ></i>
                </span>
                <span class="navlink">Registrar Productor</span>
              </a>
            </li>
            <li class="item">
              <a href="?tab=productores" class="nav_link submenu_item">
                <span class="navlink_icon">
                <i class='bx bx-store-alt'></i>
                </span>
                <span class="navlink">Productores</span>
              </a>
            </li>
            <li class="item">
              <a href="?tab=usuarios" class="nav_link submenu_item">
                <span class="navlink_icon">
                <i class='bx bxs-user-circle' ></i>
                </span>
                <span class="navlink">Usuarios</span>
              </a>
            </li>
            <li class="item">
              <a href="?tab=pedidos" class="nav_link submenu_item">
                <span class="navlink_icon">
                <i class='bx bxs-package' ></i>
                </span>
                <span class="navlink">Pedidos</span>
              </a>
            </li>
            <li class="item">
              <a href="?tab=crearEvento" class="nav_link submenu_item">
                <span class="navlink_icon">
                <i class='bx bx-calendar-event' ></i>
                </span>
                <span class="navlink">Crear evento</span>
              </a>
            </li>
            <li class="item">
              <a href="?tab=eventos" class="nav_link submenu_item">
                <span class="navlink_icon">
                <i class='bx bxs-calendar-event' ></i>
                </span>
                <span class="navlink">Eventos</span>
              </a>
            </li>
            <li class="item">
              <a href="?tab=configuracion" class="nav_link submenu_item">
                <span class="navlink_icon">
                <i class='bx bxs-cog' ></i>
                </span>
                <span class="navlink">Configuración</span>
              </a>
            </li>
          </ul>
          <div class="bottom_content">
            <div class="bottom expand_sidebar">
              <span>Ampliar</span>
              <i class='bx bxs-arrow-from-left'></i>
            </div>
            <div class="bottom collapse_sidebar">
              <span>Ocultar</span>
              <i class='bx bx-arrow-from-right' ></i>
            </div>
          </div>
        </div>
      </sidebar>
      <div class="content">
      <?php
      switch ($_GET['tab']) {
        case 'regproductores':
          if (isset($_FILES["logo"]) && $_FILES["logo"]["error"] == 0) {
            $logo_temporal = $_FILES["logo"]["tmp_name"];
            $logo = $_FILES["logo"]["name"];
            $carpeta_destino = "../imgs";
            move_uploaded_file($logo_temporal, "$carpeta_destino/$logo");
          }else{
              $logo = 'productor.webp';
          }
          if (isset($_POST['Registrar'])){
            $name=$_POST['name'];
            $pnumber=$_POST['pnumber'];
            $email=$_POST['email'];
            $password=$_POST['password'];
            $status=1;
            $Con=Conectar();
            $SQL="INSERT INTO productores (empresa, telefono, email, password, logo, estatus) VALUES ('$name','$pnumber','$email','$password','$logo','$status')";
            $Resultado=Consultar($Con,$SQL);
            Desconectar($Con);
            if($Resultado==1){
              echo "<script>
                  alert('Productor registrado exitosamente.');
                  </script>";
            }else{
              echo "<script>
                  alert('Error! Revise los datos.');
                  </script>";
            }
          }
          echo '
          <form id="register" name="login" method="post" action="" enctype="multipart/form-data">
              <h2 class="title">Registra nuevo proveedor</h2>
              <div class="inputs">
                  <div class="input">
                    <input name="name" type="text" placeholder="Nombre de la empresa" required>
                    <i class="fa-solid fa-user"></i>
                  </div>
                  <div class="input">
                    <label>Logo</label>
                    <input name="logo" type="file" accept="image/*">
                  </div>
                  <div class="input">
                    <input name="pnumber" type="text" placeholder="Teléfono" maxlength="10" required>
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
                  <button type="submit" name="Registrar" class="form-btn">Registrar</button>
              </div>
          </form>';
          break;
        case 'productores':
          $Con=Conectar();
          $SQL = "SELECT *
          FROM productores";
          //Hacer la consulta con el comando SQL correspondiente
          $Resultado = Consultar($Con, $SQL);
          Desconectar($Con);
          //Guardar los datos en un arreglo
          $n = mysqli_num_rows($Resultado);
          //Si hubo un resultado
          if ($n >= 1) {
            echo '<section class="providers" id="providers">
            <h1>Productores</h1>
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
                <a class="btn" href="#">Deshabilitar</a><br><br>
                <a class="btn" href="../productos?productor=' . $productor[0] . '">Ver productos</a>
              </li>';
            }
            echo '</ul>
            </section>';
          } else {
            echo '<h2>No hay productores</h2>';
          }
          break;
          case 'usuarios':
            $Con=Conectar();
            $SQL = "SELECT *
            FROM usuarios";
            //Hacer la consulta con el comando SQL correspondiente
            $Resultado = Consultar($Con, $SQL);
            Desconectar($Con);
            //Guardar los datos en un arreglo
            $n = mysqli_num_rows($Resultado);
            //Si hubo un resultado
            if ($n >= 1) {
              echo '<section class="providers" id="providers">
              <h1>Usuarios</h1>
              <ul class="cards">';
              //Guardar los datos en un arreglo
              for ($f = 0; $f < $n; $f++) {
                $usuario = mysqli_fetch_row($Resultado);
                echo '
                <li class="card">
                  <i class="bx bxs-user-circle"></i>
                  <h3>' . $usuario[1] . ', ' . $usuario[2] . ' ' . $usuario[3] . '</h3>
                  <p>Teléfono: ' . $usuario[6] . '</p>
                  <p>Email: ' . $usuario[4] . '</p>
                  <a class="btn" href="#">Deshabilitar</a>
                </li>';
              }
              echo '</ul>
              </section>';
            } else {
              echo '<h2>No hay productores</h2>';
            }
            break;
            case 'pedidos':
              $Con=Conectar();
                  $SQL = "SELECT *
                      FROM pedidos
                      ORDER BY fecha DESC;";
                  $ResultadoPedidos = Consultar($Con, $SQL);
                  $npedidos = mysqli_num_rows($ResultadoPedidos);
                  if ($npedidos >= 1) {
                    echo '<section class="orders">
                    <h1>Todos los pedidos</h1>
                            <table>
                              <thead>
                                  <tr>
                                      <td># Pedido</td>
                                      <td>Usuario</td>
                                      <td>Productos</td>
                                      <td>Fecha</td>
                                      <td>Total</td>
                                  </tr>
                              </thead>
                              <tbody>
                              ';
                    for ($f = 0; $f < $npedidos; $f++) {
                      $npedidos = mysqli_num_rows($ResultadoPedidos);
                      $pedidos = mysqli_fetch_row($ResultadoPedidos);
                      $SQL = "SELECT nombre
                      FROM usuarios
                      WHERE id=$pedidos[3];";
                      $ResultadoUsuario = Consultar($Con, $SQL);
                      $usuario = mysqli_fetch_row($ResultadoUsuario);
                      $usuario = $usuario[0];
                      $pedido_id = $pedidos[0];
                      $fecha = $pedidos[1];
                      $total = $pedidos[2];
                      $SQL = "SELECT nombre
                      FROM usuarios
                      WHERE id = $pedido_id;";
                      $ResultadoDetalles = Consultar($Con, $SQL);
                      $SQL = "SELECT p.nombre, dp.cantidad 
                      FROM productos p 
                      JOIN detalle_pedido dp 
                      ON p.id = dp.id_producto 
                      JOIN pedidos pe 
                      ON dp.id_pedido = pe.id 
                      WHERE pe.id = $pedido_id;";
                      $ResultadoDetalles = Consultar($Con, $SQL);
                      $ndetalles = mysqli_num_rows($ResultadoDetalles);
                      echo '<tr>
                              <td>
                                <a href="../productos/?id=' . $pedido_id . '">' . $pedido_id . '</a>
                              </td>
                              <td>
                              ' . $usuario . '
                              </td>
                              <td>
                                  ';
                        for ($d = 0; $d < $ndetalles; $d++) {
                          $detalles = mysqli_fetch_row($ResultadoDetalles);
                          echo $detalles[0] . ' x' . $detalles[1].'<br>';
                        };
                      echo '
                              </td>
                              <td>' . $fecha . '</td>
                              <td class="price">&dollar;' . $total . '</td>
                          </tr>';
                    }
                    echo '</tbody>
                        </table>
                        </section>';
                  }
                  Desconectar($Con);
            break;
            case 'crearEvento':
              if (isset($_POST['Crear'])){
                $name=$_POST['name'];
                $pnumber=$_POST['pnumber'];
                $email=$_POST['email'];
                $photo=$_POST['photo'];
                $password=$_POST['password'];
                $status=1;
      
                if (empty($photo)) {
                  $photo = '../imgs/proveedores';
                }
                $Con=Conectar();
                $SQL="INSERT INTO productores (empresa, telefono, email, password, logo, estatus) VALUES ('$name','$pnumber','$email','$password','$photo','$status')";
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
              echo '
              <form id="regevent" name="regevent" method="post" action="">
                  <h2 class="title">Crear evento</h2>
                  <div class="inputs">
                      <div class="input">
                        <input name="date" type="date" placeholder="Nombre de la empresa" required>
                        <i class="bx bxs-calendar" ></i>
                      </div>
                      <div class="input">
                        <input name="location" type="text" placeholder="Lugar" maxlength="255" required>
                        <i class="bx bx-current-location"></i>
                      </div>
                      <button type="submit" name="Crear" class="form-btn">Registrar</button>
                  </div>
              </form>';
              break;
        default:
          break;
      }
      echo('');
      ?>
      </div>
    </main>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="scripts.js"></script>
  </body>
</html>
<?php
	}else{
		header("Location: login.php");
	}
?>