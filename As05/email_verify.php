<?php

require 'database.php';
require 'Mailer.php';

session_start();

if (empty($_SESSION['email'])){
    header("Location: login.php");
}

if (empty($_POST)) {
    $emailer = new Mailer($_SESSION['email'], "Verify your email", "");
    $emailer->sendEmailVerify();
    $_SESSION["sentCode"] = $emailer->getVerifyCode();
}

if ( !empty($_POST)) {
    $verifyError = null;
    $verify = $_POST['verify'];

    $valid = true;
    if (empty($verify)) {
        $verifyError = 'Please enter Verification Code';
        $valid = false;
    }

    if ($verify != $_SESSION['sentCode']) {
        $verifyError ='Code is incorrect, please enter the correct code';
        $valid = false;
    }

    // insert data
    if ($valid) {

        $firstName = $_SESSION['firstName'];
        $lastName = $_SESSION['lastName'];
        $phone = $_SESSION['phone'];
        $email = $_SESSION['email'];
        $content = $_SESSION['content'];
        $fileName = $_SESSION['fileName'];
        $fileSize = $_SESSION['fileSize'];
        $fileType = $_SESSION['fileType'];
        $passwordHash = $_SESSION['passwordHash'];
        $title = $_SESSION['title'];

        $pdo = Database::connect();
        $sql = "INSERT INTO employees (firstName,lastName,phone,email,userPic,fileName,fileSize,fileType,password,title) VALUES('$firstName', '$lastName', '$phone', '$email', '$content', '$fileName', '$fileSize', '$fileType','$passwordHash','$title')";
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $q = $pdo->prepare($sql);
        $q->execute(array());

        $sql = "SELECT * FROM employees WHERE email = ? AND password = ? LIMIT 1";
        $q = $pdo->prepare($sql);
        $q->execute(array($email,$passwordHash));
        $data = $q->fetch(PDO::FETCH_ASSOC);

        session_unset();

        $_SESSION['employee_id'] = $data['id'];
        $_SESSION['employee_title'] = $data['title'];

        Database::disconnect();
        header("Location: meetings.php");
    }
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
            <h3>Verify Your Email</h3>
        </div>
    </div>

    <div class="card">
        <div class="card-body mx-auto p-5">
        <p>An email verification code has been sent to your email address. Please check your email and enter the code below.</p>
        <p>(NOTE: If you do not receive the email, please check your spam folder.)</p>
        <form class="form-horizontal" action="email_verify.php" method="post" onsubmit="return Validate(this);" enctype="multipart/form-data">

            <div class="form-group <?php echo !empty($verifyError)?'was-validated':'';?>">
                <label>Enter Code</label>
                <div class="controls">
                    <input class="form-control" required name="verify" type="text"  placeholder="Enter Code" value="<?php echo !empty($verify) ? '':'';?>">
                    <?php if (!empty($verifyError)): ?>
                        <span class="invalid-feedback"><?php echo $verifyError;?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">Verify</button>
                <a class="btn btn-primary" href="e_create.php">Back</a>
                <a class="btn btn-primary" href="email_verify.php">Resend Code</a>
            </div>

        </form>
        </div>
    </div>
    <br>
    <footer>
        <small>&copy; Copyright 2020, Benjamin J. Dore</small>
    </footer>
</div> <!-- /container -->
</body>
</html>
