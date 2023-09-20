<?php include("../templates/cabecera.php"); ?>

<?php
include_once '../databases/BD.php';
$conexionBD=BD::crearInstancia();
//$consulta=$conexionBD->prepare("SELECT * FROM datos");
//$consulta = $conexionBD->prepare("SELECT datos.id, datos.placa, datos.fecha, inventario.Trek FROM datos INNER JOIN inventario ON datos.id = inventario.id");
$consulta = $conexionBD->prepare("SELECT * FROM datos INNER JOIN inventario ON datos.id = inventario.id");
$consulta->execute();
$result = $consulta->fetchAll();


$id=isset($_POST['id'])?$_POST['id']:'';
$placa=isset($_POST['placa'])?$_POST['placa']:'';
$trek=isset($_POST['Trek'])?$_POST['Trek']:'';

?>
<br>
<div class='table'>
    <table class='table' width='100' bgcolor='oldlace'><br>
        <tr>
            <th scope='col'>id</th>
            <th scope='col'>placa</th>
            <th scope='col'>fecha</th>
            <th scope='col'>trek</th>
        </tr>
        <?php foreach($result as $ficha){?>
        <tr>
            <td> <?php echo $ficha['id']?> </td>
            <td> <?php echo $ficha["placa"]?> </td>
            <td> <?php echo $ficha["fecha"]?> </td>
            <td> <?php echo $ficha['Trek']?> </td>
        </tr>
        <?php }?>

    </table>
</div>
<br>

<?php include("../templates/pie.php"); ?>