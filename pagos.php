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

$searchIdSocio = '';
$searchDNI = '';
$searchFechaPago = '';

if (isset($_GET['buscar'])) {
    $searchIdSocio = $_GET['id_socio'];
    $searchDNI = $_GET['dni'];
    $searchFechaPago = $_GET['fecha_pago'];
}

$sql = "SELECT d.disciplina, SUM(p.monto) AS total
        FROM pagos p
        JOIN disciplinas d ON p.id_disciplina = d.id_disciplina
        GROUP BY d.disciplina";
$result = mysqli_query($conexion, $sql);

$disciplinas = [];
$ingresos = [];

while ($row = mysqli_fetch_assoc($result)) {
    $disciplinas[] = $row['disciplina'];
    $ingresos[] = $row['total'];
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pagos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/pagos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
</head>

<body>
    <h1 class="animate__animated animate__backInLeft">Gestión de Pagos</h1>

    <?php if (isset($_SESSION['mensaje'])): ?>
        <p class="animate__animated animate__backInLeft mensaje-confirmacion">
            <?php echo $_SESSION['mensaje']; ?>
        </p>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <button type="button" class="fcc-btn" onclick="window.location.href='index.php'">Volver al Inicio</button>

    <form method="GET" action="pagos.php" class="my-4">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="id_socio" class="form-control" placeholder="Buscar por ID Socio" value="<?php echo $searchIdSocio; ?>">
            </div>
            <div class="col-md-3">
                <input type="text" name="dni" class="form-control" placeholder="Buscar por DNI" value="<?php echo $searchDNI; ?>">
            </div>
            <div class="col-md-3">
                <input type="date" name="fecha_pago" class="form-control" placeholder="Buscar por Fecha de Pago" value="<?php echo $searchFechaPago; ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
            </div>
        </div>
    </form>

    <div class="p-3 table-responsive mb-2">
        <a href="alta_pago.php" class="btn btn-primary mb-1">Registrar Pago</a>
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th class="col-pago-id">Número de Pago</th>
                    <th>ID Socio</th>
                    <th>Disciplina</th>
                    <th>Fecha de Pago</th>
                    <th>Monto</th>
                    <th>Tipo de Pago</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p.id, p.id_socio, p.id_disciplina, p.fecha_pago, p.monto, p.tipo_pago, p.estado, d.disciplina 
                    FROM pagos p 
                    JOIN disciplinas d ON p.id_disciplina = d.id_disciplina 
                    JOIN socios s ON p.id_socio = s.SocioID
                    WHERE 1=1";
                if ($searchIdSocio != '') {
                    $sql .= " AND p.id_socio = '$searchIdSocio'";
                }
                if ($searchDNI != '') {
                    $sql .= " AND s.DNI = '$searchDNI'";
                }
                if ($searchFechaPago != '') {
                    $sql .= " AND p.fecha_pago = '$searchFechaPago'";
                }

                $result = mysqli_query($conexion, $sql);

                while ($row = mysqli_fetch_array($result)) {
                    $tipoPago = str_replace(['cuota_social', 'cuota_deportiva'], ['Cuota Social', 'Cuota Deportiva'], $row["tipo_pago"]);
                ?>
                    <tr>
                        <td class="table-light"><?php echo $row["id"] ?></td>
                        <td class="table-light"><?php echo $row["id_socio"] ?></td>
                        <td class="table-light"><?php echo $row["disciplina"] ?></td>
                        <td class="table-light"><?php echo $row["fecha_pago"] ?></td>
                        <td class="table-light"><?php echo $row["monto"] ?></td>
                        <td class="table-light"><?php echo $tipoPago ?></td>
                        <td class="table-light"><?php echo $row["estado"] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('grafico').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($disciplinas); ?>,
                datasets: [{
                    label: 'Ingresos por Disciplina',
                    data: <?php echo json_encode($ingresos); ?>,
                    backgroundColor: ['#3498db', '#2ecc71', '#e67e22', '#e74c3c', '#2c3e50']
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
    <canvas id="grafico" width="400" height="400"></canvas>

</body>

</html>