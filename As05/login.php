<?php

// Start or resume session, and create: $_SESSION[] array
session_start();
if (isset($_SESSION["employee_id"])) { // if "user" not set,
    header('Location: meetings.php');     // go to login page
    exit;
}

require 'database.php';

if (!empty($_POST)) { // if $_POST filled then process the form

    $emailError = null;

    // initialize $_POST variables
    $username = $_POST['username']; // username is email address
    $password = $_POST['password'];
    $passwordhash = MD5($password);
    // echo $password . " " . $passwordhash; exit();
    // robot 87b7cb79481f317bde90c116cf36084b

    // verify the username/password
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM employees WHERE email = ? AND password = ? LIMIT 1";
    $q = $pdo->prepare($sql);
    $q->execute(array($username,$passwordhash));
    $data = $q->fetch(PDO::FETCH_ASSOC);

    $valid = true;

    if(empty($data['email'])) {
        $emailError = 'Email or password is incorrect.';
        $valid = false;
    }
    else if (empty($data['password'])) {
        $emailError = 'Email or password is incorrect.';
        $valid = false;
    }

    Database::disconnect();

    if($data && $valid) { // if successful login set session variables
        session_unset(); //Clear any previous session
        $_SESSION['employee_id'] = $data['id'];
        $sessionid = $data['id'];
        $_SESSION['employee_title'] = $data['title'];
        Database::disconnect();
        header("Location: meetings.php");
        exit();
    }
    //else { // otherwise go to login error page
    //    Database::disconnect();
    //    header("Location: login_error.php");
    //}
}
// if $_POST NOT filled then display login form, below.

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
</head>

<body>
<div class="container">
    <br>
    <div class="jumbotron col-sm-12 text-center" style="background-color: #007bff;">
        <h1 style="color: white">Welcome to Meetings</h1>
    </div>
    <div class="card">
        <div class="card-body mx-auto" style="width: 375px">

            <h3 class="card-title">Login</h3>

            <form action="login.php" method="post">
                <div class="form-group <?php echo !empty($emailError)?'was-validated':'needs-validation';?>">
                    <label>Username (Email)</label>
                    <div>
                        <input class="form-control" name="username" type="text" placeholder="me@email.com" required>
                    </div>
                </div>

                <div class="form-group <?php echo !empty($emailError)?'was-validated':'needs-validation';?>"">
                    <label>Password</label>
                    <div>
                        <input class="form-control" name="password" type="password" placeholder="password" required>
                    </div>
                </div>
                <?php if (!empty($emailError)): ?>
                    <p class="text-danger"><?php echo $emailError;?></p>
                <?php endif;?>

                <br>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Sign in</button>
                    &nbsp;
                    <a class="btn btn-primary" href="e_create.php">Register</a>
                    &nbsp;
                    <a class="btn btn-primary float-right" href="http://webp.svsu.edu/~bjdore/cis355-1/">Back to Home</a>
                </div>

            </form>
        </div>
    </div>
    <br>
    <footer>
        <small>&copy; Copyright 2020, Benjamin J. Dore</small>
    </footer>
</div> <!-- end div: class="container" -->

</body>

</html>