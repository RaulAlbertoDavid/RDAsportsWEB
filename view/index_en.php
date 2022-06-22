<?php
session_start();
if(!(isset($_SESSION["NAME"]))){
    header("Location:login_en.php");
} elseif(isset($_SESSION["ACTIVE"])) {
    header("Location:employee_area_en.php");
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
</head>

<body>
<section class="header">
    <h1>RDAsports</h1>
    <nav>
        <label for="check-menu">
            <input id="check-menu" type="checkbox">
            <div class="btn-menu">Menu</div>
            <ul class="ul-menu">
                <li><a href="?logout">Log out</a></li>
            </ul>
            <a href="index.php"><img src="../img/spa_flag.jpg" class="flag"></a>
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
        <h4>Classes in which you are registered in</h4>

        <?php
        $sql = "SELECT s.SESSION_ID, s.DATE_TIME, s.DURATION, s.CAPACITY, s.LEVEL, ac.NAME AS ACTIVITY, ar.NAME AS AREA, ar.NUMBER AS NUM, e.NAME AS EMPLOYEE FROM sessions s INNER JOIN activities ac ON s.activity_id = ac.activity_id INNER JOIN areas ar ON s.area_id = ar.area_id INNER JOIN employees e ON s.employee_id = e.employee_id WHERE s.session_id = ANY (SELECT sc.sessions_session_id FROM sessions_customers sc WHERE sc.customers_customer_id = ". $_SESSION["CUSTOMER_ID"] .")";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) { ?>
            <table>
                <tr>
                    <th class="head column_big">Activity</th>
                    <th class="head column_small">Date</th>
                    <th class="head column_small">Hour</th>
                    <th class="head column_big">Room</th>
                    <th class="head column_big">Instructor</th>
                    <th class="head column_small">Duration</th>
                    <th class="head column_small">Level</th>
                    <th class="head column_small">Registered</th>
                </tr><?php
                while($row = $result->fetch_array()) {
                    $sql_count = "SELECT sc.CUSTOMERS_CUSTOMER_ID AS c FROM sessions_customers sc WHERE sc.SESSIONS_SESSION_ID = " . $row["SESSION_ID"];
                    $count = $conn->query($sql_count);
                    $date = substr($row["DATE_TIME"], 8, 2) . "/" . substr($row["DATE_TIME"], 5, 2);
                    $hour = substr($row["DATE_TIME"], 11, 5); ?>
                    <tr>
                        <th class="column_big"><?php echo $row["ACTIVITY"] ?></th>
                        <th class="column_small"><?php echo $date ?></th>
                        <th class="column_small"><?php echo $hour ?></th>
                        <th class="column_big"><?php echo $row["AREA"] . " (" . $row["NUM"] . ")" ?></th>
                        <th class="column_big"><?php echo $row["EMPLOYEE"] ?></th>
                        <th class="column_small"><?php echo $row["DURATION"] ?> min</th>
                        <th class="column_small"><?php echo $row["LEVEL"] ?></th>
                        <th class="column_small"><?php echo $count->num_rows  . "/" . $row["CAPACITY"] ?></th>
                        <th>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <input type="hidden" name="customer" value="<?php echo $_SESSION["CUSTOMER_ID"] ?>">
                                <input type="hidden" name="session" value="<?php echo $row["SESSION_ID"]?>">
                                <input type='submit' name='delete_booking' value='Unsubscribe' class="boton">
                            </form>
                        </th>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>
    </div>
    <div class="tabla">
        <h4>Available classes</h4>
        <?php
        $sql = "SELECT s.SESSION_ID, s.DATE_TIME, s.DURATION, s.CAPACITY, s.LEVEL, ac.NAME AS ACTIVITY, ar.NAME AS AREA, ar.NUMBER AS NUM, e.NAME AS EMPLOYEE FROM sessions s INNER JOIN activities ac ON s.activity_id = ac.activity_id INNER JOIN areas ar ON s.area_id = ar.area_id INNER JOIN employees e ON s.employee_id = e.employee_id WHERE s.session_id != ALL (SELECT sc.sessions_session_id FROM sessions_customers sc WHERE sc.customers_customer_id = ". $_SESSION["CUSTOMER_ID"] .")";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) { ?>
            <table>
                <tr>
                    <th class="head column_big">Activity</th>
                    <th class="head column_small">Date</th>
                    <th class="head column_small">Hour</th>
                    <th class="head column_big">Room</th>
                    <th class="head column_big">Instructor</th>
                    <th class="head column_small">Duration</th>
                    <th class="head column_small">Level</th>
                    <th class="head column_small">Registered</th>
                </tr><?php
                while($row = $result->fetch_array()) {
                    $sql_count = "SELECT sc.CUSTOMERS_CUSTOMER_ID AS c FROM sessions_customers sc WHERE sc.SESSIONS_SESSION_ID = " . $row["SESSION_ID"];
                    $count = $conn->query($sql_count);
                    $date = substr($row["DATE_TIME"], 8, 2) . "/" . substr($row["DATE_TIME"], 5, 2);
                    $hour = substr($row["DATE_TIME"], 11, 5); ?>
                    <tr>
                        <th class="column_big"><?php echo $row["ACTIVITY"] ?></th>
                        <th class="column_small"><?php echo $date ?></th>
                        <th class="column_small"><?php echo $hour ?></th>
                        <th class="column_big"><?php echo $row["AREA"] . " (" . $row["NUM"] . ")" ?></th>
                        <th class="column_big"><?php echo $row["EMPLOYEE"] ?></th>
                        <th class="column_small"><?php echo $row["DURATION"] ?> min</th>
                        <th class="column_small"><?php echo $row["LEVEL"] ?></th>
                        <th class="column_small"><?php echo $count->num_rows . "/" . $row["CAPACITY"] ?></th>
                        <th>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <input type="hidden" name="customer" value="<?php echo $_SESSION["CUSTOMER_ID"] ?>">
                                <input type="hidden" name="session" value="<?php echo $row["SESSION_ID"]?>">
                                <?php
                                if($count->num_rows < $row["CAPACITY"]) {
                                    ?> <input id="bot" type='submit' value="Subscribe" name='add_booking' class="boton"> <?php
                                } else {
                                    ?> <p class="limit">No places left</p> <?php
                                }
                                ?>

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