<?php
ini_set('display_errors', 1);
include 'config/conexion.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['Modificar'])) {
    $SocioID = $_POST['SocioID'];
    $nombre = $_POST['Nombre'];
    $apellido = $_POST['Apellido'];
    $fechaNacimiento = $_POST['FechaNacimiento'];
    $edad = $_POST['Edad'];
    $dni = $_POST['DNI'];
    $telefono = $_POST['Telefono'];
    $direccion = $_POST['Direccion'];
    $mail = $_POST['Mail'];
    $foto = $_POST['Foto'];
    $contactoFamiliar = $_POST['ContactoFamiliar'];
    $telefonoFamiliar = $_POST['TelefonoFamiliar'];

    $sql = "UPDATE socios SET Nombre = '$nombre', Apellido = '$apellido', FechaNacimiento = '$fechaNacimiento', Edad = '$edad', DNI = '$dni', Telefono = '$telefono', Direccion = '$direccion', Mail = '$mail', Foto = '$foto', ContactoFamiliar = '$contactoFamiliar', TelefonoFamiliar = '$telefonoFamiliar' WHERE SocioID = '$SocioID'";

    if (mysqli_query($conexion, $sql)) {
        $mensaje = "Socio modificado correctamente: " . $nombre . " " . $apellido;
        header("Location: socios.php?mensaje=" . urlencode($mensaje));
        exit();
    } else {
        echo "Error al modificar el socio: " . mysqli_error($conexion);
    }
}


if (isset($_GET['id'])) {
    $SocioID = $_GET['id'];
    $sql = "SELECT * FROM socios WHERE SocioID = '$SocioID'";
    $result = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_array($result);
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Socio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/socios.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
</head>

<body>
    <main>
        <section id="modificarSocio" class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-xl-8">
                    <h2 class="text-center">Modificar Socio</h2>
                    <form action="modif_socio.php" method="post">
                        <div class="form-floating mb-3">
                            <input name="Nombre" id="nombreSocio" type="text" class="form-control" value="<?php echo $row['Nombre']; ?>" required>
                            <label for="nombreSocio">Nombre</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="Apellido" id="apellidoSocio" type="text" class="form-control" value="<?php echo $row['Apellido']; ?>" required>
                            <label for="apellidoSocio">Apellido</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="FechaNacimiento" id="fechaNacimientoSocio" type="date" class="form-control" value="<?php echo $row['FechaNacimiento']; ?>" required>
                            <label for="fechaNacimientoSocio">Fecha de Nacimiento</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="Edad" id="edadSocio" type="number" class="form-control" value="<?php echo $row['Edad']; ?>" required>
                            <label for="edadSocio">Edad</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="DNI" id="dniSocio" type="text" class="form-control" value="<?php echo $row['DNI']; ?>" required>
                            <label for="dniSocio">DNI</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="Telefono" id="telefonoSocio" type="text" class="form-control" value="<?php echo $row['Telefono']; ?>" required>
                            <label for="telefonoSocio">Teléfono</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="Direccion" id="direccionSocio" type="text" class="form-control" value="<?php echo $row['Direccion']; ?>" required>
                            <label for="direccionSocio">Dirección</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="Mail" id="mailSocio" type="email" class="form-control" value="<?php echo $row['Mail']; ?>" required>
                            <label for="mailSocio">Mail</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="Foto" id="fotoSocio" type="text" class="form-control" value="<?php echo $row['Foto']; ?>">
                            <label for="fotoSocio">Foto</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="ContactoFamiliar" id="contactoFamiliarSocio" type="text" class="form-control" value="<?php echo $row['ContactoFamiliar']; ?>" required>
                            <label for="contactoFamiliarSocio">Contacto Familiar</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="TelefonoFamiliar" id="telefonoFamiliarSocio" type="text" class="form-control" value="<?php echo $row['TelefonoFamiliar']; ?>" required>
                            <label for="telefonoFamiliarSocio">Teléfono Familiar</label>
                        </div>
                        <input name="SocioID" type="hidden" value="<?php echo $row['SocioID']; ?>">
                        <button type="submit" name="Modificar" class="btn btn-success btn-lg btn-form">Modificar</button>
                    </form>
                    <a href="socios.php">Volver</a>
                </div>
            </div>
        </section>
    </main>
</body>

</html>