<<?php
    include 'config/conexion.php';
    session_start();


    if (!isset($_SESSION['usuario'])) {
        header("Location: login.php");
        exit();
    }

    if (isset($_POST['Borrar'])) {
        $id_disciplina = $_POST['id_disciplina'];
        $disciplina = $_POST['disciplina'];

        $sql = "DELETE FROM disciplinas WHERE id_disciplina = '$id_disciplina'";

        if (mysqli_query($conexion, $sql)) {
            $mensaje = "Disciplina borrada correctamente: " . $disciplina;
            header("Location: disciplinas.php?mensaje=" . urlencode($mensaje));
            exit();
        } else {
            echo "Error al borrar la disciplina: " . mysqli_error($conexion);
        }
    }


    ob_end_flush();
    ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Borrar Disciplina</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
        <link rel="stylesheet" href="css/disciplinas.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
    </head>

    <body>
        <main>
            <section id="serDisciplina" class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7 col-xl-8">
                        <h2 class="text-center">Modificar Disciplina</h2>
                        <?php
                        $id_disciplina = $_REQUEST["id"];
                        $sql = "SELECT * FROM disciplinas WHERE id_disciplina ='$id_disciplina'";
                        $result = mysqli_query($conexion, $sql);
                        $row = mysqli_fetch_array($result);
                        ?>
                        <form action="borrar_disciplina.php" method="post">
                            <div class="form-floating mb-3">
                                <input name="disciplina" id="nombreDisciplina" type="text" class="form-control" value="<?php echo $row['disciplina']; ?>" required>
                                <label for="nombreDisciplina">Nombre de la Disciplina</label>
                                <input name="id_disciplina" type="hidden" value="<?php echo $row['id_disciplina']; ?>">
                            </div>
                            <button type="submit" name="Borrar" class="btn btn-success btn-lg btn-form">Borrar</button>
                        </form>
                        <a href="disciplinas.php">Volver</a>
                    </div>
                </div>
            </section>
        </main>
    </body>

    </html>