<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <?php include("../templates/cabecera.php"); ?>
    <br>
    <style>
    /* Estilos CSS */
    </style>
    <br>

    <?php
    include_once '../databases/BD.php';
    $conexionBD = BD::crearInstancia();
    $consulta = $conexionBD->prepare("SELECT * FROM usuarios");
    $consulta->execute();
    $result = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';

    if ($accion != '') {
        switch ($accion) {
            case 'Ver':
                if (isset($_POST['id_cargo']) && isset($id)) {
                    $id_cargo = $_POST['id_cargo'];
                    $sql = "UPDATE usuarios SET id_cargo = :id_cargo WHERE id = :id";
                    $consulta = $conexionBD->prepare($sql);
                    $consulta->bindParam(':id_cargo', $id_cargo);
                    $consulta->bindParam(':id', $id);
                    $consulta->execute();
                    
                    // Recargar la información actualizada
                    $sql = "SELECT * FROM usuarios WHERE id = :id";
                    $consulta = $conexionBD->prepare($sql);
                    $consulta->bindParam(':id', $id);
                    $consulta->execute();
                    $ficha = $consulta->fetch(PDO::FETCH_ASSOC);
                    
                    // Enviar la respuesta al cliente
                    echo json_encode($ficha);
                    exit();
                }
                break;
            case 'Borrar':
                try {
                    $conexionBD->beginTransaction();
                    $sql = "DELETE FROM usuarios WHERE id=:id";
                    $consulta = $conexionBD->prepare($sql);
                    $consulta->bindParam(':id', $id);
                    $consulta->execute();
                    $conexionBD->commit();
                } catch (Exception $e) {
                    $conexionBD->rollback();
                    echo "Error: " . $e->getMessage();
                }
                header('Location: usuarios.php');
                break;
            default:
                break;
        }
    }
    ?>
    <h1></h1>
    <br>
    <div class='table'>
        <table class='table' width='100' style="border: 2px solid #4DCB45;">
            <tr>
                <th scope='col'>Nombre</th>
                <th scope='col'>celular</th>
                <th scope='col'>Usuario</th>
                <th scope='col'>Tipo de usuario</th>
                <th scope='col' style="text-align: center;">Acción</th>
            </tr>
            <?php foreach ($result as $ficha) { ?>
            <tr>
                <td><?php echo $ficha["Nombre"] ?></td>
                <td><?php echo $ficha["celular"] ?></td>
                <td><?php echo $ficha["usuario"] ?></td>
                <td>
                    <?php
                        $opciones = array("Administrador", "Persona natural");
                        $index = array_search($ficha["id_cargo"], $opciones);
                        if ($index !== false) {
                            unset($opciones[$index]);
                        }
                        ?>
                    <select class="form-control" name="id_cargo" id="selectIdCargo_<?php echo $ficha['id']; ?>">
                        <?php foreach ($opciones as $valor) : ?>
                        <option value="<?php echo array_search($valor, $opciones) + 1; ?>"
                            <?php echo ($ficha["id_cargo"] == array_search($valor, $opciones) + 1) ? 'selected' : ''; ?>>
                            <?php echo $valor; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td style="text-align: center;">
                    <form class="update-form" data-id="<?php echo $ficha['id']; ?>">
                        <input type="hidden" name="id" value="<?php echo $ficha['id']; ?>">
                        <div class="btn-group" role="group" aria-label="">
                            <button type="button" class="btn btn-success update-btn">Actualizar</button>
                            <button type="submit" name="accion" value="Borrar" class="btn btn-danger"
                                onclick="return confirm('¿Estás seguro de que quieres borrar este registro?');">Borrar</button>
                        </div>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
    <br>

    <?php include("../templates/pie.php"); ?>

    <script>
    // Capturar el evento click del botón de actualizar
    $(".update-btn").click(function() {
        // Obtener el valor seleccionado del select
        var nuevoIdCargo = $("#selectIdCargo_" + $(this).closest('form').data('id')).val();
        // Obtener el id del registro actual
        var idRegistro = $(this).closest('form').data('id');

        // Enviar la solicitud AJAX para actualizar id_cargo
        $.ajax({
            type: "POST",
            url: "usuarios.php", // Reemplaza con la ruta correcta de tu archivo PHP de actualización
            data: {
                id: idRegistro,
                id_cargo: nuevoIdCargo,
                accion: 'Ver'
            },
            success: function(response) {
                // Recargar la página o manejar la respuesta si es necesario
                window.location.reload();
            },
            error: function(error) {
                // Manejar errores si es necesario
                console.log(error);
            }
        });
    });
    </script>
</body>

</html>