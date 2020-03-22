<?php
session_start();
if(!isset($_SESSION["employee_id"])){ // if "user" not set,
    session_destroy();
    header('Location: login.php');     // go to login page
    exit;
}
$sessionID = $_SESSION['employee_id'];
?>

<?php
require 'database.php';
$id = null;
if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ( null==$id ) {
    header("Location: meetings.php");
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT meeting_id, h.firstName As host_first, h.lastName As host_last, a.firstName As att_first, a.lastName As att_last, h.email As host_mail, a.email As att_mail, roomNumber, building, DATE_FORMAT(meeting_date, "%m/%d/%Y") As meeting_date, TIME_FORMAT(meeting_time, "%h:%i %p") As meeting_time FROM employees As h, employees As a, meetings As m, rooms As r WHERE m.host_id = h.id AND m.attendee_id = a.id AND m.room_id = r.id';
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
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
            <h3>Read Meeting</h3>
        </div>

        <div class="form-horizontal" >
            <div class="control-group">
                <label class="control-label">Host</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['host_first'] . " " . $data['host_last'];?>
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Host Email Address</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['host_mail'];?>
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Attendee</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['att_first'] . " " . $data['att_last'];?>
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Attendee Email Address</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['att_mail'];?>
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Room Number</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['roomNumber'];?>
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Building</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['building'];?>
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Meeting Date</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['meeting_date'];?>
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Meeting Time</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['meeting_time'];?>
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <a class="btn" href="meetings.php">Back</a>
            </div>


        </div>
    </div>

</div> <!-- /container -->
</body>
</html>