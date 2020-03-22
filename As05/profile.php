<?php

session_start();
if (!isset($_SESSION["employee_id"])) { // if "user" not set,
    session_destroy();
    header('Location: login.php');     // go to login page
    exit;
}

$sessionID = $_SESSION['employee_id'];

require 'database.php';

if ( null==$sessionID ) {
    header("Location: meetings.php");
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM employees where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($sessionID));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--<link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
<div class="container">

    <div class="row pt-5 pb-2">
        <div class="col-sm-3">
            <h3>Profile</h3>
        </div>
    </div>



    <div class="row">
        <div class="card col-sm-12">
            <div class="card-body mx-auto">

                <div class="row pb-2">
                    <div class="col-sm-4">
                        <img class="img-thumbnail" style="height: auto;width: 150px" src="data:image/jpeg;base64,<?php echo base64_encode( $data['userPic'] );?>"/>
                    </div>

                    <div class="col-sm-8">
                        <div>
                            <div>
                                <h1>
                                    <b><?php echo $data['firstName'];?></b></h1>
                                <span>
                                    <?php echo $data['lastName'];?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <form>



            <div class="form-group">
                <div class="card">
                    <div class="card-header">Email Address</div>
                    <div class="card-body mx-auto">
                        <b><?php echo $data['email'];?></b>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="card">
                    <div class="card-header">Phone Number</div>
                    <div class="card-body mx-auto">
                        <b><?php echo $data['phone'];?></b>
                    </div>
                </div>
            </div>


            <div class="form-actions">
                <a class="btn btn-primary" href="meetings.php">Back</a>
                <a class="btn btn-primary" href="profile_edit.php">Edit Profile</a>
                <a class="btn btn-danger" href="profile_delete.php">Delete Profile</a>
            </div>
                </form>
            </div>
        </div>
    </div>
    <br>
    <footer>
        <small>&copy; Copyright 2020, Benjamin J. Dore</small>
    </footer>

</div> <!-- /container -->
</body>
</html>