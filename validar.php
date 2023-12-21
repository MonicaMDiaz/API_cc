<?php
session_start();

if (isset($_POST['usuario']) && isset($_POST['contraseña'])) {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    $conexion = mysqli_connect("localhost", "root", "", "cv");

    $consulta = "SELECT * FROM usuarios where usuario='$usuario' and contraseña='$contraseña'";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        $filas = mysqli_fetch_array($resultado);

        if($filas && $filas['id_cargo']==1){ //administrador
            header("location:seccion/index.php");
        
        }else
        if($filas && $filas['id_cargo']==2){ //cliente
        header("location:seccionn/index.php");
        } else {
            include("iniciosesion.html");
            ?>
<h1 class="bad">ERROR EN LA AUTENTIFICACION</h1>
<?php
        }
        mysqli_free_result($resultado);
    } else {
        // Manejar el caso en el que la consulta no fue exitosa
        echo "Error en la consulta SQL: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
} else {
    // Manejar el caso en el que los campos no se enviaron correctamente
    echo "Error: Campos de usuario y contraseña no proporcionados.";
}
?>