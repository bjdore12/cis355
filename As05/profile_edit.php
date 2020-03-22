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
    header("Location: employees.php");
}

if ( !empty($_POST)) {

    // set PHP variables from data in HTML form
    $fileName       = $_FILES['photo']['name'];
    $tempFileName   = $_FILES['photo']['tmp_name'];
    $fileSize       = $_FILES['photo']['size'];
    $fileType       = $_FILES['photo']['type'];

    //print_r($_FILES);

    // abort if no filename
    if (!$fileName) {
        die("No filename.");
    }

    // abort if file is not an image
    // never assume the upload succeeded
    if ($_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
        echo"<p>Upload failed with error code " . $_FILES['file']['error'] . "</p>";
    }
    $info = getimagesize($_FILES['photo']['tmp_name']);
    if ($info === FALSE) {
        echo"<p>Error Unable to determine <i>image</i> type of uploaded file</p>";
    }
    if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG)
        && ($info[2] !== IMAGETYPE_PNG)) {
        echo "<p>Not a gif/jpeg/png</p>";
    }

    // abort if file is too big
    if($fileSize > 2000000) { echo "Error: file exceeds 1MB."; exit(); }

    // put the content of the file into a variable, $content
    $fp      = fopen($tempFileName, 'r');
    $userPic = fread($fp, filesize($tempFileName));
    $userPic = addslashes($userPic);
    fclose($fp);

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
//userPic = $userPic, fileName = $fileName, fileSize = $fileSize, fileType = $fileType
    // update data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE employees SET firstName = '$firstName', lastName = '$lastName', email = '$email', phone = '$phone', userPic = '$userPic', fileName = '$fileName', fileSize = $fileSize, fileType = '$fileType' WHERE id = $sessionID";
        $q = $pdo->prepare($sql);
        //$q->bindParam(':firstName', $firstName);
        //$q->bindParam(':lastName', $lastName);
        //$q->bindParam(':email', $email);
        //$q->bindParam(':phone', $phone);
        //$q->bindParam(':content', $content);
        //$q->bindParam(':fileName', $fileName);
        //$q->bindParam(':fileSize', $fileSize);
        //$q->bindParam(':fileType', $fileType);
        //$q->bindParam(':sessionID', $sessionID);
        $q->execute(array());
        Database::disconnect();
        header("Location: profile.php");
    }
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM employees where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($sessionID));
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
            <h3>Update Profile</h3>
        </div>

        <form class="form-horizontal" action="profile_edit.php?id=<?php echo $id?>" method="post" onsubmit="return Validate(this);" enctype="multipart/form-data">
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
            <div class="control-group">
                <label class="control-label">User Photo</label>
                <div class="controls">
                    <input required name="photo" type="file" class="form-control-file border">
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success">Update</button>
                <a class="btn" href="profile.php">Back</a>
            </div>
        </form>
    </div>

    <script>
        var _validFileExtensions = [".jpg", ".jpeg", ".gif", ".png"];
        function Validate(oForm) {
            var arrInputs = oForm.getElementsByTagName("input");
            for (var i = 0; i < arrInputs.length; i++) {
                var oInput = arrInputs[i];
                if (oInput.type == "file") {
                    var sFileName = oInput.value;
                    if (sFileName.length > 0) {
                        var blnValid = false;
                        for (var j = 0; j < _validFileExtensions.length; j++) {
                            var sCurExtension = _validFileExtensions[j];
                            if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                                blnValid = true;
                                break;
                            }
                        }

                        if (!blnValid) {
                            alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                            return false;
                        }
                    }
                }
            }

            return true;
        }
    </script>

</div> <!-- /container -->
</body>
</html>