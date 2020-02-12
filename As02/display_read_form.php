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
        '***********'
    );

    # put the information for the chosen record into variable $results 
    $id = $_GET['id'];
    $sql = "SELECT * FROM messages WHERE id=" . $id;
    $query=$pdo->prepare($sql);
    $query->execute();
    $result = $query->fetch();
?>

<h1>Read/view existing message</h1>
<form method='post' action='display_list.php'>
    message: <input name='msg' type='text' value='<?php echo $result['message']; ?>' disabled><br />
    <input type="submit" value="Submit">
</form>
