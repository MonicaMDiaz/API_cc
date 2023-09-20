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

.buttons {
    justify-content: space-between;
    margin: 20px 2px;
}

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
            <th>Trek 753:</th>
            <td><?php echo $ficha['Trek']?></td>
            <th>Antena GPS:</th>
            <td> Bien </td>
            <th>Antena 3G:</th>
            <td>bien</td>
            <th>Sim card:</th>
            <td> Bien </td>
        </tr>
        <tr>
            <th>HDC (5m)</th>
            <td> bien </td>
            <th>Cable de poder</th>
            <td>bien</td>
        </tr>
        <tr>
            <th>IOCOVER:</th>
            <td> Bien </td>
            <th>Tapa IOCOVER</th>
            <td> bien </td>
            <th>Cabezal Bipode</th>
            <td>bien</td>
            <th>Bipode</th>
            <td>bien</td>
        </tr>
    </table>
    <table class='table' width='100%' bgcolor='oldlace' border='3'><br>
        <h3>Pip</h3>
        <tr>
            <th>Display de información:</th>
            <td> bien </td>
            <th>Extención del cable de poder:</th>
            <td> bien </td>
            <th>Extención del cable de datos:</th>
            <td>bien</td>
            <th>Soportes en L:</th>
            <td> Bien </td>
        </tr>
    </table>
    <table class='table' width='100%' bgcolor='oldlace' border='3'><br>
        <h3>APC</h3>
        <tr>
            <th>APC:</th>
            <td> bien </td>
            <th>Soporte caja:</th>
            <td> bien </td>
            <th>cable de poder y datos:</th>
            <td>bien</td>
            <th>DC convertidor (12-24):</th>
            <td> Bien </td>
        </tr>
    </table>
    <table class='table' width='100%' bgcolor='oldlace' border='3'><br>
        <h3>Sensor pta 1</h3>
        <tr>
            <th>Sensor puerta:</th>
            <td> bien </td>
            <th>Extención del cable:</th>
            <td> bien </td>
            <th>Soportes en angulo:</th>
            <td>bien</td>
        </tr>
    </table>
    <table class='table' width='100%' bgcolor='oldlace' border='3'><br>
        <h3>Sensor pta 2</h3>
        <tr>
            <th>Sensor puerta:</th>
            <td> bien </td>
            <th>Extención del cable:</th>
            <td> bien </td>
            <th>Soportes en angulo:</th>
            <td>bien</td>
        </tr>
    </table>
    <table class='table' width='100%' bgcolor='oldlace' border='3'><br>
        <h3>Botón pánico</h3>
        <tr>
            <th>Botón de pánico:</th>
            <td>bien </td>
            <th> </th>
            <td> </td>
            <th> </th>
            <td> </td>
            <th> </th>
            <td> </td>
            <th> </th>
            <td> </td>
            <th>Extención:</th>
            <td>bien </td>
            <th> </th>
            <td> </td>
            <th> </th>
            <td> </td>
            <th> </th>
            <td> </td>
            <th> </th>
            <td> </td>
        </tr>
    </table>
    <table class='table' width='100%' bgcolor='oldlace' border='3'><br>

        <h3>Sistema TRS</h3>
        <tr>
            <th>Radio MDT 400:</th>
            <td> bien </td>
            <th>Cable de poder:</th>
            <td> bien </td>
            <th>Cable PI:</th>
            <td>bien</td>
        </tr>
        <tr>
            <th>MIC conductor</th>
            <td> bien </td>
            <th>Soporte MIC conductor L</th>
            <td> bien </td>
            <th>MIC ambiente</th>
            <td> bien </td>
        </tr>
        <tr>
            <th>Antena TRS</th>
            <td>bien</td>
            <th>Euro base:</th>
            <td> Bien </td>
            <th>Altavoz</th>
            <td> bien </td>
            <th>Botón PTT</th>
            <td>bien</td>
            <th>Inversor Voltaje (24-12)</th>
            <td>bien</td>
        </tr>
    </table>
    <table class='table' width='100%' bgcolor='oldlace' border='3'><br>
        <h3>Habitáculo</h3>
        <tr>
            <th>Habitáculo:</th>
            <td> bien </td>
            <th>Power on amplificador:</th>
            <td> bien </td>
            <th>cable 2x1:</th>
            <td>bien</td>
            <th>Amplificador:</th>
            <td> Bien </td>
        </tr>
        <tr>
            <th>Parlantes:</th>
            <td> bien </td>
            <th>Rejillas:</th>
            <td> bien </td>
            <th>PCB:</th>
            <td>bien</td>
            <th>Arnés:</th>
            <td> Bien </td>
        </tr>
    </table>
    <table width='100%' bgcolor='oldlace' border='3'><br>
        <th>Observaciones:</th>
        <td>Verificar xxx xxx xxx</td>
        <tr></tr>
        <td>El cable xxxxx xxxxx xxx</td>
        <tr></tr>
        <td>Verificar xxx xxx xxx</td>
        <tr></tr>
        <td>El cable xxxxx xxxxx xxx</td>
        <tr></tr>
    </table>
</div>
<div class='buttons'>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $ficha['id'];?>">
        <div class="btn-group" role="group" aria-label="" style="float: right">
            <button type="submit" name="accion" value="Editar" class="btn btn-danger">Editar</button>
            <button type="submit" name="accion" value="Reporte" class="btn btn-dark">Reporte</button>
            <button type="submit" name="accion" value="Volver" class="btn btn-secondary">Volver</button>
        </div>
    </form>
</div>
<?php include("../templates/pie.php"); ?>