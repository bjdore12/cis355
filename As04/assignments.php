<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
            <div class="row">
                <h3>Assignments</h3>
            </div>
            <div class="row">
                <p>
                    <a href="a_create.php" class="btn btn-success">Create</a>
                    <a href="../As03/customers.php" class="btn btn-secondary">Customers</a>
                    <a href="../As03/events.php" class="btn btn-secondary">Events</a>
                    <a href="../index.php" class="btn btn-secondary">Back to Home</a>
                </p>
                <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Customer Name</th>
                      <th>Customer Email</th>
                      <th>Event Description</th>
                      <th>Event Location</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   include '../As03/database.php';
                   $pdo = Database::connect();
                   $sql = 'SELECT assignments.id As as_id, name, email, event_description, event_location FROM assignments, customers, events WHERE assignments.cust_id = customers.id AND assignments.event_id = events.id';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['name'] . '</td>';
                            echo '<td>'. $row['email'] . '</td>';
                            echo '<td>'. $row['event_description'] . '</td>';
                            echo '<td>'. $row['event_location'] . '</td>';
                            echo '<td width=250>';
                            echo '<a class="btn" href="a_read.php?id='.$row['as_id'].'">Read</a>';
                            echo ' ';
                            echo '<a class="btn btn-success" href="a_update.php?id='.$row['as_id'].'">Update</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="a_delete.php?id='.$row['as_id'].'">Delete</a>';
                            echo '</td>';
                            echo '</tr>';
                   }
                   Database::disconnect();
                  ?>
                  </tbody>
            </table>
        </div>
    </div> <!-- /container -->
  </body>
</html>