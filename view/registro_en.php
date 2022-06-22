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
                <a href="registro.php"><img src="../img/spa_flag.jpg" class="flag"></a>
            </label>
        </nav>
    </section>
    <section>
        <div id="login">
            <form class="login_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <?php require_once("../controller/customer_controller.php"); ?>

                <h2 class="title-form">Sign in</h2>
                <div class="div-input">
                    <input type="text" class="user-form" name="name" id="name" placeholder="Name">
                </div>
                <div class="div-input">
                    <input type="text" class="user-form" name="email" placeholder="Email">
                </div>
                <div class="div-input">
                    <input type="password" class="user-form" name="password" placeholder="Password">
                </div>
                <div class="div-input">
                    <input type="password" class="user-form" name="password2" placeholder="Confirm password">
                </div>
                <div class="div-input">
                    <input type="text" class="user-form" name="phone" placeholder="Phone">
                </div>
                <div class="div-input">
                    <input type="date" class="user-form" name="birth_date" id="birth_date" placeholder="Birth date">
                </div>
                <input type="submit" class="login_boton" name="registro_en" value="Sign in">
            </form>
            <p class="p-registrar-login">Already have an account? <a class="log-reg" href="login_en.php">Login</a></p>
        </div>
    </section>
</body>
