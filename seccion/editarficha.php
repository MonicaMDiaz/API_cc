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

.tabla {
    background-color: oldlace;
}

textarea {
    width: 100%;
    height: 100%;
    box-sizing: border-box;
    font-family: Arial Rounded MT;
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

$accion=isset($_POST['accion'])?$_POST['accion']:'';

if($accion!=''){
    switch ($accion) {
        case 'Volver':
            header('Location: fichas.php');
            break;
        case 'Guardar':
            $id=$_POST['id'];
            $placa = $_POST['placa'];

            // Actualizar solo el campo placa en la base de datos
            $sql = "UPDATE datos SET placa =:placa WHERE id = $id";
            $consulta = $conexionBD->prepare($sql);
            $consulta->bindParam(':placa', $placa);
            $consulta->execute();
            
            // Recargar los datos actualizados desde la base de datos
            $sql = "SELECT * FROM datos WHERE id = :id";
            $consulta = $conexionBD->prepare($sql);
            $consulta->bindParam(':id', $id);
            $consulta->execute();
            $ficha = $consulta->fetch(PDO::FETCH_ASSOC);

            echo "<h1>Cambios guardados correctamente</h1>";
            break;
        case 'Reporte':
            header('Location: fichas.php');
            break;
        default:
            break;
    }
}
?>

<div style="display: flex; justify-content: space-between;">
    <img src="/images/der.jpg" alt="Cara derecha del bus" width="350" height="250">
    <img src="/images/frente.jpg" alt="Frente del bus" width="450" height="250">
    <img src="/images/frenteiz.jpeg" alt="Cara izquierda del bus" width="450" height="250">
</div>

<div>
    <form action="" method="post">
        <table width='100%' bgcolor='oldlace' border='3'><br>
            <h1>Información vehículo</h1>
            <tr>
                <th>ID de bus:</th>
                <td><?php echo $ficha['id']?></td>
                <th>Placa:</th>
                <td><input type="text" name="placa" value="<?php echo $ficha['placa']?>"></td>
                <th>Empresa:</th>
                <td><input type="text" name="empresa" value="Autobuses"></td>
            </tr>
            <!-- Resto de los campos... -->
        </table>
        <br>
        <!-- Más campos y tablas aquí... -->
        <div class='buttons'>
            <input type="hidden" name="id" value="<?php echo $ficha['id'];?>">
            <div class="btn-group" role="group" aria-label="" style="float: right">
                <button type="submit" name="accion" value="Guardar" class="btn btn-success">Guardar</button>
                <button type="submit" name="accion" value="Reporte" class="btn btn-dark">Reporte</button>
                <button type="submit" name="accion" value="Volver" class="btn btn-secondary">Volver</button>
            </div>
        </div>
    </form>
</div>
<?php include("../templates/pie.php"); ?>