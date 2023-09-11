<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<head>
    <title>Agregar ficha</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    </link>
</head>

</html>
<?php include("../templates/cabecera.php"); ?>
<style>
body {
    background-color: orange;
}

.buttons {
    display: flex;
    justify-content: space-between;
    margin: 4px 2px;
}

.btn-black {
    background-color: black;
    color: white;
    border-color: black;
    active-color: black;
    active-border-color: black;
    active-bg: black;
    hover-border-color: black;
    hover-color: black;
    hover-bg: black;
}

.btn-outline-black {
    border-color: black;
    color: black;
    active-color: black;
    active-border-color: black;
    active-bg: black;
    hover-border-color: black;
    hover-color: black;
    hover-bg: black;
}
</style>
<?php
include_once '../databases/BD.php';
$conexionBD=BD::crearInstancia();
$id=isset($_POST['id'])?$_POST['id']:'';
$placa=isset($_POST['placa'])?$_POST['placa']:'';
$accion=isset($_POST['accion'])?$_POST['accion']:'';

if($accion!=''){
    switch ($accion) {
        case 'Guardar':
            $sql="INSERT INTO datos(id, placa,fecha) VALUES ('$id', '$placa', current_timestamp())";
            $consulta=$conexionBD->prepare($sql);
            $consulta->execute(); 
            print("Nuevo registro guardado");
            break;
        case 'Aceptar':
            header('Location: fichas.php');
            break;
        default:
            break;
    }
}
?>



<html>
<div class="container" style="margin-top: 50px; width: 1000px; ">
    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">
            <form action="" method="post">
                <div class="card">
                    <div class="card-header">
                        Agregar ficha
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label for="" class="form-label">ID</label>
                            <input type="number" class="form-control" name="id" id="id" aria-describedby="helpId"
                                placeholder="Ej: 10">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Placa</label>
                            <input type="text" class="form-control" name="placa" id="placa" aria-describedby="helpId"
                                placeholder="Ej: MDM123">
                        </div>

                        <div class="btn-group" role="group" aria-label="">
                            <button type="submit" name="accion" value="Guardar" class="btn btn-black">Guardar</button>
                            <button type="submit" name="accion" value="Aceptar"
                                class="btn btn-outline-black">Aceptar</button>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>

</html>

<?php include("../templates/pie.php"); ?>