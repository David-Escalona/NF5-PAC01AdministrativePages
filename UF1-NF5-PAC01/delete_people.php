<?php
$db = mysqli_connect('localhost', 'root', 'root') or die('Unable to connect. Check your connection parameters.');
mysqli_select_db($db, 'moviesite') or die(mysqli_error($db));

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    // Delete person record
    $query = 'DELETE FROM people WHERE people_id = ' . $_GET['id'];
    $result = mysqli_query($db, $query) or die(mysqli_error($db));
    
    // If needed, update movie records referencing the deleted person as an actor or director
    $update_query = 'UPDATE movie SET
                        movie_leadactor = 0
                    WHERE
                        movie_leadactor = ' . $_GET['id'];
    $update_result = mysqli_query($db, $update_query) or die(mysqli_error($db));
}
?>

<html>
<head>
    <title>Delete Person</title>
</head>
<body>
    <p style="text-align: center;">
        <?php if (isset($result) && $result) : ?>
            Person has been deleted.<br />
        <?php else : ?>
            Unable to delete person.<br />
        <?php endif; ?>
        <a href="admin.php">Return to People Index</a>
    </p>
</body>
</html>
