<?php
session_start();
if(isset($_SESSION["NAME"])){
    header("Location:index.php");
}
?>

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
                <a href="employee_login_en.php"><img src="../img/eng_flag.jpg" class="flag"></a>
            </label>
        </nav>
    </section>
    <?php
    if(isset($_GET["login"])){
        require_once("login.php");
    }else{
    ?>
    <section>
        <div id="login">
            <form class="login_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <?php require_once("../controller/employee_controller.php"); ?>
                <h2 class="title-form">Iniciar Sesión</h2>
                <div class="div-input">
                    <input type="text" class="user-form" name="email" id="email" placeholder="Email">
                </div>
                <div class="div-input">
                    <input type="password" class="user-form" name="password" id="password" placeholder="Contraseña">
                </div>
                <input type="submit" name="login_employee" class="login_boton" value="Iniciar sesión">
                <p class="p-registrar-login"><a class="log-reg" href="login.php">Volver</a></p>
            </form>
        </div>
    </section>
    <?php } ?>
</body>
</html>