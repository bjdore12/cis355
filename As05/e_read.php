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
    header("Location: employees.php");
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM employees where id = ?";
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
            <h3>Read Employee</h3>
        </div>

        <div class="form-horizontal" >

            <div class="control-group">
                <label class="control-label">First Name</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['firstName'];?>
                    </label>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Last Name</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['lastName'];?>
                    </label>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Email Address</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['email'];?>
                    </label>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Phone Number</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['phone'];?>
                    </label>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Photo</label>
                <div class="controls">
                    <img width="100" src="data:image/jpeg;base64,<?php echo base64_encode( $data['userPic'] );?>"/>
                </div>
            </div>

            <div class="form-actions">
                <a class="btn" href="employees.php">Back</a>
            </div>


        </div>
    </div>

</div> <!-- /container -->
</body>
</html>