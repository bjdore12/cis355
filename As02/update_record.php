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
    
    session_start();

    # connect
    $pdo = new PDO( 
        "mysql:host=10.8.30.49; dbname=bjdore355wi20", 
        'bjdore355wi20', 
        '58406aaA&'
    );

    $id = $_SESSION['$id'];
    $n = $_POST['msg'];

    $sql = "UPDATE messages SET message = '$n' WHERE id = '$id'";
    $pdo->query($sql);
    echo "<p>Update has been made!<br>";
    echo "<a href='display_list.php'>Back to list</a>"
?>