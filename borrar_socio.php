<?php
include 'config/conexion.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$mensaje = '';
$mostrarFormulario = true;
$idSocio = null;

if (isset($_POST['Borrar'])) {
    $idSocio = $_POST['idSocio'];

    $sqlVerificarPagos = "SELECT COUNT(*) AS totalPagos FROM pagos WHERE id_socio = '$idSocio'";

    if ($resultVerificarPagos = mysqli_query($conexion, $sqlVerificarPagos)) {
        $rowVerificarPagos = mysqli_fetch_assoc($resultVerificarPagos);

        if ($rowVerificarPagos['totalPagos'] > 0) {
            $mensaje = "No se puede borrar el socio porque tiene pagos registrados.";
            $mostrarFormulario = false;
        } else {
            $sqlBorrar = "DELETE FROM socios WHERE SocioID = '$idSocio'";
            if (mysqli_query($conexion, $sqlBorrar)) {
                $mensaje = "Socio borrado correctamente.";
                $mostrarFormulario = false;
            } else {
                $mensaje = "Error al borrar el socio: " . mysqli_error($conexion);
                $mostrarFormulario = false;
            }
        }
    } else {
        $mensaje = "Error al verificar pagos: " . mysqli_error($conexion);
        $mostrarFormulario = false;
    }
}


if ($mostrarFormulario && isset($_REQUEST["id"])) {
    $idSocio = $_REQUEST["id"];
    $sql = "SELECT * FROM socios WHERE SocioID = '$idSocio'";
    $result = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_array($result);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Borrar Socio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/socios.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
</head>

<body>
    <main>
        <section id="serSocio" class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-xl-8">
                    <h2 class="text-center">Borrar Socio</h2>
                    <?php if ($mensaje): ?>
                        <div class="alert alert-<?php echo ($mensaje === "Socio borrado correctamente.") ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                            <?php echo $mensaje; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if ($mostrarFormulario): ?>
                        <form action="borrar_socio.php" method="post">
                            <div class="form-floating mb-3">
                                <input name="nombreSocio" id="nombreSocio" type="text" class="form-control" value="<?php echo isset($row['Nombre']) ? $row['Nombre'] . ' ' . $row['Apellido'] : ''; ?>" readonly>
                                <label for="nombreSocio">Nombre del Socio</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="idSocio" id="idSocio" type="text" class="form-control" value="<?php echo isset($row['SocioID']) ? $row['SocioID'] : ''; ?>" readonly>
                                <label for="idSocio">ID del Socio</label>
                            </div>
                            <button type="submit" name="Borrar" class="btn btn-danger btn-lg btn-form">Borrar</button>
                        </form>
                    <?php endif; ?>
                    <a href="socios.php">Volver</a>
                </div>
            </div>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9a3b8D7t6A2mHjA9zRJYlJZsUK8sfYf4zJ8Qf28Ikwxz6xKjhpAX3D9Q2TfUk3j0" crossorigin="anonymous"></script>
</body>

</html>