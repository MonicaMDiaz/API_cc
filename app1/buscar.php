<?php
$servername="localhost";
$username= "root";
$password= "";
$dbname= "cv";
$conn= mysqli_connect($servername,$username,$password,$dbname);
if (!$conn){
    die("Connection failed: " . $conn->connect_error);  
    }
/*$buscar=$_POST["buscar"];
$sql = "SELECT placa,id from datos WHERE placa LIKE '%".$buscar."%'";
$sql= "SELECT placa,id from datos WHERE id=".$buscar; */
$buscar=$_POST["buscar"];
$buscar_valor=$_POST["buscar_valor"];

if ($buscar == "placa") {
    $sql = "SELECT placa,id from datos WHERE placa LIKE '%".$buscar_valor."%'";
}
else if ($buscar == "id") {
    $sql = "SELECT placa,id from datos WHERE id=".$buscar_valor;
}
else {
    echo "Opción no válida";
}

$result= mysqli_query($conn, $sql);
if (mysqli_num_rows($result)>""){
    echo"<table border=0><tr><th>id</th><th>placa</th></tr>";
    while ($row = mysqli_fetch_assoc($result)){
        echo "<tr><td>" .$row["id"]."</td><td align=center>" .$row["placa"]."</td></tr>";
    }
    ECHO "</table>";
} else{
    echo "0 resultados";
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