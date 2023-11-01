<?php
function validarlogin($user, $password)
{
    global $conexion;
    $consulta = "SELECT * FROM users where user='".$user." AND password='".$password."'";
    $respuesta = mysql_query($conexion,$consulta);

    if ($fila = mysql_fetch_row($respuesta))
    {
        session_start();
        $_SESSION[user] = $user;
        return true;
    }
    return false;
}

?>