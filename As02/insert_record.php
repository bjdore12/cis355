<?php
    #
    # Name:     Benjamin J. Dore
    #
    # Class:    Server Side Web Application Development
    #
    # Date:     02/05/2020
    #
    # Homework: As02
    #

    # connect
    $pdo = new PDO( 
        "mysql:host=10.8.30.49; dbname=bjdore355wi20", 
        'bjdore355wi20', 
        '*******'
    );

    $n = $_POST['msg'];
    $sql = "INSERT INTO messages (message) VALUES ('$n')";
    $pdo->query($sql);
    echo "<p>Your info has been added</p><br>";
    echo "<a href='display_list.php'>Back to list</a>"

?>
