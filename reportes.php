<?php
include 'config/conexion.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['export_excel'])) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sql = "SELECT p.id, p.id_socio, d.disciplina, p.fecha_pago, p.monto, p.tipo_pago, p.estado 
            FROM pagos p 
            JOIN disciplinas d ON p.id_disciplina = d.id_disciplina";
    $result = mysqli_query($conexion, $sql);

    $sheet->setCellValue('A1', 'Número de Pago');
    $sheet->setCellValue('B1', 'ID Socio');
    $sheet->setCellValue('C1', 'Disciplina');
    $sheet->setCellValue('D1', 'Fecha de Pago');
    $sheet->setCellValue('E1', 'Monto');
    $sheet->setCellValue('F1', 'Tipo de Pago');
    $sheet->setCellValue('G1', 'Estado');

    $rowCount = 2;
    while ($row = mysqli_fetch_array($result)) {
        $sheet->setCellValue('A' . $rowCount, $row['id']);
        $sheet->setCellValue('B' . $rowCount, $row['id_socio']);
        $sheet->setCellValue('C' . $rowCount, $row['disciplina']);
        $sheet->setCellValue('D' . $rowCount, $row['fecha_pago']);
        $sheet->setCellValue('E' . $rowCount, $row['monto']);
        $sheet->setCellValue('F' . $rowCount, str_replace(['cuota_social', 'cuota_deportiva'], ['Cuota Social', 'Cuota Deportiva'], $row['tipo_pago']));
        $sheet->setCellValue('G' . $rowCount, $row['estado']);
        $rowCount++;
    }

    $writer = new Xlsx($spreadsheet);
    $fileName = 'Reporte_Pagos.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit();
}

$sql = "SELECT p.id, p.id_socio, d.disciplina, p.fecha_pago, p.monto, p.tipo_pago, p.estado 
        FROM pagos p 
        JOIN disciplinas d ON p.id_disciplina = d.id_disciplina";
$result = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes de Pagos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/socios.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
</head>

<body>
    <h1 class="text-center">Reportes de Pagos</h1>

    <div class="container my-4">
        <a href="index.php" class="btn btn-primary mb-3">Volver al Inicio</a>

        <div class="row mb-3">
            <div class="col-auto">
                <form method="post" class="mb-3">
                    <button type="submit" name="export_excel" class="btn btn-success">Exportar a Excel</button>
                </form>
            </div>
            <div class="col-auto">
                <a href="graficos.php" class="btn btn-primary">Gráficos de Ingresos</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Número de Pago</th>
                        <th>ID Socio</th>
                        <th>Disciplina</th>
                        <th>Fecha de Pago</th>
                        <th>Monto</th>
                        <th>Tipo de Pago</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($result)) {
                        $tipoPago = str_replace(['cuota_social', 'cuota_deportiva'], ['Cuota Social', 'Cuota Deportiva'], $row["tipo_pago"]);
                    ?>
                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo $row["id_socio"]; ?></td>
                            <td><?php echo $row["disciplina"]; ?></td>
                            <td><?php echo $row["fecha_pago"]; ?></td>
                            <td><?php echo $row["monto"]; ?></td>
                            <td><?php echo $tipoPago; ?></td>
                            <td><?php echo $row["estado"]; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>