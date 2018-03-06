<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<div class="nav_bar">
    <h3>Add new content</h3>
    <a href="addMovie.php"> Add Movie</a>
    <a href="addActorDir.php"> Add Actor/Director</a>  
    <a href="addReview.php"> Add Review</a>
    <a href="addMARelation.php"> Add Movie/Actor Relation</a>
    <a href="addMDRelation.php"> Add Movie/Director Relation</a>
    <h3>Browsering Content</h3>
    <a href="showActor.php?aid=47801"> Show Actor information</a>
    <a href="showMovie.php?id=106"> Show Movie information</a>
    </ul>
    <h3>Search Actor/Movie</h3>
    <a href="search.php"> Search Actor/Movie</a>
    <br />
</div>

<div class="target">
<h1>Add new Actor/Director</h1>
<form action="" method="POST">  
    <input type="radio" name="identity" value="Actor" checked="true">Actor
        <input type="radio" name="identity" value="Director">Director<br /><br />
    
    First Name<br /> <input type="text" name="first" maxlength="20" size=100><br /><br />
    Last Name<br />  <input type="text" name="last" maxlength="20" size=100><br /><br />
    Sex<br /> <input type="radio" name="sex" value="Male" checked="true">Male
        <input type="radio" name="sex" value="Female">Female<br /><br />
    Date of Birth<br />  <input type="text" name="dob" size=100><br /><br />
    Date of Death<br />  <input type="text" name="dod" size=100><br />
    (Leave blank if alive now) <br /><br /><br/>
    <input type="submit" value="Add!"/>
</form>

<?php
    $last = $_POST["last"];
    $first = $_POST["first"];
    $sex = $_POST["sex"];
    $identity = $_POST["identity"];
    $dob = $_POST["company"];
    $dod = $_POST["imdb"];
    $succeed = true;
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($last) && !empty($first))
    {
        $db_connection = mysql_connect("localhost", "cs143", "");

        if (!$db_connection){
            echo "Connection failed: " . mysql_error($db_connection) . "\n";
            exit(1);
        }

        $db_selected = mysql_select_db("CS143", $db_connection);
        if (!$db_selected){
            echo "Connection failed: " . mysql_error($db_selected) . "\n";
            exit(1);
        }

        //convert title to readable formate
        $first = "'" . mysql_real_escape_string($first). "'";
        $last = "'" . mysql_real_escape_string($last) . "'";
        $sex = "'" . mysql_real_escape_string($sex) . "'";
        $dob = "'" . mysql_real_escape_string($dob) . "'";

        if (!empty($dod))
            $dod = "'" . mysql_real_escape_string($dod) . "'";
        else
            $dod = "NULL";

        //Get new ID for new person
        $query = "SELECT id FROM MaxPersonID";
        if (!$result = mysql_query($query)){
            echo "Failed to find maxmovieID ";
            exit(1);
        }
        $row = mysql_fetch_assoc($result);
        $old_id = $row["id"];
        $new_id = $old_id + 1;
        mysql_free_result($result);
        //echo "old id is " . $old_id . "new id is " . $new_id;

        //Add to "Actor"
        if ($identity === "Actor"){
            $query = "INSERT INTO Actor (id, last, first, sex, dob, dod) VALUES ($new_id, $last, $first, $sex, $dob, $dod)";
            if (!$result = mysql_query($query)){
                echo "Failed to add to Actor";
                $succeed = false;
            }
        }
        
        //Add to "Director"
        if ($identity === "Director"){
            $query = "INSERT INTO Director (id, last, first, sex, dob, dod) VALUES ($new_id, $last, $first, $sex, $dob, $dod)";
            if (!$result = mysql_query($query)){
                echo "Failed to add to Director";
                $succeed = false;
            }
        }

        //Update MaxPersonID
        $query = "UPDATE MaxPersonID SET id = $new_id where id = $old_id";
        if (!$result = mysql_query($query)){
            echo "Failed to update the MaxMovieID";
            exit(1);
        }

        if ($succeed){
            mysql_query("COMMIT");
            echo "Successfully added a new Actor/Director";
        }else {
            mysql_query("ROLLBACK");
            echo "Unsuccessfully added";
        }

        mysql_close($db_connection);  
    }

?> 

</div>



</body>
</html>