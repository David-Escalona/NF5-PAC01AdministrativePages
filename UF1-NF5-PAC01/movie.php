<?php
$db = mysqli_connect('localhost', 'root', 'root') or die('Unable to connect. Check your connection parameters.');
mysqli_select_db($db, 'moviesite') or die(mysqli_error($db));

$movie_name = $movie_type = $movie_year = $movie_leadactor = $movie_director = '';

if ($_GET['action'] == 'edit' && isset($_GET['id'])) {
    // retrieve the record's information 
    $query = 'SELECT
            movie_name, movie_type, movie_year, movie_leadactor, movie_director
        FROM
            movie
        WHERE
            movie_id = ' . $_GET['id'];
    $result = mysqli_query($db, $query) or die(mysqli_error($db));
    
    if ($row = mysqli_fetch_assoc($result)) {
        extract($row);
    }
} else {
    // set values to blank
    $movie_year = date('Y');
}

?>
<html>
 <head>
  <title><?php echo ucfirst($_GET['action']); ?> Movie</title>
 </head>
 <body>
  <form action="commit.php?action=<?php echo $_GET['action']; ?>&type=movie" method="post">
   <table>
    <tr>
     <td>Movie Name</td>
     <td><input type="text" name="movie_name" value="<?php echo $movie_name; ?>"/></td>
    </tr><tr>
     <td>Movie Type</td>
     <td><select name="movie_type">
        <?php
        // select the movie type information
        $query = 'SELECT movietype_id, movietype_label FROM movietype ORDER BY movietype_label';
        $result = mysqli_query($db, $query) or die(mysqli_error($db));

        // populate the select options with the results
        while ($row = mysqli_fetch_assoc($result)) {
            $selected = ($row['movietype_id'] == $movie_type) ? 'selected="selected"' : '';
            echo '<option value="' . $row['movietype_id'] . '" ' . $selected . '>';
            echo $row['movietype_label'] . '</option>';
        }
        ?>
      </select></td>
    </tr><tr>
     <td>Movie Year</td>
     <td><select name="movie_year">
        <?php
        // populate the select options with years
        for ($yr = date("Y"); $yr >= 1970; $yr--) {
            $selected = ($yr == $movie_year) ? 'selected="selected"' : '';
            echo '<option value="' . $yr . '" ' . $selected . '>' . $yr . '</option>';
        }
        ?>
      </select></td>
    </tr><tr>
     <td>Lead Actor</td>
     <td><select name="movie_leadactor">
        <?php
        // select actor records
        $query = 'SELECT people_id, people_fullname FROM people WHERE people_isactor = 1 ORDER BY people_fullname';
        $result = mysqli_query($db, $query) or die(mysqli_error($db));

        // populate the select options with the results
        while ($row = mysqli_fetch_assoc($result)) {
            $selected = ($row['people_id'] == $movie_leadactor) ? 'selected="selected"' : '';
            echo '<option value="' . $row['people_id'] . '" ' . $selected . '>';
            echo $row['people_fullname'] . '</option>';
        }
        ?>
      </select></td>
    </tr><tr>
     <td>Director</td>
     <td><select name="movie_director">
        <?php
        // select director records
        $query = 'SELECT people_id, people_fullname FROM people WHERE people_isdirector = 1 ORDER BY people_fullname';
        $result = mysqli_query($db, $query) or die(mysqli_error($db));

        // populate the select options with the results
        while ($row = mysqli_fetch_assoc($result)) {
            $selected = ($row['people_id'] == $movie_director) ? 'selected="selected"' : '';
            echo '<option value="' . $row['people_id'] . '" ' . $selected . '>';
            echo $row['people_fullname'] . '</option>';
        }
        ?>
      </select></td>
    </tr><tr>
     <td colspan="2" style="text-align: center;">
        <?php
        if ($_GET['action'] == 'edit') {
            echo '<input type="hidden" value="' . $_GET['id'] . '" name="movie_id" />';
        }
        ?>
      <input type="submit" name="submit" value="<?php echo ucfirst($_GET['action']); ?>" />
     </td>
    </tr>
   </table>
  </form>
 </body>
</html>
