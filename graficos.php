<?php
include 'config/conexion.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$sqlDisciplinas = "SELECT disciplina FROM disciplinas";
$resultDisciplinas = mysqli_query($conexion, $sqlDisciplinas);

$disciplinas = [];
$ingresos = [];

$sqlIngresos = "SELECT d.disciplina, SUM(p.monto) as total_ingresos 
                FROM pagos p 
                JOIN disciplinas d ON p.id_disciplina = d.id_disciplina
                GROUP BY d.disciplina";
$resultIngresos = mysqli_query($conexion, $sqlIngresos);

while ($row = mysqli_fetch_assoc($resultIngresos)) {
    $disciplinas[] = $row['disciplina'];
    $ingresos[] = $row['total_ingresos'];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráficos de Ingresos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/graficos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <h1 class="animate__animated animate__backInLeft">Gráficos de Ingresos</h1>

    <div class="container my-4">
        <div class="row mb-3">
            <div class="col text-center">
                <button type="button" class="fcc-btn" onclick="window.location.href='reportes.php'">Volver a Reportes</button>
            </div>
        </div>
        <div class="row">
            <div class="col text-center btn-group">
                <button id="btnTorta" class="btn btn-primary">Gráfico de Torta</button>
                <button id="btnBarras" class="btn btn-secondary">Gráfico de Barras</button>
                <button id="exportarImagen" class="btn btn-success">Exportar Gráfico</button>
            </div>
        </div>

        <div class="chart-container">
            <canvas id="graficoTorta"></canvas>
            <canvas id="graficoBarras" style="display:none;"></canvas>
        </div>
    </div>

    <script>
        const disciplinas = <?php echo json_encode($disciplinas); ?>;
        const ingresos = <?php echo json_encode($ingresos); ?>;


        const colores = {
            azulMedianoche: '#2c3e50',
            azulCielo: '#3498db',
            verdeEsmeralda: '#2ecc71',
            naranja: '#e67e22',
            rojoCoral: '#e74c3c'
        };


        const data = {
            labels: disciplinas,
            datasets: [{
                label: 'Ingresos por Disciplina',
                data: ingresos,
                backgroundColor: [colores.azulCielo, colores.verdeEsmeralda, colores.naranja, colores.rojoCoral],
                borderColor: colores.azulMedianoche,
                borderWidth: 1
            }]
        };

        const configTorta = {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        };

        const configBarras = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + '$';
                            }
                        }
                    }
                }
            }
        };

        const graficoTorta = new Chart(
            document.getElementById('graficoTorta'),
            configTorta
        );

        const graficoBarras = new Chart(
            document.getElementById('graficoBarras'),
            configBarras
        );

        document.getElementById('btnTorta').addEventListener('click', function() {
            document.getElementById('graficoTorta').style.display = 'block';
            document.getElementById('graficoBarras').style.display = 'none';
        });

        document.getElementById('btnBarras').addEventListener('click', function() {
            document.getElementById('graficoTorta').style.display = 'none';
            document.getElementById('graficoBarras').style.display = 'block';
        });

        document.getElementById('exportarImagen').addEventListener('click', function() {
            let canvas;
            if (document.getElementById('graficoTorta').style.display === 'block') {
                canvas = document.getElementById('graficoTorta');
            } else {
                canvas = document.getElementById('graficoBarras');
            }
            const link = document.createElement('a');
            link.download = 'grafico.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        });
    </script>
</body>

</html>