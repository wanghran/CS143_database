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
    <h1>Show Actor Information<h1>
    <form action="search.php" method="GET">
        Search:<br/>
        <input type="text" name="keyword" value="Search..." /><br/><br/>
        <input type="submit" value="Click Me!" />
    </form>

    <?php
    if (!isset($_GET["aid"]) || $_GET["aid"] === ""){
        echo "Please enter keyword";
        exit(1);
    }

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


    $aid = (int) $_GET["aid"];

    // Find actor info
    $query = "SELECT * FROM Actor WHERE id=" . $aid . ";";
    if (!$result = mysql_query($query)){
         echo "Connection failed for given query " ;
        exit(1);
    }

    if (mysql_num_rows($result) != 1){
        echo "Failed to find actor by given id";
        exit(1);
    }

    //print actor info
    echo "Actor Information is : \n";
    echo "<table>\n";
    echo "<tr>";
    for ($i = 0; $i < mysql_num_fields($result); $i++) {
        $field = mysql_fetch_field($result, $i);
        echo "<td>" . $field->name . "</td>";
    }
    echo "</tr>\n";
    while ($row = mysql_fetch_row($result)) {
        echo "<tr>";
        for ($i = 0; $i < mysql_num_fields($result); $i++) {
            $val = $row[$i];
            if (is_null($val)){
                $val = "N/A";
            }
            echo "<td>" . $val . "</td>";
        }
        echo "</tr>\n";
    }    
    echo "</table>\n";

    //Find Actor's Movies and Role info
    $query = "SELECT ma.role, m.title, ma.mid FROM MovieActor as ma, Movie as m  WHERE ma.aid=" . $aid . " AND ma.mid = m.id;";
    if (!$result = mysql_query($query)){
         echo "Connection failed for given query " ;
        exit(1);
    }

    //print actor's movie and row
    echo "<br/><br/>Actor's Movies and Roles";
    echo "<table>\n";
        echo "<tr>";
            echo "<td>" . "Role" . "</td>";
            echo "<td>" . "Movie" . "</td>";
        echo"</tr>";

        while ($row = mysql_fetch_assoc($result)) {
            $title = $row["title"];
            $role = $row["role"];
            $mid = $row["mid"];
            echo "<tr>";
                echo "<td>" . $role . "</td>";
                echo "<td>" . "<a href=\"./showMovie.php?id=$mid\">$title</a>" . "</td>";
            echo "</tr>\n";
        }    
    echo "</table>\n";

    mysql_free_result($result);
    mysql_close($db_connection);
    ?>
</div>

</body>
</html>