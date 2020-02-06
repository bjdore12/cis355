<?php

    # connect
    $pdo = new PDO( 
        "mysql:host=10.8.30.49; dbname=bjdore355wi20", 
        'bjdore355wi20', 
        '58406aaA&'
    );

    $id = $_GET['id'];
    $sql = "SELECT * FROM messages WHERE id=" . $id;
    $query=$pdo->prepare($sql);
    $query->execute();
    $result = $query->fetch();


    function update($id) {
        $n = $_POST['msg'];

        $sql = "UPDATE messages SET message = '$n' WHERE id = '$id'";
        $pdo->query($sql);
        echo "<p>Update has been made!";
    }

    if (isset($_POST))
        update($id);

?>

<h1>Update existing message</h1>
<form method='post' action=''>
    message: <input name='msg' type='text' value='<?php echo $result['message']; ?>'><br />
    <input type="submit" value="Save">
</form>