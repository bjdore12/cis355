<?php
    include 'database.php';

    session_start();
    if(!isset($_SESSION["employee_id"])){ // if "user" not set,
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
                    <h1 style="color: white">Meetings</h1>
                </div>
            </div>
        </div>

        <div class="container">
            <div>
                <a href="m_create.php" class="btn btn-primary">Schedule Meeting</a>
                <a href="employees.php" class="btn btn-outline-secondary">Directory</a>
                <a href="rooms.php" class="btn btn-outline-secondary">Rooms</a>
                <span><img class="img-thumbnail" width="40" src="data:image/jpeg;base64,<?php echo base64_encode( $data['userPic'] );?>"/></span>
                <span class="'float-sm-left text-secondary hide_mobile">Hello <?php echo $data['firstName']; ?></span>

                <div class="float-sm-right maring_sizing">
                    <a href="logout.php" class="btn btn-outline-secondary">Logout</a>
                    <a href="profile.php" class="btn btn-outline-secondary">My Profile</a>
                    <a href="http://webp.svsu.edu/~bjdore/cis355-1/" class="btn btn-outline-secondary">Back to Home</a>
                </div>

            </div>
        </div>

        <div class="container">
        <br>
        <p><b>Meetings I'm Hosting</b></p>

            <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Host</th>
                <th>Host Email</th>
                <th>Attendee</th>
                <th>Attendee Email</th>
                <th>Room Number</th>
                <th>Building</th>
                <th>Meeting Date</th>
                <th>Meeting Time</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $pdo = Database::connect();
            //$sql = 'SELECT assignments.id As as_id, name, email, event_description, event_location FROM assignments, customers, events WHERE assignments.cust_id = customers.id AND assignments.event_id = events.id';
            $sql = "SELECT meeting_id, h.firstName As host_first, h.lastName As host_last, a.firstName As att_first, a.lastName As att_last, h.email As host_mail, a.email As att_mail, roomNumber, building, DATE_FORMAT(meeting_date, \"%m/%d/%Y\") As meeting_date, TIME_FORMAT(meeting_time, \"%h:%i %p\") As meeting_time FROM employees As h, employees As a, meetings As m, rooms As r WHERE m.host_id = h.id AND m.attendee_id = a.id AND m.room_id = r.id AND h.id = $sessionID";
            foreach ($pdo->query($sql) as $row) {

                echo '<tr>';
                echo '<td>'. $row['host_first'] . " " . $row['host_last'] . '</td>';
                echo '<td>'. $row['host_mail'] . '</td>';
                echo '<td>'. $row['att_first'] . " " . $row['att_last'] . '</td>';
                echo '<td>'. $row['att_mail'] . '</td>';
                echo '<td>'. $row['roomNumber'] . '</td>';
                echo '<td>'. $row['building'] . '</td>';
                echo '<td>'. $row['meeting_date'] .'</td>';
                echo '<td>'. $row['meeting_time'] .'</td>';
                echo '<td class="text-center align-middle" width=260>';
                echo '<a class="btn btn-outline-secondary btn-sm" href="m_read.php?id='.$row['meeting_id'].'">View</a>';
                echo ' ';
                echo '<a class="btn btn-success btn-sm" href="m_update.php?id='.$row['meeting_id'].'">Update</a>';
                echo ' ';
                echo '<a class="btn btn-danger btn-sm" href="m_delete.php?id='.$row['meeting_id'].'">Cancel</a>';
                echo '</td>';
                echo '</tr>';
            }

            Database::disconnect();
            ?>
            </tbody>
        </table>
            </div>

        <p><b>Meetings I'm Attending</b></p>
            <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Host</th>
                <th>Host Email</th>
                <th>Attendee</th>
                <th>Attendee Email</th>
                <th>Room Number</th>
                <th>Building</th>
                <th>Meeting Date</th>
                <th>Meeting Time</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $pdo = Database::connect();
            //$sql = 'SELECT assignments.id As as_id, name, email, event_description, event_location FROM assignments, customers, events WHERE assignments.cust_id = customers.id AND assignments.event_id = events.id';
            $sql = "SELECT meeting_id, h.firstName As host_first, h.lastName As host_last, a.firstName As att_first, a.lastName As att_last, h.email As host_mail, a.email As att_mail, roomNumber, building, DATE_FORMAT(meeting_date, \"%m/%d/%Y\") As meeting_date, TIME_FORMAT(meeting_time, \"%h:%i %p\") As meeting_time FROM employees As h, employees As a, meetings As m, rooms As r WHERE m.host_id = h.id AND m.attendee_id = a.id AND m.room_id = r.id AND a.id = $sessionID";
            foreach ($pdo->query($sql) as $row) {
                echo '<tr>';
                echo '<td>'. $row['host_first'] . " " . $row['host_last'] . '</td>';
                echo '<td>'. $row['host_mail'] . '</td>';
                echo '<td>'. $row['att_first'] . " " . $row['att_last'] . '</td>';
                echo '<td>'. $row['att_mail'] . '</td>';
                echo '<td>'. $row['roomNumber'] . '</td>';
                echo '<td>'. $row['building'] . '</td>';
                echo '<td>'. $row['meeting_date'] .'</td>';
                echo '<td width="100">'. $row['meeting_time'] .'</td>';
                echo '<td class="text-center align-middle" width=250>';
                echo '<a class="btn btn-outline-secondary btn-sm" href="m_read.php?id='.$row['meeting_id'].'">View</a>';
                echo ' ';
                echo '<a class="btn btn-danger btn-sm" href="m_delete.php?id='.$row['meeting_id'].'">Leave</a>';
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