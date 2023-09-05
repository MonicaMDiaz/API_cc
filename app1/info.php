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