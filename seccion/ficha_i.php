<?php include("../templates/cabecera.php"); ?>
<br>
<style>
body {
    background-color: orange;
}

h1 {
    color: white;
    text-align: center;
    font-family: Arial Rounded MT;
    font-weight: bold;
    font-size: 30px;
}

h2 {
    color: black;
    text-align: left;
    font-family: Arial Rounded MT;
    font-weight: bold;
    font-size: 20px;
}

h3 {
    color: white;
    text-align: left;
    font-family: Arial Rounded MT;
    font-weight: bold;
    font-size: 21px;
}

h4 {}

p {
    font-family: Arial Rounded MT;
    font-size: 15px;
}
</style>
<br>
<?php
include_once '../databases/BD.php';
$conexionBD=BD::crearInstancia();

$id = $_GET['id'];
$sql = "SELECT * FROM datos WHERE id = :id";
$consulta = $conexionBD->prepare($sql);
$consulta->bindParam(':id', $id);
$consulta->execute();
$ficha = $consulta->fetch(PDO::FETCH_ASSOC);
?>

<br>
<div style="display: flex; justify-content: space-between;">
    <img src="/images/der.jpg" alt="Cara derecha del bus" width="350" height="250">
    <img src="/images/frente.jpg" alt="Frente del bus" width="450" height="250">
    <img src="/images/frenteiz.jpeg" alt="Cara izuierda del bus" width="450" height="250">
</div>

<div class='table'>
    <table width='100%' bgcolor='oldlace' border='3'><br>
        <h1>Información vehículo</h1>
        <tr>
            <th>ID de bus:</th>
            <td> <?php echo $ficha['id']?> </td>
            <th>Placa:</th>
            <td> <?php echo $ficha["placa"]?> </td>
            <th>Empresa:</th>
            <td>Autobuses</td>
        </tr>
        <tr>
            <th>Nombre conductor:</th>
            <td> Pepito pable perez meza </td>
            <th>Identificación</th>
            <td> CC. 123456789 </td>
            <th>Fecha y hora</th>
            <td> <?php echo $ficha["fecha"]?> </td>
        </tr>
    </table>

    <table class='table' width='100%' bgcolor='oldlace' border='3'><br>

        <h2>Estado: </h2>
        <h3>Unidad Lógica</h3>
        <tr>
            <th>ID de bus:</th>
            <td> <?php echo $ficha['id']?> </td>
            <th>Placa:</th>
            <td> <?php echo $ficha["placa"]?> </td>
            <th>Empresa:</th>
            <td>Autobuses</td>
        </tr>
        <tr>
            <th>Nombre conductor:</th>
            <td> Pepito pable perez meza </td>
            <th>Identificación</th>
            <td> CC. 123456789 </td>
            <th>Fecha y hora</th>
            <td> <?php echo $ficha["fecha"]?> </td>
        </tr>
    </table>
</div>

<?php include("../templates/pie.php"); ?>