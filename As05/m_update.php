<?php

session_start();
if (!isset($_SESSION["employee_id"])) { // if "user" not set,
    session_destroy();
    header('Location: login.php');     // go to login page
    exit;
}
$sessionID = $_SESSION['employee_id'];

require 'database.php';

$id = null;
if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ( null==$id ) {
    header("Location: meetings.php");
}

if ( !empty($_POST)) {
    // keep track validation errors
    $hostError = null;
    $attendeeError = null;
    $roomError = null;
    $dateError = null;
    $timeError = null;

    // keep track post values
    $host = $_POST['host'];
    $attendee = $_POST['attend'];
    $room = $_POST['room'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // validate input
    $valid = true;
    if (empty($host)) {
        $hostError = 'Please choose a Host';
        $valid = false;
    }

    if (empty($attendee)) {
        $attendeeError = 'Please choose an Attendee';
        $valid = false;
    }

    if (empty($room)) {
        $roomError = 'Please choose a Meeting Room';
        $valid = false;
    }

    // FIX THIS TO VALIDATE INPUT
    if (empty($date)) {
        $dateError = 'Please enter a Meeting Date';
        $valid = false;
    }

    // FIX THIS TO VALIDATE INPUT
    if (empty($time)) {
        $timeError = 'Please enter a Meeting Time';
        $valid = false;
    }

    // insert data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE meetings SET host_id = ?, attendee_id = ?, room_id = ?, meeting_date = ?, meeting_time = ? WHERE meeting_id = ? ";
        $q = $pdo->prepare($sql);
        $q->execute(array($host, $attendee, $room, $date, $time, $id));
        Database::disconnect();
        header("Location: meetings.php");
    }
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
            <h3>Update Meeting</h3>
        </div>

        <?php

        $pdo = Database::connect();
        $query = "SELECT id As host_id, employees.firstName, employees.lastName FROM employees WHERE employees.id = $sessionID";

        $meetings = "SELECT * FROM meetings WHERE meeting_id = ?";
        $r = $pdo->prepare($meetings);
        $r->execute(array($id));
        $data = $r->fetch(PDO::FETCH_ASSOC);
        $date = $data['meeting_date'];
        $time = $data['meeting_time'];
        ?>

        <form class="form-horizontal" action="m_update.php?id=<?php echo $id ?>" method="post">

            <div class="control-group">
                <label class="control-label">Host</label>
                <div class="controls">
                    <?php echo "<select class='form-control' name='host' id='host'>";
                    foreach ($pdo->query($query) as $row) {
                        if ($row['host_id'] == $data['host_id'])
                            echo "<option selected value='" . $row['host_id'] . " '> " . $row['firstName'] . " " . $row['lastName'] . "</option>";
                        else
                            echo "<option value='" . $row['host_id'] . " '> " . $row['firstName'] . " " . $row['lastName'] . "</option>";
                    }
                    echo "</select>";
                    ?>
                </div>
            </div>

            <?php

            $pdo = Database::connect();
            $query = "SELECT id As att_id, employees.firstName, employees.lastName FROM employees WHERE employees.id <> $sessionID";

            ?>

            <div class="control-group">
                <label class="control-label">Attendee</label>
                <div class="controls">
                    <?php echo "<select class='form-control' name='attend' id='attend'>";
                    foreach ($pdo->query($query) as $row) {
                        if ($row['att_id'] == $data['attendee_id'])
                            echo "<option selected value='" . $row['att_id'] . " '> " . $row['firstName'] . " " . $row['lastName'] . "</option>";
                        else
                            echo "<option value='" . $row['att_id'] . " '> " . $row['firstName'] . " " . $row['lastName'] . "</option>";
                    }
                    echo "</select>";
                    ?>
                </div>
            </div>

            <?php

            $pdo = Database::connect();
            $query = 'SELECT id As room_id, rooms.roomNumber, rooms.building FROM rooms';

            ?>

            <div class="control-group">
                <label class="control-label">Room</label>
                <div class="controls">
                    <?php echo "<select class='form-control' name='room' id='room'>";
                    foreach ($pdo->query($query) as $row) {
                        if ($row['room_id'] == $data['room_id'])
                            echo "<option selected value='" . $row['room_id'] . " '> " . $row['roomNumber'] . " " . $row['building'] . "</option>";
                        else
                            echo "<option value='" . $row['room_id'] . " '> " . $row['roomNumber'] . " " . $row['building'] . "</option>";

                    }
                    echo "</select>";
                    ?>
                </div>
            </div>


            <div class="control-group <?php echo !empty($dateError)?'error':'';?>">
                <label class="control-label">Event Date</label>
                <div class="controls">
                    <input name="date" type="date"  placeholder="Event Date" value="<?php echo !empty($date)?$date:'';?>">
                    <?php if (!empty($dateError)): ?>
                        <span class="help-inline"><?php echo $dateError;?></span>
                    <?php endif;?>
                </div>
            </div>

            <div class="control-group <?php echo !empty($timeError)?'error':'';?>">
                <label class="control-label">Event Time</label>
                <div class="controls">
                    <input name="time" type="time"  placeholder="Event Time" value="<?php echo !empty($time)?$time:'';?>">
                    <?php if (!empty($timeError)): ?>
                        <span class="help-inline"><?php echo $timeError;?></span>
                    <?php endif;?>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">Update Meeting</button>
                <a class="btn" href="meetings.php">Back</a>
            </div>
        </form>

        <?php Database::disconnect(); ?>

    </div>

</div> <!-- /container -->
</body>
</html>