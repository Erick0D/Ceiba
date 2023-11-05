<?php
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    //Incluir las funciones para la conexion a la base de datos
    include("../funciones.php");
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
      $id=$fila[0];
      $SQL= "SELECT *
      FROM carrito_productos
      WHERE id='$cart';";
        //Hacer la consulta con el comando SQL correspondiente
      $Resultado=Consultar($Con, $SQL);
      $items=mysqli_num_rows($Resultado);
        //Desconectar
      Desconectar($Con);
    }
    if (isset($_SESSION['Bandera'])) {
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CEIBA - Perfil</title>
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
      <sidebar class="sidebar">
        <div class="menu_content">
          <ul class="menu_items">
            <div class="menu_title menu_profile"></div>
            <li class="item">
              <a href="?tab=informacion" class="nav_link submenu_item">
                <span class="navlink_icon">
                <i class='bx bxs-user-detail' ></i>
                </span>
                <span class="navlink">Información</span>
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
              <a href="?tab=configuracion" class="nav_link submenu_item">
                <span class="navlink_icon">
                <i class='bx bxs-cog' ></i>
                </span>
                <span class="navlink">Configuración</span>
              </a>
            </li>
            <?php
                if($_SESSION['tipo']=='productores'){
                  echo '<div class="menu_title menu_products"></div>
                  <li class="item">
                    <a href="?tab=productos" class="nav_link submenu_item">
                      <span class="navlink_icon">
                      <i class="bx bxs-store"></i>
                      </span>
                      <span class="navlink">Administrar productos</span>
                    </a>
                  </li>
                  <li class="item">
                    <a href="?tab=registro" class="nav_link submenu_item">
                      <span class="navlink_icon">
                      <i class="bx bxs-plus-square" ></i>
                      </span>
                      <span class="navlink">Agregar producto</span>
                    </a>
                  </li>'
                ;}
            ?>
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
        if($tipo=='productores'){
          if (isset($_POST['Guardar'])){
            if (isset($_FILES["logo"]) && $_FILES["logo"]["error"] == 0) {
              $logo_temporal = $_FILES["logo"]["tmp_name"];
              $logo = $_FILES["logo"]["name"];
              $carpeta_destino = "../imgs";
              move_uploaded_file($logo_temporal, "$carpeta_destino/$logo");
            }else{
                $logo = $fila[6];
            }
            $name=$_POST['name'];
            $pnumber=$_POST['phone'];
            $address=$_POST['address'];
            $Con=Conectar();
            $SQL="UPDATE productores SET empresa='$name', logo='$logo', telefono='$pnumber', direccion='$address' WHERE id = $id;";
            $Resultado=Consultar($Con,$SQL);
            Desconectar($Con);
            if($Resultado==1){
              echo "<script>
                  alert('Se guardaron los datos.');
                  </script>";
            }else{
              echo "<script>
                  alert('No se pudieron guardar los datos.');
                  </script>";
            }
          }
          switch ($_GET['tab']) {
            case 'informacion':
              echo '<form id="edit" name="edit" method="post" action="" enctype="multipart/form-data">
                      <h2 class="title">Tu información</h2>
                      <div class="inputs">
                          <div class="input">
                            <label>Nombre:</label>
                            <input name="name" type="text" placeholder="Nombre" value="'.$name.'" required>
                          </div>
                          <div class="input">
                            <label>Dirección:</label>
                            <input name="address" type="text" placeholder="Dirección" value="'.$fila[5].'" required>
                          </div>
                          <div class="input">
                            <label>Logo:</label>
                            <input name="logo" type="file" accept="image/*">
                          </div>
                          <div class="input">
                            <label>Teléfono:</label>
                            <input name="phone" type="number" placeholder="Teléfono" value="'.$fila[2].'" required>
                          </div>
                          <button type="submit" name="Guardar" class="form-btn">Guardar</button>
                      </div>
                  </form>';
                  break;
            case 'productos':
              $Con=Conectar();
              $SQL = "SELECT *
              FROM productos
              WHERE id_productor = $id";
              //Hacer la consulta con el comando SQL correspondiente
              $Resultado = Consultar($Con, $SQL);
              Desconectar($Con);
              //Guardar los datos en un arreglo
              $n = mysqli_num_rows($Resultado);
              //Si hubo un resultado
              if ($n >= 1) {
                echo '<section class="providers" id="providers">
                <h1>Tus productos</h1>
                <ul class="cards">';
                //Guardar los datos en un arreglo
                for ($f = 0; $f < $n; $f++) {
                  $productor = mysqli_fetch_row($Resultado);
                  echo '
                  <li class="card">
                    <img src="../imgs/'.$productor[4].'" alt="Imagen ' . $productor[0] . '">
                    <h3>' . $productor[1] . '</h3>
                    <p>' . $productor[2] . '</p>
                    <p>Precio: $' . $productor[5] . '</p>
                    <p>Disponibilidad: ' . $productor[6] . '</p>
                    <a class="btn" href="#">Deshabilitar</a><br><br>
                    <a class="btn" href="../productos?id=' . $productor[0] . '">Ver producto</a>
                  </li>';
                }
                echo '</ul>
                </section>';
              } else {
                echo '<h2>No hay productores</h2>';
              }
              break;
            case 'registro':
              if (isset($_POST['Registrar'])){
                if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
                  $photo_temporal = $_FILES["photo"]["tmp_name"];
                  $photo = $_FILES["photo"]["name"];
                  $carpeta_destino = "../imgs";
                  move_uploaded_file($photo_temporal, "$carpeta_destino/$photo");
                }else{
                    $photo = 'default.webp';
                }
                $name=$_POST['name'];
                $description=$_POST['description'];
                $category=$_POST['category'];
                $price=$_POST['price'];
                $amount=$_POST['amount'];
                $status=1;
                $Con=Conectar();
                $SQL="INSERT INTO productos (nombre, descripcion, id_categoria, foto, precio, cantidad, estatus, id_productor) VALUES ('$name','$description','$category','$photo','$price','$amount','$status','$id')";
                $Resultado=Consultar($Con,$SQL);
                Desconectar($Con);
                if($Resultado==1){
                  echo "<script>
                  alert('Se creó el producto exitosamente.');
                  </script>";
                }else{
                  echo "<script>
                      alert('Error! Revise los datos.');
                      </script>";
                }
              }
              echo '<section class="form">
                <form id="register" name="register" method="post" action="" enctype="multipart/form-data">
                    <h2 class="title">Registra un producto</h2>
                    <div class="inputs">
                        <div class="input">
                          <input name="name" type="text" placeholder="Nombre del producto" required>
                          <i class="fa-solid fa-box"></i>
                        </div>
                        <div class="input">
                          <textarea name="description" type="" placeholder="Descripción del producto" required></textarea>
                        </div>
                        <div class="input">
                          <label>Categoría</label><br>
                          <select name="category" type="text" placeholder="Categoría" required>
                            <option value="1">Carne</option>
                            <option value="2">Bebida</option>
                          </select>
                        </div>
                        <div class="input">
                          <label>Foto</label><br>
                          <input name="photo" type="file" accept="image/*">
                        </div>
                        <div class="input">
                          <input name="price" type="number" step="0.01" placeholder="Precio" required>
                          <i class="fa-solid fa-dollar-sign"></i>
                        </div>
                        <div class="input">
                          <input name="amount" type="number" step="1" placeholder="Cantidad" required>
                          <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                        <button type="submit" name="Registrar" class="form-btn">Registrar</button>
                    </div>
                </form>
              </section>';
                break;
            case 'pedidos':
              $Con=Conectar();
              $SQL = "SELECT p.*, prod.nombre, dp.cantidad, dp.precio, u.nombre FROM pedidos p INNER JOIN usuarios u ON p.id_usuario = u.id INNER JOIN detalle_pedido dp ON p.id = dp.id_pedido INNER JOIN productos prod ON dp.id_producto = prod.id WHERE prod.id_productor = $id;";
              $ResultadoPedidos = Consultar($Con, $SQL);
              $npedidos = mysqli_num_rows($ResultadoPedidos);
              if ($npedidos >= 1) {
                echo '<section class="orders">
                <h1>Pedidos solicitados</h1>
                <table>
                            <thead>
                                <tr>
                                    <td># Pedido</td>
                                    <td>Productos</td>
                                    <td>Usuario</td>
                                    <td>Fecha</td>
                                    <td>Precio</td>
                                    <td>Evento</td>
                                </tr>
                            </thead>
                            <tbody>
                            ';
                for ($f = 0; $f < $npedidos; $f++) {
                  $pedidos = mysqli_fetch_row($ResultadoPedidos);
                  $pedido_id = $pedidos[0];
                  $fecha = $pedidos[1];
                  $total = $pedidos[9];
                  $usuario = $pedidos[10];
                  $producto = $pedidos[7];
                  $cantidad = $pedidos[8];
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
                            ' . $pedido_id . '
                          </td>
                          <td>
                              '. $producto . ' x' . $cantidad.'
                          </td>
                          <td>' . $usuario . '</td>
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
          }
        }elseif($tipo=="usuarios"){
          if (isset($_POST['Guardar'])){
            $name=$_POST['name'];
            $lastname=$_POST['lastname'];
            $slastname=$_POST['lastname2'];
            $pnumber=$_POST['phone'];
            $address=$_POST['address'];
            $status=1;

            if (empty($slastname)) {
                $slastname = NULL;
            }
            $Con=Conectar();
            $SQL="UPDATE usuarios SET nombre='$name', ap_pat='$lastname', ap_mat='$slastname', telefono='$pnumber', direccion='$address' WHERE id = $id;";
            $Resultado=Consultar($Con,$SQL);
            Desconectar($Con);
            if($Resultado==1){
              echo "<script>
                  alert('La información se guardó exitosamente');
                  </script>";
            }else{
              echo "<script>
                  alert('No se pudieron guardar los datos.');
                  </script>";
            }
          }
          switch ($_GET['tab']) {
            case 'informacion':
            echo '<form id="edit" name="edit" method="post" action="">
                    <h2 class="title">Tu información</h2>
                    <div class="inputs">
                        <div class="input">
                          <label>Nombre:</label>
                          <input name="name" type="text" placeholder="Nombre" value="'.$name.'" required>
                        </div>
                        <div class="input">
                          <label>Apellido Paterno:</label>
                          <input name="lastname" type="text" placeholder="Apellido Paterno" value="'.$fila[2].'" required>
                        </div>
                        <div class="input">
                          <label>Apellido Materno:</label>
                          <input name="lastname2" type="text" placeholder="Apellido Materno" value="'.$fila[3].'" required>
                        </div>
                        <div class="input">
                          <label>Teléfono:</label>
                          <input name="phone" type="number" placeholder="Teléfono" value="'.$fila[6].'" required>
                        </div>
                        <div class="input">
                          <label>Dirección:</label>
                          <input name="address" type="text" placeholder="Dirección" value="'.$fila[7].'" required>
                        </div>
                        <button type="submit" name="Guardar" class="form-btn">Guardar</button>
                    </div>
                </form>';
                break;
                case 'pedidos':
                  $Con=Conectar();
                  $SQL = "SELECT *
                      FROM pedidos
                      WHERE id_usuario='$id'
                      ORDER BY fecha DESC;";
                  $ResultadoPedidos = Consultar($Con, $SQL);
                  $npedidos = mysqli_num_rows($ResultadoPedidos);
                  if ($npedidos >= 1) {
                    echo '<section class="orders">
                    <h1>Tus pedidos</h1>
                    <table>
                                <thead>
                                    <tr>
                                        <td># Pedido</td>
                                        <td>Productos</td>
                                        <td>Fecha</td>
                                        <td>Total</td>
                                        <td>Evento</td>
                                    </tr>
                                </thead>
                                <tbody>
                                ';
                    for ($f = 0; $f < $npedidos; $f++) {
                      $pedidos = mysqli_fetch_row($ResultadoPedidos);
                      $pedido_id = $pedidos[0];
                      $fecha = $pedidos[1];
                      $total = $pedidos[2];
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
                                <a href="?tab=pedidos&id=' . $pedido_id . '">' . $pedido_id . '</a>
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
                  if(isset($_GET['id'])){
                    $id_detalles = $_GET['id'];
                    $SQL = "SELECT *
                      FROM detalle_pedido
                      WHERE id_pedido='$id_detalles';";
                  $ResultadoDetalles = Consultar($Con, $SQL);
                  $ndetalles = mysqli_num_rows($ResultadoDetalles);
                  $SQL = "SELECT *
                      FROM pedidos
                      WHERE id='$id_detalles';";
                  $ResultadoPedido = Consultar($Con, $SQL);
                  $pedido = mysqli_fetch_row($ResultadoPedido);
                  $fecha = $pedido[1];
                  $total = $pedido[2];
                  if ($ndetalles >= 1) {
                    echo '<section class="orders">
                    <h1>Pedido #'.$id_detalles.'</h1>
                    <p>Fecha: '.$fecha.'</p>
                    <br>
                    <p>Será entregado en el evento:</p>
                    <br>
                    <table>
                                <thead>
                                    <tr>
                                        <td>Producto</td>
                                        <td>Cantidad</td>
                                        <td>Costo</td>
                                    </tr>
                                </thead>
                                <tbody>
                                ';
                    for ($f = 0; $f < $ndetalles; $f++) {
                      $pedidos = mysqli_fetch_row($ResultadoDetalles);
                      $producto = $pedidos[2];
                      $cantidad = $pedidos[3];
                      $precio = $pedidos[4];
                      $SQL = "SELECT nombre
                      FROM productos 
                      WHERE id = $producto;";
                      $ResultadoProducto = Consultar($Con, $SQL);
                      $nproducto = mysqli_fetch_row($ResultadoProducto);
                      echo '<tr>
                              <td>
                                  '. $nproducto[0].'
                              </td>
                              <td>' . $cantidad . '</td>
                              <td class="price">&dollar;' . $precio . '</td>
                          </tr>';
                    }
                    echo '
                      </tbody>
                        </table>
                        <br>
                    <h2 class="price">Total: &dollar;' . $total . '</h2>
                        </section>';
                  }
                  }
                  Desconectar($Con);
            break;
          }
        }
      ?>
      </div>
    </main>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="scripts.js"></script>
  </body>
</html>
<?php
	}else{
		header("Location: ../login");
	}
?>