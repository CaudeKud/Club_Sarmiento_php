<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
</head>

<body>
    <form action="index.php" method="post">
        <h1 class="animate__animated animate__backInLeft">Página de Inicio</h1>
        <button type="button" class="fcc-btn" onclick="window.location.href='socios.php'">Socios</button>
        <button type="button" class="fcc-btn" onclick="window.location.href='disciplinas.php'">Disciplinas</button>
        <button type="button" class="fcc-btn" onclick="window.location.href='pagos.php'">Pagos</button>
        <button type="button" class="fcc-btn" onclick="window.location.href='reportes.php'">Reportes</button>
        <button type="button" class="fcc-btn-alt" onclick="window.location.href='login.php'">Cerrar sesión</button>
    </form>
</body>

</html>