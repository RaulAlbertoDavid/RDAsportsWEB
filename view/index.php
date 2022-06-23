<?php
session_start();
if(!(isset($_SESSION["NAME"]))){
    header("Location:login.php");
} elseif(isset($_SESSION["ACTIVE"])) {
    header("Location:employee_area.php");
}
require_once("../controller/employee_controller.php");
require_once("../controller/booking_controller.php");
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="../css/styles.css">

<head>
    <meta charset="UTF-8">
    <title>RDAsports</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
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
                <a href="index_en.php"><img src="../img/eng_flag.jpg" class="flag"></a>
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
        <div class="tabla">
        <h4>Clases en las que estás inscrito</h4>

        <?php
        $sql = "SELECT s.SESSION_ID, s.DATE_TIME, s.DURATION, s.CAPACITY, s.LEVEL, ac.NAME AS ACTIVITY, ar.NAME AS AREA, ar.NUMBER AS NUM, e.NAME AS EMPLOYEE FROM sessions s INNER JOIN activities ac ON s.activity_id = ac.activity_id INNER JOIN areas ar ON s.area_id = ar.area_id INNER JOIN employees e ON s.employee_id = e.employee_id WHERE s.session_id = ANY (SELECT sc.sessions_session_id FROM sessions_customers sc WHERE sc.customers_customer_id = ". $_SESSION["CUSTOMER_ID"] .")";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) { ?>
             <table id="tabla1">
                <tr>
                    <th class="head column_big">Actividad</th>
                    <th class="head column_small">Fecha</th>
                    <th class="head column_small">Hora</th>
                    <th class="head column_big">Sala</th>
                    <th class="head column_big">Monitor</th>
                    <th class="head column_small">Duración</th>
                    <th class="head column_small">Nivel</th>
                    <th class="head column_small">Inscritos</th>
                    <th class="head column_small"></th>
                </tr><?php
            while($row = $result->fetch_array()) {
                $sql_count = "SELECT sc.CUSTOMERS_CUSTOMER_ID AS c FROM sessions_customers sc WHERE sc.SESSIONS_SESSION_ID = " . $row["SESSION_ID"];
                $count = $conn->query($sql_count);
                $date = substr($row["DATE_TIME"], 8, 2) . "/" . substr($row["DATE_TIME"], 5, 2);
                $hour = substr($row["DATE_TIME"], 11, 5); ?>
                    <tr id="row1<?php echo $row["SESSION_ID"]?>">
                        <th class="column_big"><?php echo $row["ACTIVITY"] ?></th>
                        <th class="column_small"><?php echo $date ?></th>
                        <th class="column_small"><?php echo $hour ?></th>
                        <th class="column_big"><?php echo $row["AREA"] . " (" . $row["NUM"] . ")" ?></th>
                        <th class="column_big"><?php echo $row["EMPLOYEE"] ?></th>
                        <th class="column_small"><?php echo $row["DURATION"] ?> min</th>
                        <th class="column_small"><?php echo $row["LEVEL"] ?></th>
                        <th id="capacity1<?php echo $row["SESSION_ID"]?>" class="column_small"><?php echo $count->num_rows  . "/" . $row["CAPACITY"] ?></th>
                        <th>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <input type="hidden" name="customer" value="<?php echo $_SESSION["CUSTOMER_ID"] ?>">
                                <input type="hidden" name="session" value="<?php echo $row["SESSION_ID"]?>">
                                <input id="b1<?php echo $row["SESSION_ID"]?>" type='button' name='delete_booking' value='Eliminar' class="boton">
                            </form>
                        </th>
                    </tr>
            <?php } ?>
            </table>
        <?php } ?>
        </div>
        <div class="tabla">
        <h4 id="asd">Clases disponibles</h4>
        <?php
        $sql = "SELECT s.SESSION_ID, s.DATE_TIME, s.DURATION, s.CAPACITY, s.LEVEL, ac.NAME AS ACTIVITY, ar.NAME AS AREA, ar.NUMBER AS NUM, e.NAME AS EMPLOYEE FROM sessions s INNER JOIN activities ac ON s.activity_id = ac.activity_id INNER JOIN areas ar ON s.area_id = ar.area_id INNER JOIN employees e ON s.employee_id = e.employee_id WHERE s.session_id != ALL (SELECT sc.sessions_session_id FROM sessions_customers sc WHERE sc.customers_customer_id = ". $_SESSION["CUSTOMER_ID"] .")";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) { ?>
            <table id="tabla2">
                <tr>
                    <th class="head column_big">Actividad</th>
                    <th class="head column_small">Fecha</th>
                    <th class="head column_small">Hora</th>
                    <th class="head column_big">Sala</th>
                    <th class="head column_big">Monitor</th>
                    <th class="head column_small">Duración</th>
                    <th class="head column_small">Nivel</th>
                    <th class="head column_small">Inscritos</th>
                    <th class="head column_small"></th>
                </tr><?php
            while($row = $result->fetch_array()) {
                $sql_count = "SELECT sc.CUSTOMERS_CUSTOMER_ID AS c FROM sessions_customers sc WHERE sc.SESSIONS_SESSION_ID = " . $row["SESSION_ID"];
                $count = $conn->query($sql_count);
                $date = substr($row["DATE_TIME"], 8, 2) . "/" . substr($row["DATE_TIME"], 5, 2);
                $hour = substr($row["DATE_TIME"], 11, 5); ?>
                <tr id="row2<?php echo $row["SESSION_ID"]?>">
                    <th class="column_big"><?php echo $row["ACTIVITY"] ?></th>
                    <th class="column_small"><?php echo $date ?></th>
                    <th class="column_small"><?php echo $hour ?></th>
                    <th class= "column_big"><?php echo $row["AREA"] . " (" . $row["NUM"] . ")" ?></th>
                    <th class="column_big"><?php echo $row["EMPLOYEE"] ?></th>
                    <th class="column_small"><?php echo $row["DURATION"] ?> min</th>
                    <th class="column_small"><?php echo $row["LEVEL"] ?></th>
                    <th id="capacity2<?php echo $row["SESSION_ID"]?>" class="column_small"><?php echo $count->num_rows . "/" . $row["CAPACITY"] ?></th>
                    <th>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" role="form" id="contactForm">
                            <input type="hidden" name="customer" value="<?php echo $_SESSION["CUSTOMER_ID"] ?>">
                            <input type="hidden" name="session" value="<?php echo $row["SESSION_ID"]?>">
                            <?php
                            if($count->num_rows < $row["CAPACITY"]) {
                                ?><input id="b2<?php echo $row["SESSION_ID"]?>" type="button" class="boton" value="Inscribirse"><?php
                            } else {
                                ?> <p class="limit">No quedan plazas</p> <?php
                            } ?>
                        </form>
                    </th>
                </tr>
            <?php } ?>
            </table>
        <?php }
        $conn->close(); ?>
        </div>
    </section>
