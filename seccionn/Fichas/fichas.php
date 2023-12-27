<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<head>
    <title>Fichas</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    </link>
</head>

</html>
<?php include("../../templates/cabeceran.php"); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    function deshabilitarEnlace(event) {
        event.preventDefault();
    }
    document.getElementById('linkFichas').addEventListener('click', deshabilitarEnlace);
});
</script>
<br>
<style>
body {
    background-color: white;
}

h1 {
    color: white;
    text-align: center;
}

h2 {
    color: black;
    text-align: center;
    font-family: Arial Rounded MT;
    font-weight: bold;
    font-size: 50px;
}

p {
    font-family: Arial Rounded MT;
    font-size: 15px;
}

.button {
    margin-left: 85%;
}

.button1 {
    background-color: gray;
    border-radius: 50px;
    border: 2px solid black;
    color: white;
    padding: 7px;
}

.button1:hover,
.button1:active {
    background-color: #fff;
    color: #000;
    transition: background-color 0.3s ease-in, color 0.3s ease-in;
}
</style>
<br>
<?php
//INSERT INTO `datos` (`id`, `placa`, `fecha`) VALUES ('', NULL, current_timestamp())
include_once '../../databases/BD.php';
$conexionBD=BD::crearInstancia();
$consulta=$conexionBD->prepare("SELECT * FROM datos");
$consulta->execute();
$result= $consulta->fetchALL();

$id=isset($_POST['id'])?$_POST['id']:'';

$accion=isset($_POST['accion'])?$_POST['accion']:'';

if($accion!=''){
    switch ($accion) {
        case 'Ver':
            //header('Location: ficha_i.php');
            header('Location: fichas_bus.php?id=' . $id);
            break;
        case 'Borrar':
            try {
                // Comienza la transacción
                $conexionBD->beginTransaction();

                $sql = "DELETE FROM datos WHERE id=:id";
                $consulta=$conexionBD->prepare($sql);
                $consulta->bindParam(':id',$id);
                $consulta->execute();

                // Elimina el registro de la tabla inventario
                $sql = "DELETE FROM inventario WHERE id=:id";
                $consulta=$conexionBD->prepare($sql);
                $consulta->bindParam(':id',$id);
                $consulta->execute();

                $conexionBD->commit();
            } catch (Exception $e) {

                $conexionBD->rollback();
                echo "Error: " . $e->getMessage();
            }
            header ('Location: fichas.php');
            break;
        default:
            break;
    }
}
?>
<br>
<div class='table'>
    <table class='table' width='100' style="border: 2px solid #4DCB45;"><br>
        <tr>
            <th scope='col'>ID</th>
            <th scope='col'>Empresa</th>
            <th scope='col'>Placa</th>
            <th scope='col'>Nombre de conductor</th>
            <th scope='col'>Ultima actualización</th>
            <th scope='col' style="text-align: center;">Acción</th>
        </tr>
        <?php foreach($result as $ficha){?>
        <tr>
            <td> <?php echo $ficha['id']?> </td>
            <td> <?php echo $ficha["Empresa"]?> </td>
            <td> <?php echo $ficha["placa"]?> </td>
            <td> <?php echo $ficha["Nombre"]?> </td>
            <td> <?php echo $ficha["fecha"]?> </td>
            <td style="text-align: center;">
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo $ficha['id'];?>">
                    <div class="btn-group" role="group" aria-label="">
                        <button type="submit" name="accion" value="Ver" class="btn btn-dark">Ver</button>
                    </div>
                </form>
            </td>
        </tr>
        <?php }?>

    </table>
</div>
<div class='button'>
    <form action='Agregar/agregarficha.php' method='post'>
        <button class='button1'> Agregar vehiculo</button>
    </form>
</div>
<br>

<?php include("../../templates/pie.php"); ?>