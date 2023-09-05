<?php
$servername="localhost";
$username= "root";
$password= "";
$dbname= "cv";
$conn= mysqli_connect($servername,$username,$password,$dbname);
if (!$conn){
    die("Connection failed: " . $conn->connect_error);
    }
$campo_actualizar=$_POST["campo_actualizar"];
$sql = "SELECT placa,id from datos WHERE id=".$campo_actualizar;
$result= mysqli_query($conn, $sql);
if (mysqli_num_rows($result)>0){
    while ($row = mysqli_fetch_assoc($result)){
echo "<form method='post' action='actualizar_bd1.php'>";
echo "<p>dato: <input type='text' type='number' name='placa' size='20' value='".$row["placa"]."'></p>";
echo "<p>ID: <input type='number' name='id' size='20' value='".$row["id"]."'></p>";
echo "<p><input type='submit' name='b1' value='Actualizar dato'></p>";
echo "</form>";
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