<?php
include 'config/conexion.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$mensaje = '';
if (isset($_GET['mensaje'])) {
    $mensaje = urldecode($_GET['mensaje']);
    echo '<div class="alert alert-success animate__animated animate__backInLeft">' . $mensaje . '</div>';
}

$searchId = '';
$searchApellido = '';
$searchDNI = '';

if (isset($_GET['buscar'])) {
    $searchId = $_GET['id_socio'];
    $searchApellido = $_GET['apellido'];
    $searchDNI = $_GET['dni'];
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Socios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/socios.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
</head>

<body>

    <h1 class="animate__animated animate__backInLeft">Gestión de Socios</h1>

    <?php if (isset($_SESSION['mensaje'])): ?>
        <p class="animate__animated animate__backInLeft mensaje-confirmacion">
            <?php echo $_SESSION['mensaje']; ?>
        </p>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <button type="button" class="fcc-btn" onclick="window.location.href='index.php'">Volver al Inicio</button>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="socios.php" class="my-4">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="id_socio" class="form-control" placeholder="Buscar por ID Socio" value="<?php echo $searchId; ?>">
            </div>
            <div class="col-md-3">
                <input type="text" name="apellido" class="form-control" placeholder="Buscar por Apellido" value="<?php echo $searchApellido; ?>">
            </div>
            <div class="col-md-3">
                <input type="text" name="dni" class="form-control" placeholder="Buscar por DNI" value="<?php echo $searchDNI; ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
            </div>
        </div>
    </form>

    <div class="p-3 table-responsive mb-2">
        <table class="table table-hover table-striped">
            <a href="alta_socio.php" class="btn btn-primary mb-1">Registrar</a>
            <thead>
                <tr>
                    <th class="col-socio-id">Socio Id</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th class="col-edad">Edad</th>
                    <th>DNI</th>
                    <th class="col-telefono">Telefono</th>
                    <th class="col-direccion">Direccion</th>
                    <th class="col-contacto">Contacto Familiar</th>
                    <th class="col-telefono-fam">Telefono Familiar</th>
                    <th class="col-acciones">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $sql = "SELECT * FROM socios WHERE 1=1";
                if ($searchId != '') {
                    $sql .= " AND SocioID = '$searchId'";
                }
                if ($searchApellido != '') {
                    $sql .= " AND Apellido LIKE '%$searchApellido%'";
                }
                if ($searchDNI != '') {
                    $sql .= " AND DNI = '$searchDNI'";
                }

                $result = mysqli_query($conexion, $sql);

                while ($row = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td class="table-light"><?php echo $row["SocioID"] ?></td>
                        <td class="table-light"><?php echo $row["Nombre"] ?></td>
                        <td class="table-light"><?php echo $row["Apellido"] ?></td>
                        <td class="table-light"><?php echo $row["Edad"] ?></td>
                        <td class="table-light"><?php echo $row["DNI"] ?></td>
                        <td class="table-light"><?php echo $row["Telefono"] ?></td>
                        <td class="table-light"><?php echo $row["Direccion"] ?></td>
                        <td class="table-light"><?php echo $row["ContactoFamiliar"] ?></td>
                        <td class="table-light"><?php echo $row["TelefonoFamiliar"] ?></td>
                        <td>
                            <a class="fcc-btn" href="modif_socio.php?id=<?php echo $row["SocioID"] ?>">Modificar</a>
                            <a class="fcc-btn-alt" href="borrar_socio.php?id=<?php echo $row["SocioID"] ?>">Borrar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>

</html>