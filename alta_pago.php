<?php
include 'config/conexion.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$mensaje = '';
$searchId = '';
$searchDNI = '';
$searchFechaPago = '';
$showSearchForm = true; // Variable para controlar la visibilidad del formulario de búsqueda
$socio = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idSocio = $_POST['id_socio'];
    $idDisciplina = $_POST['id_disciplina'];
    $fechaPago = $_POST['fecha_pago'];
    $tipoPago = $_POST['tipo_pago'];
    $estado = $_POST['estado'];

    // Obtener el monto basado en el tipo de pago seleccionado
    $tiposPago = [
        'cuota_social' => 10000.00,
        'cuota_deportiva' => 15000.00
    ];
    $monto = isset($tiposPago[$tipoPago]) ? $tiposPago[$tipoPago] : 0;

    $sql = "INSERT INTO pagos (id_socio, id_disciplina, fecha_pago, monto, tipo_pago, estado) 
            VALUES ('$idSocio', '$idDisciplina', '$fechaPago', '$monto', '$tipoPago', '$estado')";

    if (mysqli_query($conexion, $sql)) {
        $mensaje = "Pago registrado exitosamente!";
        header("Location: pagos.php?mensaje=" . urlencode($mensaje));
        exit();
    } else {
        $mensaje = "Error al registrar el pago: " . mysqli_error($conexion);
    }
}

if (isset($_GET['buscar'])) {
    $searchId = $_GET['id_socio'];
    $searchDNI = $_GET['dni'];
    $searchFechaPago = $_GET['fecha_pago'];
    $showSearchForm = false; // Ocultar el formulario de búsqueda

    // Construir la consulta SQL según los criterios de búsqueda
    $sql = "SELECT * FROM socios WHERE 1=1";
    if ($searchId != '') {
        $sql .= " AND SocioID = '$searchId'";
    }
    if ($searchDNI != '') {
        $sql .= " AND DNI = '$searchDNI'";
    }
    if ($searchFechaPago != '') {
        $sql .= " AND FechaPago = '$searchFechaPago'"; // Asegúrate de que este campo existe en la tabla socios o ajústalo según tu estructura
    }

    $result = mysqli_query($conexion, $sql);
    $socio = mysqli_fetch_assoc($result);
}

$disciplinasQuery = "SELECT id_disciplina, disciplina FROM disciplinas";
$disciplinasResult = mysqli_query($conexion, $disciplinasQuery);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/pagos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
</head>

<body>

    <h1 class="animate__animated animate__backInLeft">Registrar Pago</h1>

    <?php if ($mensaje != ''): ?>
        <div class="alert alert-warning animate__animated animate__backInLeft">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <button type="button" class="fcc-btn" onclick="window.location.href='pagos.php'">Volver a Pagos</button>

    <?php if ($showSearchForm): ?>
        <!-- Formulario de búsqueda -->
        <form method="GET" action="alta_pago.php" class="my-4">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="id_socio" class="form-control" placeholder="Buscar por ID Socio" value="<?php echo $searchId; ?>">
                </div>
                <div class="col-md-4">
                    <input type="text" name="dni" class="form-control" placeholder="Buscar por DNI" value="<?php echo $searchDNI; ?>">
                </div>
                <div class="col-md-4">
                    <input type="date" name="fecha_pago" class="form-control" placeholder="Buscar por Fecha de Pago" value="<?php echo $searchFechaPago; ?>">
                </div>
                <div class="col-md-12 my-2">
                    <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>
    <?php endif; ?>

    <?php if (!$showSearchForm && $socio): ?>
        <!-- Datos del socio y formulario de registro de pago -->
        <div class="my-4">
            <h3>Datos del Socio</h3>
            <p><strong>ID Socio:</strong> <?php echo $socio['SocioID']; ?></p>
            <p><strong>Nombre:</strong> <?php echo $socio['Nombre']; ?></p>
            <p><strong>Apellido:</strong> <?php echo $socio['Apellido']; ?></p>
            <p><strong>DNI:</strong> <?php echo $socio['DNI']; ?></p>
        </div>

        <!-- Formulario de registro de pago pre-cargado -->
        <form method="POST" action="alta_pago.php" class="my-4">
            <input type="hidden" name="id_socio" value="<?php echo $socio['SocioID']; ?>">
            <div class="row">
                <div class="col-md-6">
                    <label for="tipo_pago" class="form-label">Tipo de Pago</label>
                    <select name="tipo_pago" class="form-control" required>
                        <option value="cuota_social">Cuota Social</option>
                        <option value="cuota_deportiva">Cuota Deportiva</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="estado" class="form-label">Estado</label>
                    <select name="estado" class="form-control" required>
                        <option value="Pagado">Pagado</option>
                        <option value="Pendiente">Pendiente</option>
                    </select>
                </div>
            </div>

            <div class="row my-3">
                <div class="col-md-6">
                    <label for="id_disciplina" class="form-label">Disciplina</label>
                    <select name="id_disciplina" class="form-control" required>
                        <?php while ($row = mysqli_fetch_assoc($disciplinasResult)): ?>
                            <option value="<?php echo $row['id_disciplina']; ?>">
                                <?php echo $row['disciplina']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="fecha_pago" class="form-label">Fecha de Pago</label>
                    <input type="date" name="fecha_pago" class="form-control" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Registrar Pago</button>
        </form>
    <?php endif; ?>

</body>

</html>
