<?php
session_start();
require_once("../controller/employee_controller.php");
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="../css/styles.css">

<head>
    <meta charset="UTF-8">
    <title>RDAsports</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <section class="header">
        <h1>RDAsports</h1>
        <nav>
            <label for="check-menu">
                <input id="check-menu" type="checkbox">
                <div class="btn-menu">Menú</div>
                <ul class="ul-menu">
                    <?php
                    if (isset($_SESSION["NAME"])) {
                        ?><li><a href="?cerrar">Cerrar Sesión</a></li><?php
                    } else {
                        ?><li><a href="login.php">Acceder</a></li>
                        <li><a href="login.php<?php echo '?registrar'; ?>">Registrarse</a></li><?php
                    }
                    ?>
                </ul>
            </label>
        </nav>
    </section>

    <section>
        <h4>Sesiones en las que estás inscrito</h4>
        <?php
        $servername = "localhost";
        $username = "rdasports";
        $password = "password";
        $dbname = "rdasportsdb";
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT s.SESSION_ID, s.LEVEL, s.DURATION, s.DATE_TIME, s.CAPACITY FROM sessions s";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_array()) { ?>
                <div class='comentario'>
                    <div class="botones">
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?php echo $row["SESSION_ID"]?>">
                            <input id="quit<?php echo $row["ID"]?>" type='submit' name='quit' value='Eliminar inscripción' class="boton">
                        </form>
                    </div>
                </div>
            <?php }
        }
        $conn->close(); ?>

        <h4>Sesiones disponibles</h4>
    </section>
</body>