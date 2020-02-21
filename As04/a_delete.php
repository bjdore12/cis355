<?php
    require '../As03/database.php';
    $id = 0;
     
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( !empty($_POST)) {
        // keep track post values
        $id = $_POST['id'];
         
        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM assignments WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        Database::disconnect();
        header("Location: assignments.php");
         
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
                        <h3>Delete an Assignment</h3>
                    </div>

                    <?php

                        $pdo = Database::connect();
                        $query = "SELECT customers.name As name, event_description FROM assignments, events, customers WHERE assignments.cust_id = customers.id AND assignments.event_id = events.id AND assignments.id = $id"; 

                        foreach($pdo->query($query) As $result) {

                            $name = $result["name"];
                            $event = $result["event_description"];
                        }
                    ?>
                     
                    <form class="form-horizontal" action="a_delete.php" method="post">
                      <input type="hidden" name="id" value="<?php echo $id;?>"/>
                      <p class="alert alert-error">Are you sure you want to delete <?php echo $name; ?>'s event: <?php echo $event;?>?</p>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-danger">Yes</button>
                          <a class="btn" href="assignments.php">No</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>