<?php
session_start();
if(isset($_SESSION["NAME"])){
    header("Location:index_en.php");
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
                <a href="employee_login.php"><img src="../img/spa_flag.jpg" class="flag"></a>
            </label>
        </nav>
    </section>
<?php
if(isset($_GET["login"])){
    require_once("login_en.php");
}else{
    ?>
    <section>
        <div id="login">
            <form class="login_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <?php require_once("../controller/employee_controller.php"); ?>
                <h2 class="title-form">Login</h2>
                <div class="div-input">
                    <input type="text" class="user-form" name="email" id="email" placeholder="Email">
                </div>
                <div class="div-input">
                    <input type="password" class="user-form" name="password" id="password" placeholder="Password">
                </div>
                <input type="submit" name="login_employee_en" class="login_boton" value="Login">
                <p class="p-registrar-login"><a class="log-reg" href="login_en.php">Return</a></p>
            </form>
        </div>
    </section>
<?php } ?>
</body>
</html>