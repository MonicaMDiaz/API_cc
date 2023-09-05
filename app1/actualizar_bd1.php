<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
die("Connection failed: " . $conn->connect_error);
}

$id = $_POST["id"];
$placa = $_POST["placa"];

// IMPORTANTE: Agrega comillas simples (' ') alrededor de los valores de las variables
$sql = "UPDATE datos SET placa = '$placa' WHERE id = $id";

if (mysqli_query($conn, $sql)) {
echo "<br>Registro actualizado. ID: " . $id;
} else {
echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>

<html>

<head>
    <title>Actualizar información</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
</head>

<body>
    <form method="post" action="c2.html">
        <p>
        <table>
            <tr>
            <tr>
                <td><input type="submit" class="button" name="b1" value="Volver"></td>
            </tr>
        </table>
    </form>
    <form method="post" action="mostrar_bd.php">
        <p>
        <table border="0" align="left">
            <tr align="left">
            <tr>
                <td><input type="submit" class="button" name="b1" value="Ver datos"></td>
            </tr>
        </table>
    </form>
</body>

</html>