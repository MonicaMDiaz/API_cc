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
<?php
//INSERT INTO `datos` (`id`, `placa`, `fecha`) VALUES ('', NULL, current_timestamp())

$opciones = array();
$opciones[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;

$servername="localhost";
$username= "root";
$password= "";
$dbname= "cv";
$conn= mysqli_connect($servername,$username,$password,$dbname);
if (!$conn){
    die("Connection failed: " . $conn->connect_error);  
    }
$buscar=$_POST["buscar"];
$buscar_valor=$_POST["buscar_valor"];

if ($buscar == "placa") {
    $sql = "SELECT placa,id,fecha from datos WHERE placa LIKE '%".$buscar_valor."%'";
}
else if ($buscar == "id") {
    $sql = "SELECT placa,id,fecha from datos WHERE id=".$buscar_valor;
}
else {
    echo "Opción no válida";
}

$result= mysqli_query($conn, $sql);
if (mysqli_num_rows($result)>""){
    echo"<br><div class='col-2'></div><div class='col-8'><div class='table'><table class='table' width='100' bgcolor='oldlace'><br>
    <tr>
        <th scope='col'>id</th>
        <th scope='col'>placa</th>
        <th scope='col'>fecha</th>
        <th scope='col'>Acción</th></tr>
    </div><div class='col-2'></div>";
    while ($row = mysqli_fetch_assoc($result)){
        echo "<tr>
            <td>" .$row["id"]."</td>
            <td>" .$row["placa"]."</td>
            <td>" .$row["fecha"]."</td>
            <td>seleccionar</td>
            </tr>";
    }
    ECHO "</table>";
} else{
    echo "0 resultados";
}
mysqli_close($conn);
?>

<!--<div class="table-responsive">
    <table class="table table-primary">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Placa</th>
                <th scope="col">Acción</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>10</td>
                <td>dhi452</td>
                <td>seleccionar</td>
            </tr>

        </tbody>
    </table>
</div>-->


<?php include("../templates/pie.php"); ?>