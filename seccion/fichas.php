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
        echo"<table border=0><tr><th>id</th><th>placa</th></tr>";
        while ($row = mysqli_fetch_assoc($result)){
            echo "<tr><td>" .$row["id"]."</td><td align=center>" .$row["placa"]."</td></tr>";
        }
        echo"</table>" ; 
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