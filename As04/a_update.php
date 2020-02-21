<?php
     
    require '../As03/database.php';

    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: assignments.php");
    }

    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $eventError = null;
         
        // keep track post values
        $name = $_POST['name'];
        $event = $_POST['event'];
         
        // validate input
        $valid = true;
        if (empty($name)) {
            $nameError = 'Please choose Name';
            $valid = false;
        }
         
        if (empty($event)) {
            $eventError = 'Please select Event';
            $valid = false;
        }
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE assignments SET cust_id = ?, event_id = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($name, $event, $id));
            Database::disconnect();
            header("Location: assignments.php");
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
                        <h3>Update an Assignment</h3>
                    </div>

                    <?php

                        $pdo = Database::connect();
                        $query = "SELECT customers.id As cust_id, customers.name FROM customers, assignments WHERE assignments.id = $id AND customers.id = assignments.cust_id";

                    ?>
             
                    <form class="form-horizontal" action="a_update.php?id=<?php echo $id ?>" method="post">

                      <div class="control-group">
                        <label class="control-label">Name</label>
                        <div class="controls">
                            <?php echo "<select class='form-control' name='name' id='name' disabled>";
								foreach ($pdo->query($query) as $row) {
									echo "<option value = '" . $row['cust_id'] . " '> " . $row['name'] . "</option>";
                                }
                                echo "</select>";
                            ?>
                        </div>
                      </div>

                      <?php

                            $pdo = Database::connect();
                            $query = 'SELECT events.id As event_id, events.event_description FROM events';

                        ?>

                      <div class="control-group">
                        <label class="control-label">Event</label>
                        <div class="controls">
                            <?php echo "<select class='form-control' name='event' id='event_description'>";
								foreach ($pdo->query($query) as $row) {
									echo "<option value='" . $row['event_id'] . " '> " . $row['event_description'] . "</option>";
                                }
                                echo "</select>";
                            ?>
                        </div>
                      </div>

                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Assign</button>
                          <a class="btn" href="assignments.php">Back</a>
                        </div>

                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>