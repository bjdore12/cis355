<?php
include 'database.php';

session_start();
if (!isset($_SESSION["employee_id"])) { // if "user" not set,
    session_destroy();
    header('Location: login.php');     // go to login page
    exit;
}

$sessionID = $_SESSION['employee_id'];

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM employees where id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($sessionID));
$data = $q->fetch(PDO::FETCH_ASSOC);
Database::disconnect();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        @media screen and (max-width: 480px) {
            .hide_mobile {
                display:none;
            }
            .maring_sizing {margin-top: 10px;}
        }
    </style>
</head>

<body>
<div class="container">
    <br>
    <div class="row">
        <div class="container">
            <div>
                <div class="jumbotron col-sm-12 text-center" style="background-color: #007bff;">
                    <h1 style="color: white">Directory</h1>
                </div>
            </div>

            <div>
                <?php
                if ($_SESSION['employee_title']=='Administrator')
                    echo '<a href="admin_e_create.php" class="btn btn-primary">Create Account</a>';
                ?>
                <a href="meetings.php" class="btn btn-outline-secondary">Meetings</a>
                <a href="rooms.php" class="btn btn-outline-secondary">Rooms</a>
                <span><img class="img-thumbnail" width="40" src="data:image/jpeg;base64,<?php echo base64_encode( $data['userPic'] );?>"/></span>
                <span class="'float-sm-left text-secondary hide_mobile">Hello <?php echo $data['firstName']; ?></span>

                <div class="float-sm-right maring_sizing">
                    <a href="logout.php" class="btn btn-outline-secondary">Logout</a>
                    <a href="profile.php" class="btn btn-outline-secondary">My Profile</a>
                    <a href="http://webp.svsu.edu/~bjdore/cis355-1/" class="btn btn-outline-secondary">Back to Home</a>
                </div>

            </div>
        <p></p>
            <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email Address</th>
                <th>Phone Number</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $pdo = Database::connect();
            $sql = 'SELECT * FROM employees ORDER BY id DESC';
            foreach ($pdo->query($sql) as $row) {
                echo '<tr>';
                echo '<td>'. $row['firstName'] . ' ' . $row['lastName'] . '</td>';
                echo '<td>'. $row['email'] . '</td>';
                echo '<td>'. $row['phone'] . '</td>';
                if ($_SESSION['employee_title']=="Administrator")
                    echo '<td class="text-center align-middle" width=250>';
                else
                    echo '<td class="text-center align-middle">';
                echo '<a class="btn btn-outline-secondary btn-sm" href="e_read.php?id='.$row['id'].'">View</a>';
                echo ' ';
                if ($_SESSION['employee_title']=="Administrator")
                    echo '<a class="btn btn-success btn-sm" href="e_update.php?id='.$row['id'].'">Update</a>';
                echo ' ';
                if ($_SESSION['employee_title']=="Administrator")
                    echo '<a class="btn btn-danger btn-sm" href="e_delete.php?id='.$row['id'].'">Delete</a>';
                echo '</td>';
                echo '</tr>';
            }
            Database::disconnect();
            ?>
            </tbody>
        </table>
            </div>
            <hr>
            <footer>
                <small>&copy; Copyright 2020, Benjamin J. Dore</small>
            </footer>
        </div>
    </div>
</div> <!-- /container -->
</body>
</html>