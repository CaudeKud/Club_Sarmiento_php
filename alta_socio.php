<?php
include 'config/conexion.php';

if (isset($_POST['Alta'])) {

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fechaNacimiento = $_POST['fecha_nacimiento'];
    $edad = $_POST['edad'];
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $mail = $_POST['mail'];
    $foto = $_POST['foto'];
    $contactoFamiliar = $_POST['contacto_familiar'];
    $telefonoFamiliar = $_POST['telefono_familiar'];
    $categoriaID = $_POST['categoria_id'];

    // Protección contra inyección SQL
    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $apellido = mysqli_real_escape_string($conexion, $apellido);
    $fechaNacimiento = mysqli_real_escape_string($conexion, $fechaNacimiento);
    $edad = mysqli_real_escape_string($conexion, $edad);
    $dni = mysqli_real_escape_string($conexion, $dni);
    $telefono = mysqli_real_escape_string($conexion, $telefono);
    $direccion = mysqli_real_escape_string($conexion, $direccion);
    $mail = mysqli_real_escape_string($conexion, $mail);
    $foto = mysqli_real_escape_string($conexion, $foto);
    $contactoFamiliar = mysqli_real_escape_string($conexion, $contactoFamiliar);
    $telefonoFamiliar = mysqli_real_escape_string($conexion, $telefonoFamiliar);
    $categoriaID = mysqli_real_escape_string($conexion, $categoriaID);

    $sql = "INSERT INTO socios (Nombre, Apellido, FechaNacimiento, Edad, DNI, Telefono, Direccion, Mail, Foto, ContactoFamiliar, TelefonoFamiliar, CategoriaID) 
            VALUES ('$nombre', '$apellido', '$fechaNacimiento', '$edad', '$dni', '$telefono', '$direccion', '$mail', '$foto', '$contactoFamiliar', '$telefonoFamiliar', '$categoriaID')";

    if (mysqli_query($conexion, $sql)) {
        $mensaje = "Socio registrado correctamente: " . $nombre . " " . $apellido;
        header("Location: socios.php?mensaje=" . urlencode($mensaje));
        exit();
    } else {
        echo "Error al registrar el socio: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta Socio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/socios.css">
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
                    <p class="text-center">Cargar un nuevo</p>
                    <h2 class="text-center">SOCIO</h2>
                    <form action="alta_socio.php" method="post">
                        <div class="form-group mb-3">
                            <label for="form_nombre">Nombre</label>
                            <input name="nombre" id="form_nombre" type="text" class="form-control" placeholder="Nombre" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="form_apellido">Apellido</label>
                            <input name="apellido" id="form_apellido" type="text" class="form-control" placeholder="Apellido" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="form_fechaNacimiento">Fecha de Nacimiento</label>
                            <input name="fechaNacimiento" id="form_fechaNacimiento" type="date" class="form-control" placeholder="Fecha de Nacimiento" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="form_edad">Edad</label>
                            <input name="edad" id="form_edad" type="number" class="form-control" placeholder="Edad" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="form_dni">DNI</label>
                            <input name="dni" id="form_dni" type="text" class="form-control" placeholder="DNI" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="form_telefono">Teléfono</label>
                            <input name="telefono" id="form_telefono" type="text" class="form-control" placeholder="Teléfono">
                        </div>

                        <div class="form-group mb-3">
                            <label for="form_direccion">Dirección</label>
                            <input name="direccion" id="form_direccion" type="text" class="form-control" placeholder="Dirección">
                        </div>

                        <div class="form-group mb-3">
                            <label for="form_mail">Email</label>
                            <input name="mail" id="form_mail" type="email" class="form-control" placeholder="Email">
                        </div>

                        <div class="form-group mb-3">
                            <label for="form_contactoFamiliar">Contacto Familiar</label>
                            <input name="contactoFamiliar" id="form_contactoFamiliar" type="text" class="form-control" placeholder="Contacto Familiar">
                        </div>

                        <div class="form-group mb-3">
                            <label for="form_telefonoFamiliar">Teléfono Familiar</label>
                            <input name="telefonoFamiliar" id="form_telefonoFamiliar" type="text" class="form-control" placeholder="Teléfono Familiar">
                        </div>

                        <div class="form-group mb-3">
                            <label for="form_categoriaID">Categoría ID</label>
                            <input name="categoriaID" id="form_categoriaID" type="number" class="form-control" placeholder="Categoría ID">
                        </div>

                        <div class="form-group mb-3">
                            <label for="form_foto">Foto</label>
                            <input name="foto" id="form_foto" type="file" class="form-control">
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="Alta" class="btn btn-success btn-lg">Registrar Socio</button>
                        </div>

                    </form>
                    <a href="socios.php">Volver</a>
                </div>
            </div>
        </section>
    </main>
    <footer></footer>
</body>

</html>