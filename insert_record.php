<?php

    # connect
    $pdo = new PDO( 
        "mysql:host=10.8.30.49; dbname=bjdore355wi20", 
        'bjdore355wi20', 
        '58406aaA&'
    );

    $n = $_POST['msg'];
    $sql = "INSERT INTO messages (message) VALUES ('$n')";
    $pdo->query($sql);
    echo "<p>Your info has been added</p><br>";
    echo "<a href='display_list.php'>Back to list</a>"

?>