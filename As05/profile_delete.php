<?php

session_start();
if (!isset($_SESSION["employee_id"])) { // if "user" not set,
    session_destroy();
    header('Location: login.php');     // go to login page
    exit;
}

$sessionID = $_SESSION['employee_id'];

require 'database.php';

$confirm = "";
if (!empty($_POST['confirm'])) {
    $confirm = $_POST['confirm'];
}

if ($confirm=='true') {

    // delete data
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM employees  WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($sessionID));
    Database::disconnect();
    session_destroy();
    header("Location: login.php");

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
            <h3>Delete Account</h3>
        </div>

        <form class="form-horizontal" action="profile_delete.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id;?>"/>
            <p class="alert alert-error">Are you sure you want to delete your account? This process cannot be undone.</p>
            <div class="form-actions">
                <button type="submit" name="confirm" value='true' class="btn btn-danger">Yes</button>
                <a class="btn" href="profile.php">No</a>
            </div>
        </form>
    </div>

</div> <!-- /container -->
</body>
</html>