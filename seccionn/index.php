<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<head>
    <title> Inicio</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    </link>
</head>

</html>
<?php include("../templates/cabeceran.php"); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    function deshabilitarEnlace(event) {
        event.preventDefault();
    }
    document.getElementById('linkInicio').addEventListener('click', deshabilitarEnlace);
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
    font-family: Arial;
    font-size: 20px;
    line-height: 1.5;
}

i {
    font-weight: bold;
}

.button {
    background-color: #4DCB45;
    border-radius: 10px;
    border: 2px solid;
    color: white;
    padding: 7px;
    width: 180px;
}
</style>

<div class="col-md-6 d-flex justify-content-center" style="margin-top:150px;">
    <div class=" mb-3">
        <h2>Buscar ficha</h2>
        <form method="post" action="buscarfichas.php">
            <table>
                <tr>
                    <td colspan="2">
                        <input type="text" class="form-control" name="buscar_valor"
                            placeholder="Ingrese el valor a buscar"
                            style="width: 500px; border-radius: 50px; border: 2px solid #ea5d2d;">
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        <select name="buscar" class="form-control" style="width: 300px; border: 2px solid #4DCB45;">
                            <option value="id">Buscar por id</option>
                            <option value="Empresa">Buscar por empresa</option>
                            <option value="placa">Buscar por placa</option>
                            <option value="Nombre">Buscar por conductor</option>
                            <option value="Estado">Buscar por estado</option>
                        </select>
                    </td>
                    <td>
                        <br>
                        <input type="submit" class="button" name="b1" value="Buscar" />
                    </td>
                </tr>
            </table>
    </div>

</div>
<div class="col-md-1"></div>
<div class="col-md-5 d-flex justify-content-center" style="margin-top:130px;">
    <div class=" mb-3">
        <p>
            <strong>id:</strong> Número de identificación del bus. Ejemplo: 337,291,471.
            <br>
            <br>
            <strong>Empresa:</strong> Las empresas disponibles son: Autobuses, Cootranur, Americana y Tesa.
            <br>
            <br>
            <strong>Placa:</strong> Placa del vehículo.
            <br>
            <br>
            <strong>Conductor:</strong> Nombre y/o apellido del conductor del bus.
            <br>
            <br>
            <strong>Estado:</strong> Los estados disponibles son: Activo, inactivo y en reparación.
        </p>
    </div>

</div>

<?php include("../templates/pie.php"); ?>