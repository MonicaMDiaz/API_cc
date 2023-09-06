<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<head>
    <title>Fichas</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    </link>
</head>

</html>
<?php include("../templates/cabecera.php"); ?>
<br>
<style>
body {
    background-color: orange;
}

h1 {
    color: white;
    text-align: center;
}

h2 {
    color: black;
    text-align: center;
    font-family: Arial Rounded MT;
    font-weight: bold;
    font-size: 50px;
}

p {
    font-family: Arial Rounded MT;
    font-size: 15px;
}

.button {
    background-color: white;
    border: none;
    color: black;
    padding: 10px 15px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
</style>
<br>
<?php
//INSERT INTO `datos` (`id`, `placa`, `fecha`) VALUES ('', NULL, current_timestamp())
$servername="localhost";
$username= "root";
$password= "";
$dbname= "cv";

$conn= mysqli_connect($servername,$username,$password,$dbname);
if (!$conn){
    die("Connection failed: " . $conn->connect_error);  
    }
    $sql= "SELECT * FROM datos";
    $result= mysqli_query($conn, $sql);
    if (mysqli_num_rows($result)>0){
        echo"<br><div class='table'><table class='table' width='100' bgcolor='oldlace'><br>
        <tr>
            <th scope='col'>id</th>
            <th scope='col'>placa</th>
            <th scope='col'>fecha</th>
            <th scope='col'>Acción</th></tr>";
            
        while ($row = mysqli_fetch_assoc($result)){
            echo "<tr>
                <td>" .$row["id"]."</td>
                <td>" .$row["placa"]."</td>
                <td>" .$row["fecha"]."</td>
                <td>
                <form action='ficha_i.php' method='post'>
                    <input type='submit' value='Ver' name='accion' class='btn btn-dark'>
                <form action='' method='post'>
                    <input type='submit' value='Editar' name='accion' class='btn btn-success'>
                <form action='' method='post'>
                    <input type='submit' value='Borrar' name='accion' class='btn btn-danger'>
                </form></form></form>
                </td>
                </tr>";
        }
        echo"</table>" ; 
    } else{
        echo "0 resultados";
    }
mysqli_close($conn);
?>

<form action='' method='post'>
    <input type='submit' value='Agregar' name='accion' class='btn btn-secondary'>
</form>

<?php include("../templates/pie.php"); ?>