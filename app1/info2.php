<?php
$servername="localhost";
$username= "root";
$password= "";
$dbname= "cv";
$conn= mysqli_connect($servername,$username,$password,$dbname);
if (!$conn){
    die("Connection failed: " . mysqli_connect_error());
    }
    else
    echo "conexión correcta, <br> ";

//captura de variables
$id=$_POST["id"];
echo $id;
$placa=$_POST["placa"];
echo $placa;

//sentencia sql para ingresar datos a la bd
$sql= "insert into datos (id, placa) values ('".$id."','".$placa."')";
//$sql= "insert into datos (temperatura) values ('".$temperatura."')";
if(mysqli_query($conn, $sql)){
//$id= mysqli_insert_id($conn);
echo "<br>nuevo registro creado. ".$id;
} 
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<head>
    <title> Almacenamiento de información</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    </link>
</head>

<body>
    <h2>Mostrar información</h2>
    <form method="post" action="mostrar_bd.php">
        <p>
        <table border="0" align="left">
            <tr align="left">
            <tr>
                <td><input type="submit" class="button" name="b1" value="Ver información"></td>
            </tr>
        </table>
    </form>
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