<?php
$db = mysqli_connect('localhost', 'root', 'root') or die('Unable to connect. Check your connection parameters.');
mysqli_select_db($db, 'moviesite') or die(mysqli_error($db));

$people_name = $people_isactor = $people_isdirector = '';

if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    // Retrieve the record's information
    $query = 'SELECT people_name, people_isactor, people_isdirector FROM people WHERE people_id = ' . $_GET['id'];
    $result = mysqli_query($db, $query) or die(mysqli_error($db));

    if ($row = mysqli_fetch_assoc($result)) {
        extract($row);
    }
}
?>

<html>
<head>
    <title>Edit Person</title>
</head>
<body>
    <form action="commit_people.php?action=edit&type=people" method="post">
        <table>
            <tr>
                <td>Person Name</td>
                <td><input type="text" name="people_name" value="<?php echo $people_name; ?>" /></td>
            </tr>
            <tr>
                <td>Is Actor</td>
                <td><input type="checkbox" name="people_isactor" value="1" <?php echo ($people_isactor == 1) ? 'checked' : ''; ?> /></td>
            </tr>
            <tr>
                <td>Is Director</td>
                <td><input type="checkbox" name="people_isdirector" value="1" <?php echo ($people_isdirector == 1) ? 'checked' : ''; ?> /></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <?php
                    if (isset($_GET['action']) && $_GET['action'] == 'edit') {
                        echo '<input type="hidden" value="' . $_GET['id'] . '" name="people_id" />';
                    }
                    ?>
                    <input type="submit" name="submit" value="Edit Person" />
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
