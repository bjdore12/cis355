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

$id = null;
if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ( null==$id ) {
    header("Location: employees.php");
}

if ( !empty($_POST)) {
    // keep track validation errors
    $firstNameError = null;
    $lastNameError = null;
    $emailError = null;
    $phoneError = null;

    // keep track post values
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // validate input
    $valid = true;
    if (empty($firstName)) {
        $nameError = 'Please enter First Name';
        $valid = false;
    }

    if (empty($lastName)) {
        $nameError = 'Please enter Last Name';
        $valid = false;
    }

    if (empty($email)) {
        $emailError = 'Please enter Email Address';
        $valid = false;
    } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        $emailError = 'Please enter a valid Email Address';
        $valid = false;
    }

    if (empty($phone)) {
        $phoneError = 'Please enter Phone Number';
        $valid = false;
    }

    // update data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE employees  set firstName = ?, lastName = ?, email = ?, phone =? WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($firstName,$lastName,$email,$phone,$id));
        Database::disconnect();
        header("Location: employees.php");
    }
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM employees where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $firstName = $data['firstName'];
    $lastName = $data['lastName'];
    $email = $data['email'];
    $phone = $data['phone'];
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
            <h3>Update Employee</h3>
        </div>

        <form class="form-horizontal" action="e_update.php?id=<?php echo $id?>" method="post">
            <div class="control-group <?php echo !empty($firstNameError)?'error':'';?>">
                <label class="control-label">First Name</label>
                <div class="controls">
                    <input name="firstName" type="text"  placeholder="First Name" value="<?php echo !empty($firstName)?$firstName:'';?>">
                    <?php if (!empty($firstNameError)): ?>
                        <span class="help-inline"><?php echo $firstNameError;?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group <?php echo !empty($lastNameError)?'error':'';?>">
                <label class="control-label">Last Name</label>
                <div class="controls">
                    <input name="lastName" type="text"  placeholder="Last Name" value="<?php echo !empty($lastName)?$lastName:'';?>">
                    <?php if (!empty($lastNameError)): ?>
                        <span class="help-inline"><?php echo $lastNameError;?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
                <label class="control-label">Email Address</label>
                <div class="controls">
                    <input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
                    <?php if (!empty($emailError)): ?>
                        <span class="help-inline"><?php echo $emailError;?></span>
                    <?php endif;?>
                </div>
            </div>
            <div class="control-group <?php echo !empty($phoneError)?'error':'';?>">
                <label class="control-label">Phone Number</label>
                <div class="controls">
                    <input name="phone" type="text"  placeholder="Phone Number" value="<?php echo !empty($phone)?$phone:'';?>">
                    <?php if (!empty($phoneError)): ?>
                        <span class="help-inline"><?php echo $phoneError;?></span>
                    <?php endif;?>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success">Update</button>
                <a class="btn" href="employees.php">Back</a>
            </div>
        </form>
    </div>

</div> <!-- /container -->
</body>
</html>