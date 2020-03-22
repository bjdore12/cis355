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
    header("Location: rooms.php");
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM rooms where id = ?";
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
            <h3>Read a Room</h3>
        </div>

        <div class="form-horizontal" >
            <div class="control-group">
                <label class="control-label">Room ID</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['id'];?>
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
            <div class="form-actions">
                <a class="btn" href="rooms.php">Back</a>
            </div>


        </div>
    </div>

</div> <!-- /container -->
</body>
</html>