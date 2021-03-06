<?php
     
    require 'database.php';
 
    if ( !empty($_POST)) {
        // keep track validation errors
        $descError = null;
        $locError = null;
        $dateError = null;
        $timeError = null;

         
        // keep track post values
        $desc = $_POST['evnt_desc'];
        $loc = $_POST['evnt_loc'];
        $date = $_POST['evnt_date'];
        $time = $_POST['evnt_time'];

         
        // validate input
        $valid = true;
        if (empty($desc)) {
            $descError = 'Please enter an Event Description';
            $valid = false;
        }
         
        if (empty($loc)) {
            $locError = 'Please enter an Event Location';
            $valid = false;
        }
        
        // FIX THIS TO VALIDATE INPUT
        if (empty($date)) {
            $dateError = 'Please enter an Event Date';
            $valid = false;
        }

        // FIX THIS TO VALIDATE INPUT
        if (empty($time)) {
            $timeError = 'Please enter an Event Time';
            $valid = false;
        }
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO events (event_description,event_location,event_date,event_time) values(?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($desc,$loc,$date, $time));
            Database::disconnect();
            header("Location: events.php");
        }
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
                        <h3>Create an Event</h3>
                    </div>
             
                    <form class="form-horizontal" action="e_create.php" method="post">
                      <div class="control-group <?php echo !empty($descError)?'error':'';?>">
                        <label class="control-label">Event Description</label>
                        <div class="controls">
                            <input name="evnt_desc" type="text"  placeholder="Event Description" value="<?php echo !empty($desc)?$desc:'';?>">
                            <?php if (!empty($descError)): ?>
                                <span class="help-inline"><?php echo $descError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($locError)?'error':'';?>">
                        <label class="control-label">Event Location</label>
                        <div class="controls">
                            <input name="evnt_loc" type="text" placeholder="Event Location" value="<?php echo !empty($loc)?$loc:'';?>">
                            <?php if (!empty($locError)): ?>
                                <span class="help-inline"><?php echo $locError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($dateError)?'error':'';?>">
                        <label class="control-label">Event Date</label>
                        <div class="controls">
                            <input name="evnt_date" type="date"  placeholder="Event Date" value="<?php echo !empty($date)?$date:'';?>">
                            <?php if (!empty($dateError)): ?>
                                <span class="help-inline"><?php echo $dateError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($timeError)?'error':'';?>">
                        <label class="control-label">Event Time</label>
                        <div class="controls">
                            <input name="evnt_time" type="time"  placeholder="Event Time" value="<?php echo !empty($time)?$time:'';?>">
                            <?php if (!empty($timeError)): ?>
                                <span class="help-inline"><?php echo $timeError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="events.php">Back</a>
                        </div>
                    </form>
                </div>
    </div> <!-- /container -->
  </body>
</html>