<?php
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    //Incluir las funciones para la conexion a la base de datos
    include("funciones.php");
    //Reanudamos la sesión 
    @session_start(); 
    $_SESSION = array();

    //Borrar cookies de la sesión
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    };
    //Destruir la sesión
    session_destroy();
    //Redireccionar al login
    header("Location: index.php");
  ?>