</body>

<script>
    $(document).ready(function() {
        $(document).click(function(event) {
            let boton = event.target.id.substring(0, 2);
            let id = event.target.id.substring(2);

            if (boton === "b1") {
                $.ajax({
                    type: "POST",
                    url: "delete_booking.php",
                    data: {
                        customer: <?php echo $_SESSION["CUSTOMER_ID"] ?>,
                        session: id,
                    },
                    cache: false,
                    success: function(data) {
                        event.target.value = "Inscribirse";
                        event.target.id = "b2" + id;
                        let capacity = document.getElementById("capacity1" + id).innerHTML;
                        let barra = capacity.indexOf("/");
                        let apuntados = capacity.substring(0, barra);
                        let total = capacity.substring(barra + 1);
                        apuntados--;
                        document.getElementById("capacity1" +id).innerHTML = apuntados + "/" + total;
                        let fila = document.getElementById("row1" + id);
                        fila.id = "row2" + id;
                        let tabla = document.getElementById("tabla2");
                        tabla.innerHTML = tabla.innerHTML + fila.innerHTML;
                        fila.remove();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr);
                    }
                 });
            } else if (boton === "b2") {
                $.ajax({
                    type: "POST",
                    url: "add_booking.php",
                    data: {
                        customer: <?php echo $_SESSION["CUSTOMER_ID"] ?>,
                        session: id,
                    },
                    cache: false,
                    success: function(data) {
                        event.target.value = "Eliminar";
                        event.target.id = "b1" + id;
                        let capacity = document.getElementById("capacity2" + id).innerHTML;
                        let barra = capacity.indexOf("/");
                        let apuntados = capacity.substring(0, barra);
                        let total = capacity.substring(barra + 1);
                        apuntados++;
                        document.getElementById("capacity2" +id).innerHTML = apuntados + "/" + total;
                        let fila = document.getElementById("row2" + id);
                        fila.id = "row1" + id;
                        let tabla = document.getElementById("tabla1");
                        tabla.innerHTML = tabla.innerHTML + fila.innerHTML;
                        fila.remove();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr);
                    }
                });
            }
        });
    });
</script>