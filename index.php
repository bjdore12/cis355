<!DOCTYPE html>

<html>

<head>
    <title>Benjamin Dore - CIS 355</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

    <div class="container">
        <div class="p-2">
            <div class="jumbotron col-sm-12 text-center shadow" style="background-color:rgb(65, 115, 116);">
                <h1 style="color: white">Benjamin Dore</h1>
                <p style="color:white; font-size:18px;">CIS 355 - Server Side Web Application Development</p>
            </div>
            <a href="https://georgecorser.com/courses/cis355/"><button type="button" class="btn btn-info shadow-sm" style="margin-top: 10px">CIS 355 Course Page</button></a>
            <a href="https://github.com/bjdore12/cis355"><button type="button" class="btn btn-info shadow-sm" style="margin-top: 10px">Ben's Github</button></a>
            <div class="float-sm-right">
                <a href="http://webp.svsu.edu/~bjdore/CIS255/cis255.html"><button type="button" class="btn btn-info shadow-sm" style="margin-top: 10px">Ben's CIS 255 Page</button></a>
                <button type="button" class="btn btn-info shadow-sm" style="margin-top: 10px"><?php echo "Date: " . date("m/d/Y"); ?></button>
            </div><br>
        </div>
    </div>

    <div class="container">
        <div class="p-2">

            <p><b>This page contains links to assignments for CIS 355 (Winter 2020): Server Side Web Application Development.</b></p>
            <p>See below for assignments:</p>

            <div class="list-group">
                <a href="http://bjdore.000webhostapp.com" class="list-group-item list-group-item-action"><b>Assignment 1</b> - Introductory assignment to make sure things work and to get familiar with PHP</a>
                <a href="As02/display_list.php" class="list-group-item list-group-item-action"><b>Assignment 2</b> - Playing around with MySQL and PHP, create a CRUD app</a>
            </div>

            <br>

            <div class="card">
                <div class="card-header">
                    <a class="card-link">
                        <b>Assignment 3</b> - More practice with CRUD based web applications using a 'Customers' database and a 'Events' database
                    </a>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="As03/customers.php" class="list-group-item list-group-item-action"><b>Customers Database</b> - Link to access customers database portion of the assignment</a>
                        <a href="As03/events.php" class="list-group-item list-group-item-action"><b>Events Database</b> - Link to access events database portion of the assignment</a>
                        <a href="https://github.com/bjdore12/cis355/tree/master/As03" class="list-group-item list-group-item-action"><b>Link to Github</b> - View code used for assignment 3</a>
                    </div>
                </div>
            </div>

            <br>

            <div class="card">
                <div class="card-header">
                    <a class="card-link">
                        <b>Assignment 4</b> - Extension of assignment 3, using a junction table <span class="badge badge-info">New</span>
                    </a>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="As04/assignments.php" class="list-group-item list-group-item-action"><b>Assignments Database</b> - Link to access assignments database portion of the assignment</a>
                        <a href="https://github.com/bjdore12/cis355/tree/master/As04" class="list-group-item list-group-item-action"><b>Link to Github</b> - View code used for assignment 4</a>
                    </div>
                </div>
            </div>

            <br>

            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action disabled"><b>Assignment 5</b> - Pending assignment</a>
                <a href="#" class="list-group-item list-group-item-action disabled"><b>Assignment 6</b> - Pending assignment</a>
            </div>

            <br><br>

            <p>Below assignments are not graded and are simply for practice:</p>

            <div class="card">
                <div class="card-header">
                    <a class="card-link">
                        <b>Ungraded - File Upload</b> - Practice with creating a file upload system, with and without MySQL <span class="badge badge-info">New</span>
                    </a>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="http://bjdore.000webhostapp.com/Ungraded/Upload01/upload01.html" class="list-group-item list-group-item-action"><b>Upload One</b> - No MySQL implementation</a>
                        <a href="#" class="list-group-item list-group-item-action"><b>Upload Two</b> - MySQL implementation to hold the filepath</a>
                        <a href="#" class="list-group-item list-group-item-action"><b>Upload Three</b> - MySQL implementation, using a BLOB</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <hr>
</body>

<footer class="container">
    <div class="jumbotron" style="margin-bottom:0;background-color: white; height:5%">
        <p style="color:dimgray">© Copyright 2020 Benjamin J. Dore<br>
            Email: <a href="mailto:bjdore@svsu.edu?subject=You're doing awesome!&body=Such great work! A+ for you!">bjdore@svsu.edu</a></p>
    </div>
</footer>

</html>