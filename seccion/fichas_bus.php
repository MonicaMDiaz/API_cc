<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<head>
    <title>Fichas</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    </link>
</head>

</html>
<?php include("../templates/cabecera.php"); ?>
<br>
<style>
body {
    background-color: orange;
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

.buttons {
    display: flex;
    justify-content: space-between;
    margin: 4px 2px;
}

.btn-outline-black {
    border-color: black;
    color: white;
    background-color: gray;
    padding: 7px;
}

button1 {
    background-color: gray;
    border-radius: 50px;
    border: 2px solid black;
    color: white;
    padding: 7px;
}

button1:hover,
button1:active {
    background-color: #fff;
    color: #000;
    transition: background-color 0.3s ease-in, color 0.3s ease-in;
}

button {
    border: none;
    color: white;
    padding: 7px;
}

.btn-bd-primary {
    background-color: #28AC8A;
    transition: background-color 0.3s;
}

.btn-bd-primary:hover {
    background-color: #228B6D;
}

.btn-bd-primary.clicked {
    background-color: #228B6D;
}
</style>
<br>
<?php
//INSERT INTO `datos` (`id`, `placa`, `fecha`) VALUES ('', NULL, current_timestamp())
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
        case 'Ver':
            //header('Location: ficha_i.php');
            header('Location: ficha_i.php?id=' . $id);
            break;
        case 'Editar':
            header('Location: editarficha.php?id=' . $id);
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
    <table class='table' width='100' bgcolor='oldlace'><br>
        <tr>
            <th scope='col'>ID</th>
            <th scope='col'>Empresa</th>
            <th scope='col'>Placa</th>
            <th scope='col'>Nombre de conductor</th>
            <th scope='col'>Ultima actualización</th>
            <th scope='col' style="text-align: center;">Acción</th>
        </tr>
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
                        <button type="submit" name="accion" value="Editar" class="btn btn-success">Editar</button>
                        <button type="submit" name="accion" value="Borrar" class="btn btn-danger"
                            onclick="return confirm('¿Estás seguro de que quieres borrar este registro?');">Borrar</button>
                    </div>
                </form>
            </td>
        </tr>

    </table>
</div>
<div class='button'>
    <form action='agregarficha.php' method='post'>
        <button1>Agregar vehiculo</button>
    </form>
</div>
<br>

<?php include("../templates/pie.php"); ?>