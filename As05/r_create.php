<?php

session_start();
if (!isset($_SESSION["employee_id"])) { // if "user" not set,
    session_destroy();
    header('Location: login.php');     // go to login page
    exit;
}

if ($_SESSION["employee_title"] != "Administrator") {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

$sessionID = $_SESSION['employee_id'];

require 'database.php';

if ( !empty($_POST)) {
    // keep track validation errors
    $roomError = null;
    $buildingError = null;

    // keep track post values
    $room = $_POST['room'];
    $building = $_POST['building'];

    // validate input
    $valid = true;
    if (empty($room)) {
        $roomError = 'Please enter Room Number';
        $valid = false;
    }

    if (empty($building)) {
        $buildingError = 'Please enter Building';
        $valid = false;
    }

    // insert data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO rooms (roomNumber, building) values(?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($room,$building));
        Database::disconnect();
        header("Location: rooms.php");
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
            <h3>Create a Room</h3>
        </div>

        <form class="form-horizontal" action="r_create.php" method="post">
            <div class="control-group <?php echo !empty($roomError)?'error':'';?>">
                <label class="control-label">Room Number</label>
                <div class="controls">
                    <input name="room" type="text"  placeholder="Room Number" value="<?php echo !empty($name)?$name:'';?>">
                    <?php if (!empty($roomError)): ?>
                        <span class="help-inline"><?php echo $roomError;?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group <?php echo !empty($buildingError)?'error':'';?>">
                <label class="control-label">Building</label>
                <div class="controls">
                    <input name="building" type="text" placeholder="Building Number" value="<?php echo !empty($email)?$email:'';?>">
                    <?php if (!empty($buildingError)): ?>
                        <span class="help-inline"><?php echo $buildingError;?></span>
                    <?php endif;?>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success">Create</button>
                <a class="btn" href="rooms.php">Back</a>
            </div>
        </form>
    </div>

</div> <!-- /container -->
</body>
</html>