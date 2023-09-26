<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<head>
    <title> Inicio</title>
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
    background-color: white;
    border: none;
    color: black;
    padding: 10px 15px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
</style>

<div class="col-md-12 d-flex justify-content-center" style="margin-top:150px;">

    <div class=" mb-3">
        <h2>Buscar ficha</h2>
        <form method="post" action="buscarfichas.php">
            <table>
                <tr>
                    <td>
                        <input type="text" class="form-control" name="buscar_valor"
                            placeholder="Ingrese el valor a buscar" style="width: 500px; border-radius: 50px;">
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        <select name="buscar">
                            <option value="placa">Buscar por placa</option>
                            <option value="id">Buscar por id</option>
                            <option value="Empresa">Buscar por empresa</option>
                            <option value="Nombre">Buscar por conductor</option>
                            <option value="Estado">Buscar por estado</option>
                        </select>
                    </td>
                </tr>
                <!--<tr>
                    <td>
                        <br>
                        <input type="submit" class="button" name="b1" value="Buscar" />
                    </td>
                </tr>-->
            </table>
    </div>

</div>

<?php include("../templates/pie.php"); ?>