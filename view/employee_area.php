<?php
session_start();if(!(isset($_SESSION["ACTIVE"]))){
    header("Location:login.php");
}
require_once("../controller/booking_controller.php");
require_once("../controller/session_controller.php");
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
                    <li><a href="?cerrar">Cerrar Sesión</a></li>
                </ul>
                <a href="employee_area_en.php"><img src="../img/eng_flag.jpg" class="flag"></a>
            </label>
        </nav>
    </section>
    <section>
        <?php
        $servername = "localhost";
        $username = "rdasports";
        $password = "password";
        $dbname = "rdasportsdb";
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        ?>

        <h4>Añadir nueva sesión</h4>
        <div id="login">
            <form class="login_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <?php require_once("../controller/session_controller.php"); ?>
                <div class="div-input">
                    <label>
                        <select class="user-form" name="activity">
                            <option hidden selected>Actividad</option>
                            <?php
                            $sql = "SELECT a.ACTIVITY_ID, a.NAME FROM activities a";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_array()) { ?>
                                    <option value="<?php echo $row["ACTIVITY_ID"] ?>"><?php echo $row["NAME"] ?></option>
                                <?php }} ?>
                        </select>
                    </label>
                </div>
                <div class="div-input">
                    <label>
                        <select class="user-form" name="area">
                            <option hidden selected>Área</option>
                            <?php
                            $sql = "SELECT a.AREA_ID, a.NAME, a.NUMBER FROM areas a";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_array()) { ?>
                                    <option value="<?php echo $row["AREA_ID"] ?>"><?php echo $row["NAME"] . " - " . $row["NUMBER"] ?>  </option>
                                <?php }} ?>
                        </select>
                    </label>
                </div>
                <div class="div-input">
                    <input type="datetime-local" class="user-form" name="date" id="date">
                </div>
                <div class="div-input">
                    <input type="number" class="user-form" name="duration" id="duration" placeholder="Duración">
                </div>
                <div class="div-input">
                    <input type="number" class="user-form" name="level" id="level" placeholder="Nivel">
                </div>
                <div class="div-input">
                    <input type="number" class="user-form" name="capacity" id="capacity" placeholder="Capacidad">
                </div>
                <input type="hidden" name="employee" value="<?php echo $_SESSION["EMPLOYEE_ID"]?>">
                <input type="submit" name="add_session" class="login_boton" value="Añadir">
            </form>
        </div>
    </section>
</body>