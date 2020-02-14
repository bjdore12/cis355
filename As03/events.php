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
                <h3>Events</h3>
            </div>
            <div class="row">
                <p>
                    <a href="e_create.php" class="btn btn-success">Create</a>
                    <a href="../index.php" class="btn btn-secondary">Back to Home</a>
                </p>
                <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Event Description</th>
                      <th>Event Location</th>
                      <th>Event Date</th>
                      <th>Event Time</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   include 'database.php';
                   $pdo = Database::connect();
                   $sql = 'SELECT id, DATE_FORMAT(event_date, "%m/%d/%Y") As event_date, TIME_FORMAT(event_time, "%h:%i %p") As event_time, event_location, event_description FROM events ORDER BY id DESC';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['event_description'] . '</td>';
                            echo '<td>'. $row['event_location'] . '</td>';
                            echo '<td>'. $row['event_date'] . '</td>';
                            echo '<td>'. $row['event_time'] . '</td>';
                            echo '<td width=250>';
                            echo '<a class="btn" href="e_read.php?id='.$row['id'].'">Read</a>';
                            echo ' ';
                            echo '<a class="btn btn-success" href="e_update.php?id='.$row['id'].'">Update</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="e_delete.php?id='.$row['id'].'">Delete</a>';
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