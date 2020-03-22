<?php

require 'database.php';

session_start();

if ( !empty($_POST)) {

    // set PHP variables from data in HTML form
    $fileName       = $_FILES['photo']['name'];
    $tempFileName   = $_FILES['photo']['tmp_name'];
    $fileSize       = $_FILES['photo']['size'];
    $fileType       = $_FILES['photo']['type'];

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
    $content = fread($fp, filesize($tempFileName));
    $content = addslashes($content);
    fclose($fp);

    // keep track validation errors
    $firstNameError = null;
    $lastNameError = null;
    $emailError = null;
    $phoneError = null;
    $passwordError = null;
    $titleError = null;

    // keep track post values
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $passwordHash = MD5($password);
    $title = $_POST['title'];

    // validate input
    $valid = true;
    if (empty($firstName)) {
        $firstNameError = 'Please enter First Name';
        $valid = false;
    }

    if (empty($lastName)) {
        $lastNameError = 'Please enter Last Name';
        $valid = false;
    }

    if (empty($email)) {
        $emailError = 'Please enter Email Address';
        $valid = false;
    } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        $emailError = 'Please enter a valid Email Address';
        $valid = false;
    }

    $pdo = Database::connect();
    $sql = "SELECT * FROM employees";
    foreach($pdo->query($sql) as $row) {
        if($email == $row['email']) {
            $emailError = 'Email has already been registered!';
            $valid = false;
        }
    }
    Database::disconnect();

    if (empty($phone)) {
        $phoneError = 'Please enter Phone Number';
        $valid = false;
    }

    if (empty($password)) {
        $passwordError = 'Please enter valid Password';
        $valid = false;
    }

    if (empty($title)) {
        $titleError = 'Please enter valid Title';
        $valid = false;
    }

    // insert data
    if ($valid) {

        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        $_SESSION['phone'] = $phone;
        $_SESSION['email'] = $email;
        $_SESSION['content'] = $content;
        $_SESSION['fileName'] = $fileName;
        $_SESSION['fileSize'] = $fileSize;
        $_SESSION['fileType'] = $fileType;
        $_SESSION['passwordHash'] = $passwordHash;
        $_SESSION['title'] = $title;

        header("Location: email_verify.php");
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
            <h3>Create an Account</h3>
        </div>
    </div>

    <div clas="row">
        <div class="card">
           <div class="card-body mx-auto">
        <form action="e_create.php" method="post" onsubmit="return Validate(this);" enctype="multipart/form-data">
            <div class="form-group <?php echo !empty($firstNameError)?'was-validated':'';?>">
                <label>First Name</label>
                <div class="controls">
                    <input class="form-control" required name="firstName" type="text"  placeholder="First Name" value="<?php echo !empty($firstName)?$firstName:'';?>">
                    <?php if (!empty($firstNameError)): ?>
                        <span class="invalid-feedback"><?php echo $firstNameError;?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group <?php echo !empty($lastNameError)?'was-validated':'';?>">
                <label>Last Name</label>
                <div class="controls">
                    <input class="form-control"required name="lastName" type="text"  placeholder="Last Name" value="<?php echo !empty($lastName)?$lastName:'';?>">
                    <?php if (!empty($lastNameError)): ?>
                        <span class="invalid-feedback"><?php echo $lastNameError;?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group <?php echo !empty($emailError)?'was-validated':'';?>">
                <label>Email Address</label>
                <div class="controls">
                    <input class="form-control" required name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?'':'';?>">
                    <?php if (!empty($emailError)): ?>
                        <span class="invalid-feedback"><?php echo $emailError;?></span>
                    <?php endif;?>
                </div>
            </div>


            <div class="form-group <?php echo !empty($phoneError)?'was-validated':'';?>">
                <label>Phone Number</label>
                <div class="controls">
                    <input class="form-control" required name="phone" type="text"  placeholder="Phone Number" value="<?php echo !empty($phone)?$phone:'';?>">
                    <?php if (!empty($phoneError)): ?>
                        <span class="invalid-feedback"><?php echo $phoneError;?></span>
                    <?php endif;?>
                </div>
            </div>

            <div class="form-group <?php echo !empty($passwordError)?'was-validated':'';?>">
                <label>Password</label>
                <div class="controls">
                    <input class="form-control" name="password" type="password" placeholder="Enter Passsword" required value="<?php echo !empty($password)?$password:'';?>">
                    <?php if (!empty($passwordError)): ?>
                        <span class="invalid-feedback"><?php echo $passwordError;?></span>
                    <?php endif;?>
                </div>
            </div>

            <div class="form-group">
                <label>Title</label>
                <div class="controls">
                    <select required class="form-control" name="title">
                        <option value="Employee" selected>User</option>
                        <option value="Administrator" >Administrator</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>User Photo</label>
                <div class="controls">
                    <input required name="photo" type="file" class="form-control-file border">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">Create</button>
                <a class="btn btn-primary" href="login.php">Back</a>
            </div>
        </form>
       </div>
    </div>
        <br>
        <footer>
            <small>&copy; Copyright 2020, Benjamin J. Dore</small>
        </footer>

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