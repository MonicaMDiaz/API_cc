<?php include("../templates/cabecera.php"); ?>
<br>
<style>
body {
    background-color: oldlace;
}

h1 {
    color: black;
    text-align: center;
    font-family: Arial Rounded MT;
    font-weight: bold;
    font-size: 30px;
}
</style>
<?php
include_once '../databases/BD.php';
$conexionBD=BD::crearInstancia();

$id = $_GET['id'];
//$sql = "SELECT * FROM datos WHERE id = :id";
$sql = "SELECT * FROM datos INNER JOIN inventario ON datos.id = inventario.id WHERE datos.id = :id";
$consulta = $conexionBD->prepare($sql);
$consulta->bindParam(':id', $id);
$consulta->execute();
$ficha = $consulta->fetch(PDO::FETCH_ASSOC);

$accion=isset($_POST['accion'])?$_POST['accion']:'';

if($accion!=''){
    switch ($accion) {
        case 'Volver':
            header('Location: fichas.php');
            break;
        case 'Editar':
            header('Location: editarficha.php?id=' . $id);
            break;
        case 'Reporte':
            header('Location: Reporte_i.php?id='. $id);
            break;
        default:
            break;
    }
}
?>
<br>
<h1>Plan de acción</h1>
<div class='table'>
    <table width='100%' bgcolor='white' border='3'>
        <tr>
            <th>ID de bus:</th>
            <td> <?php echo $ficha['id']?> </td>
            <th>Empresa:</th>
            <td><?php echo $ficha['Empresa']?></td>
            <th>Placa:</th>
            <td> <?php echo $ficha["placa"]?> </td>
        </tr>
        <tr>
            <th>Nombre conductor:</th>
            <td><?php echo $ficha['Nombre']?></td>
            <th>Identificación</th>
            <td><?php echo $ficha['nit']?> <?php echo $ficha['nid']?> </td>
            <th>Fecha y hora</th>
            <td> <?php echo $ficha["fecha"]?> </td>
        </tr>
    </table>
    <table width='100%' bgcolor='white' border='3'><br>
        <tr>
            <th>Trek 753:</th>
            <td><?php if ($ficha['Trek']=='Mal'){
            print('Arreglar');
        } ?></td>
            <th>Antena GPS:</th>
            <td> <?php echo $ficha['GPS']?> </td>
            <th>Antena 3G:</th>
            <td><?php echo $ficha['3G']?></td>
            <th>Sim card:</th>
            <td> <?php echo $ficha['Sim']?> </td>
        </tr>
    </table>
</div>

<?php include("../templates/pie.php"); ?>