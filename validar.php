<?php
if (isset($_POST['usuario']) && isset($_POST['contraseña'])) {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];
    session_start();
    $_SESSION['usuario']=$usuario;
    $_SESSION['contraseña']=$contraseña;

    $conexion = mysqli_connect("localhost", "root", "", "cv");

    $consulta = "SELECT * FROM usuarios where usuario='$usuario' and contraseña='$contraseña'";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        $filas = mysqli_fetch_array($resultado);

        if ($filas && $filas['id_cargo'] == 1) { //administrador
            header("location:seccion/index.php");
        } elseif ($filas && $filas['id_cargo'] == 2) { //cliente
            header("location:seccionn/index.php");
        } else {
            echo '<script>alert("Usuario o contraseña incorrectos");</script>';
            include("iniciosesion.html");
        }

        mysqli_free_result($resultado);
    } else {
        echo '<script>alert("Error en la consulta SQL: ' . mysqli_error($conexion) . '");</script>';
    }

    mysqli_close($conexion);
} 
?>