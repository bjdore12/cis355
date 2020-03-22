<?php


session_start();
if (!isset($_SESSION["employee_id"])) { // if "user" not set,
    session_destroy();
    header('Location: login.php');     // go to login page
    exit;
}
$sessionID = $_SESSION['employee_id'];


require 'database.php';
$id = 0;

if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ( !empty($_POST)) {
    // keep track post values
    $id = $_POST['id'];

    // delete data
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM meetings WHERE meeting_id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    Database::disconnect();
    header("Location: meetings.php");

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">

    <div class="span10 offset1">
        <div class="row">
            <h3>Cancel a Meeting</h3>
        </div>

        <?php

        $pdo = Database::connect();
        $sql = "SELECT meeting_id, h.firstName As host_first, h.lastName As host_last, a.firstName As att_first, a.lastName As att_last, h.email As host_mail, a.email As att_mail, roomNumber, building FROM employees As h, employees As a, meetings As m, rooms As r WHERE m.host_id = h.id AND m.attendee_id = a.id AND m.room_id = r.id AND m.meeting_id = $id";
        //$query = "SELECT customers.name As name, event_description FROM assignments, events, customers WHERE assignments.cust_id = customers.id AND assignments.event_id = events.id AND assignments.id = $id";

        foreach($pdo->query($sql) As $result) {

            $hostName = $result["host_first"] . " " . $result["host_last"];
            $attendeeName = $result["att_first"] . " " . $result["att_last"];
        }
        ?>

        <form class="form-horizontal" action="m_delete.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id;?>"/>
            <p class="alert alert-error">Are you sure you want to cancel <?php echo $hostName; ?>'s meeting with <?php echo $attendeeName;?>?</p>
            <div class="form-actions">
                <button type="submit" class="btn btn-danger">Yes</button>
                <a class="btn" href="meetings.php">No</a>
            </div>
        </form>
    </div>

</div> <!-- /container -->
</body>
</html>