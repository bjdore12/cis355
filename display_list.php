<?php
    # connect
    # testing
    $pdo = new PDO( 
        "mysql:host=".'10.8.30.49'.";"."dbname=".'bjdore355wi20', 
        'bjdore355wi20', 
        '58406aaA&'
    );
    # display link to "create" form
    echo "<a href='display_create_form.php'>Create</a><br><br>";
    # display all records
    $sql = 'SELECT * FROM messages';
    foreach ($pdo->query($sql) as $row) {
        $str = "";
        $str .= "<a href='display_read_form.php?id=" . $row['id'] . "'>Read</a> ";
        $str .= "<a href='display_update_form.php?id=" . $row['id'] . "'>Update</a> ";
        $str .= "<a href='display_delete_form.php?id=" . $row['id'] . "'>Delete</a> ";
        $str .= ' (' . $row['id'] . ') ' . $row['message'];
        $str .=  '<br>';
        echo $str;
    }
    echo '<br />'; 

?>