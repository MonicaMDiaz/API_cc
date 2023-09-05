<?php
$servername="localhost";
$username= "root";
$password= "";
$dbname= "cv";
$conn= mysqli_connect($servername,$username,$password,$dbname);
if (!$conn){
    die("Connection failed: " . mysqli_connect_error());
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

<html>

<head>
    <title>Mostrar información</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    </link>
</head>

<body>
    <p> Si desea borrar digite el id aqui</p>
    <form method="post" action="borrar_bd.php">
        <p><input type="text" name="campo_borrar" size="20"></p>
        <p><input type="submit" name="b1" value="Borrar campo"></p>
    </form>

    <p> Si desea actualizar, digite el id aqui</p>
    <form method="post" action="actualizar_bd.php">
        <p><input type="text" name="campo_actualizar" size="20"></p>
        <p><input type="submit" name="b1" value="Actualizar campo"></p>
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