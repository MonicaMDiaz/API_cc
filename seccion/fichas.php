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
$sql=$conexionBD->prepare("SELECT * FROM datos");
$sql->execute();
$result= $sql->fetchALL();

$id=isset($_POST['id'])?$_POST['id']:'';
$placa=isset($_POST['placa'])?$_POST['placa']:'';

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
                <div class='buttons'>
                    <form action='ficha_i.php' method='post'>
                        <input type='submit' value='Ver' name='ver' class='btn btn-dark'>
                    </form>
                    <form action='editarficha.php' method='post'>
                        <input type='submit' value='Editar' name='editarficha' class='btn btn-success'>
                    </form>
                    <form action='borrarficha.php' method='post'>
                        <input type='submit' value='Borrar' name='borrarficha' class='btn btn-danger'>
                    </form>
                </div>
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