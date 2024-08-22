<?php
session_start();
include 'config/conexion.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    $usuario = mysqli_real_escape_string($conexion, $usuario);

    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $result = mysqli_query($conexion, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($contraseña, $row['contraseña'])) {
            $_SESSION['usuario'] = $usuario;
            header("Location: index.php");
            exit();
        } else {
            $error_message = 'Contraseña incorrecta';
        }
    } else {
        $error_message = 'Usuario no encontrado';
    }

    mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/cabecera.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
</head>

<body>
    <form action="login.php" method="post">
        <h1 class="animate__animated animate__backInLeft">Sistema de login</h1>
        <p>Usuario <input type="text" placeholder="Ingrese su nombre" name="usuario"></p>
        <p>Contraseña <input type="password" placeholder="Ingrese su contraseña" name="contraseña"></p>
        <input type="submit" value="Ingresar">

        <?php
        if (!empty($error_message)) {
            echo '<p style="color:red;">' . $error_message . '</p>';
        }
        ?>
    </form>
</body>

</html>