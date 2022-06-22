<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>RDAsports</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <section class="header">
        <nav>
            <label for="check-menu">
                <a href="registro_en.php"><img src="../img/eng_flag.jpg" class="flag"></a>
            </label>
        </nav>
    </section>
    <section>
        <div id="login">
            <form class="login_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <?php require_once("../controller/customer_controller.php"); ?>

                <h2 class="title-form">Registrarse</h2>
                <div class="div-input">
                    <input type="text" class="user-form" name="name" id="name" placeholder="Nombre">
                </div>
                <div class="div-input">
                    <input type="text" class="user-form" name="email" placeholder="Email">
                </div>
                <div class="div-input">
                    <input type="password" class="user-form" name="password" placeholder="Contraseña">
                </div>
                <div class="div-input">
                    <input type="password" class="user-form" name="password2" placeholder="Confirmar contraseña">
                </div>
                <div class="div-input">
                    <input type="text" class="user-form" name="phone" placeholder="Teléfono">
                </div>
                <div class="div-input">
                    <input type="date" class="user-form" name="birth_date" id="birth_date" placeholder="Fecha de nacimiento">
                </div>
                <input type="submit" class="login_boton" name="registro" value="Registrar">
            </form>
            <p class="p-registrar-login">¿Tienes una cuenta? <a class="log-reg" href="login.php">Iniciar sesión</a></p>
        </div>
    </section>
</body>
