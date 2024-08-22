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

$sql = "SELECT id_disciplina, disciplina FROM disciplinas";
$result = mysqli_query($conexion, $sql);

$disciplinas = [];
while ($row = mysqli_fetch_assoc($result)) {
    $disciplinas[$row['id_disciplina']] = $row['disciplina'];
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disciplinas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/disciplinas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
</head>

<body>
    <h1 class="animate__animated animate__backInLeft">Gestión de Disciplinas</h1>

    <?php if (isset($_SESSION['mensaje'])): ?>
        <p class="animate__animated animate__backInLeft mensaje-confirmacion">
            <?php echo $_SESSION['mensaje']; ?>
        </p>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <button type="button" class="fcc-btn" onclick="window.location.href='index.php'">Volver al Inicio</button>

    <div class="p-3 table-responsive mb-2">
        <a href="alta_disciplina.php" class="btn btn-primary mb-1">Registrar</a>
        <br />
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Nombre Disciplina</th>
                    <th>Modificar</th>
                    <th>Borrar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM disciplinas";
                $result = mysqli_query($conexion, $sql);
                while ($row = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td class="table-light"><?php echo $row["disciplina"] ?></td>
                        <td><a class="fcc-btn" href="modif_disciplina.php?id=<?php echo $row["id_disciplina"] ?>">Modificar</a></td>
                        <td><a class="fcc-btn-alt" href="borrar_disciplina.php?id=<?php echo $row["id_disciplina"] ?>">Borrar</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>