<!DOCTYPE html>
<html lang="en">

<head>
    <title>Editar perfil</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <?php include("../templates/cabecera.php"); ?>

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
    }

    p {
        font-family: verdana;
        font-size: 15px;
    }

    button {
        background-color: #4DCB45;
        border-radius: 50px;
        border: 2px solid;
        color: white;
        padding: 7px;
        width: 100%;
    }

    button:hover,
    button:active {
        background-color: #fff;
        color: #000;
        transition: background-color 0.3s ease-in, color 0.3s ease-in;
    }

    .card-header {
        background-color: #ea5d2d;
        text-align: center;
        color: white;
    }
    </style>


    <?php

include_once '../databases/BD.php';
$conexionBD = BD::crearInstancia();

// Comprobar si la sesión no está iniciada
if (!isset($_SESSION)) {
    session_start();
}

// Comprobar si el usuario está logueado
if (isset($_SESSION['usuario'])) {
    $user = $_SESSION['usuario'];
    $sql = "SELECT * FROM usuarios WHERE usuario = :user";
    $consulta = $conexionBD->prepare($sql);
    $consulta->bindParam(':user', $user);
    $consulta->execute();
    $ficha = $consulta->fetch(PDO::FETCH_ASSOC);
    $id = $ficha['id'];
    
    $accion=isset($_POST['accion'])?$_POST['accion']:'';
    if($accion!=''){
        switch ($accion) {
            case 'Guardar':
                // Recuperar los datos del formulario
                $nombre = $_POST['Nombre'];
                $celular = $_POST['celular'];
                $usuario = $_POST['usuario'];
                $contrasena = $_POST['contraseña']; // Ten en cuenta que esto podría no ser seguro, se recomienda hash de contraseñas

                // Actualizar la base de datos con los nuevos datos
                if ($nombre != $ficha['Nombre'] || $celular != $ficha['celular']) {
                    // Actualizar la base de datos con los nuevos datos
                    $sqlUpdate = "UPDATE usuarios SET Nombre = :nombre, celular = :celular WHERE id = :id";
                    $consultaUpdate = $conexionBD->prepare($sqlUpdate);
                    $consultaUpdate->bindParam(':nombre', $nombre);
                    $consultaUpdate->bindParam(':celular', $celular);
                    $consultaUpdate->bindParam(':id', $id);
                    $consultaUpdate->execute();

                    $sql = "SELECT * FROM usuarios WHERE id = :id";
                    $consulta = $conexionBD->prepare($sql);
                    $consulta->bindParam(':id', $id);
                    $consulta->execute();
                    $ficha = $consulta->fetch(PDO::FETCH_ASSOC);
                    
                } else if ( $usuario != $ficha['usuario'] || $contrasena != $ficha['contraseña']) {
                    $sqlUpdate = "UPDATE usuarios SET usuario = :usuario, contraseña = :contrasena WHERE id = :id";
                    $consultaUpdate = $conexionBD->prepare($sqlUpdate);
                    $consultaUpdate->bindParam(':usuario', $usuario);
                    $consultaUpdate->bindParam(':contrasena', $contrasena);
                    $consultaUpdate->bindParam(':id', $id);
                    $consultaUpdate->execute();
                    echo '<script>alert("Perfil actualizado correctamente");';
                    echo 'window.location.href = "../iniciosesion.html";</script>';
                }else {
                    // Mostrar un mensaje de que no hubo cambios significativos en el perfil
                    echo '<script>alert("No se realizaron cambios significativos en el perfil");</script>';
                }
                break;
        }
                
    }
?>
    <br>
    <div class="container" style="margin-top: 50px; width: 1000px; ">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form action="" method="post">
                    <div class="card">
                        <div class="card-header">
                            Editar perfil
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="Nombre"
                                    value="<?php echo $ficha['Nombre']?>">

                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Celular</label>
                                <input type="number" class="form-control" name="celular"
                                    value="<?php echo $ficha['celular']?>">

                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Usuario</label>
                                <input type="text" class="form-control" name="usuario"
                                    value="<?php echo $ficha['usuario']?>">

                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="contraseña"
                                        value="<?php echo $ficha['contraseña']?>">
                                    <input class="btn btn-outline-secondary" type="checkbox" id="togglePassword">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                    </input>
                                </div>
                            </div>

                            <script>
                            document.getElementById('togglePassword').addEventListener('click', function() {
                                var passwordInput = document.getElementById('password');
                                var icon = this.querySelector('i');
                                if (passwordInput.type === 'password') {
                                    passwordInput.type = 'text';
                                    icon.classList.remove('fa-eye');
                                    icon.classList.add('fa-eye-slash');
                                } else {
                                    passwordInput.type = 'password';
                                    icon.classList.remove('fa-eye-slash');
                                    icon.classList.add('fa-eye');
                                }
                            });
                            </script>

                        </div>
                    </div>
                    <br>
                    <input type="hidden" name="id" value="<?php echo $ficha['id'];?>">
                    <button type="submit" name="accion" value="Guardar"
                        onclick="return confirm('¿Editar cambios?');">Editar</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>
<?php
} else {
    // Redirigir al usuario a la página de login
    header("Location: iniciosesion.html");
    exit(); // Asegúrate de salir después de redirigir
}
?>