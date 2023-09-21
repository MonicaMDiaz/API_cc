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
</style>
<br>

<?php
//INSERT INTO `datos` (`id`, `placa`, `fecha`) VALUES ('', NULL, current_timestamp())
include_once '../databases/BD.php';
$conexionBD=BD::crearInstancia();

//$buscar = $_POST['buscar'];
//$buscar_valor = $_POST['buscar_valor'];
if (isset($_POST['buscar'])) {
    $buscar = $_POST['buscar'];
    echo $buscar;}

if (isset($_POST['buscar_valor'])) {
    $buscar_valor = $_POST['buscar_valor'];
    echo $buscar_valor;

    if ($buscar == "placa") {
        $sql_busca = "SELECT placa,id,fecha from datos WHERE placa LIKE '%".$buscar_valor."%'";
        $consulta=$conexionBD->prepare($sql_busca);
        $consulta->execute();
        $result= $consulta->fetchALL();}

    
    else if ($buscar == "id") {
        $sql_busca = "SELECT placa,id,fecha from datos WHERE id=".$buscar_valor;
        $consulta=$conexionBD->prepare($sql_busca);
        $consulta->execute();
        $result= $consulta->fetchALL();
    }
    else {
        echo "Opción no válida";
    }

    
}

$id=isset($_POST['id'])?$_POST['id']:'';
$placa=isset($_POST['placa'])?$_POST['placa']:'';
$accion=isset($_POST['accion'])?$_POST['accion']:'';

if($accion!=''){
    switch ($accion) {
        case 'Ver':
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
            <th scope='col'>id</th>
            <th scope='col'>placa</th>
            <th scope='col'>fecha</th>
            <th scope='col'>Acción</th>
        </tr>
        <?php foreach($result as $ficha){?>
        <tr>
            <td> <?php echo $ficha['id']?> </td>
            <td> <?php echo $ficha["placa"]?> </td>
            <td> <?php echo $ficha["fecha"]?> </td>
            <td>
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo $ficha['id'];?>">
                    <div class="btn-group" role="group" aria-label="">
                        <button type="submit" name="accion" value="Ver" class="btn btn-dark">Ver</button>
                        <button type="submit" name="accion" value="Editar" class="btn btn-success">Editar</button>
                        <button type="submit" name="accion" value="Borrar" class="btn btn-danger">Borrar</button>
                    </div>
                </form>
            </td>
        </tr>
        <?php }?>

    </table>
</div>
<div class='button'>
    <form action='agregarficha.php' method='post'>
        <input type='submit' value='Agregar' name='agregarficha' class='btn btn-secondary'>
    </form>
</div>
<br>

<?php include("../templates/pie.php"); ?>