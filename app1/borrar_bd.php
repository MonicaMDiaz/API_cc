<?php
$servername="localhost";
$username= "root";
$password= "";
$dbname= "cv";
$conn= mysqli_connect($servername,$username,$password,$dbname);
if (!$conn){
    die("Connection failed: " . $conn->connect_error);
    }
$campo_borrar=$_POST["campo_borrar"];
$sql = "DELETE from datos WHERE id=".$campo_borrar;

if ($conn->query($sql)=== TRUE){
    ECHO "Campo borrado";
} else{
    echo "No se pudo borrar dato:" .$conn->error;
}

mysqli_close($conn);
?>

<html>

<head>
    <title>Borrar información</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    </link>
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
</body>

</html>