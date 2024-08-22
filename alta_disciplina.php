<?php
include 'config/conexion.php';

if (isset($_POST['Alta'])) {

    $disciplina = $_POST['disciplina'];

    $disciplina = mysqli_real_escape_string($conexion, $disciplina);

    $sql = "INSERT INTO disciplinas (disciplina) VALUES ('$disciplina')";

    if (mysqli_query($conexion, $sql)) {
        $mensaje = "Disciplina creada correctamente: " . $disciplina;
        header("Location: disciplinas.php?mensaje=" . urlencode($mensaje));
        exit();
    } else {
        echo "Error al crear la disciplina: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta Disciplina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/disciplinas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
</head>

<body>
    <header>
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.html"></a>
            </div>
        </nav>
    </header>
    <main>
        <section id="serSocio" class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-xl-8">
                    <p class="text-center">Cargar una nueva</p>
                    <h2 class="text-center">DISCIPLINA</h2>
                    <form action="alta_disciplina.php" method="post">
                        <div class="row gx-2">
                            <div class="form-floating col-md mb-3">
                                <input name="disciplina" id="form_disciplina" type="text" class="form-control" placeholder="nombre de la Disciplina" aria-label="Disciplina" required>
                                <label for="form_disciplina">Nombre Disciplina</label>
                            </div>
                            <div class="d-grid">
                                <button type="submit" name="Alta" class="btn btn-success btn-lg btn-form">Enviar</button>
                            </div>
                        </div>
                    </form>
                    <a href="disciplinas.php">Volver</a>
                </div>
            </div>
        </section>
    </main>
    <footer></footer>
</body>

</html>