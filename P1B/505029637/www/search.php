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
    <h1>Searching Page</h1>
    <form action="search.php" method="GET">
        Search:<br/>
        <input type="text" name="keyword"/><br/><br/>
        <input type="submit" value="Click Me!" />
    </form>

    <?php
	if (!isset($_GET["keyword"]) || $_GET["keyword"] === ""){
		echo "Please enter keyword";
	}
    //store keywords 
    $keywords = explode(" ", $_GET["keyword"]);
    //echo "Keywords are" . $keywords . "\n" . "size is " . count($keywords);

    //Search for Movie
    for ($i = 0; $i < (count($keywords) - 1); $i++){
        $condition .= "title LIKE '%" . $keywords[$i] . "%' AND ";
    }
    $last_id = count($keywords) - 1;
    $condition .= "title LIKE '%" .$keywords[$last_id] . "%'";
    $query = "select title, year, id from Movie where " . $condition . ";";
    //echo $query;

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

    if (!$result = mysql_query($query)){
            echo "Failed to search in Movie";
            exit(1);
    }

    if (mysql_num_rows($result) === 0)
        echo "No matching movies found.<br/>";
    else
        echo "Found movies:<br/>";

    // Print table with results
    echo "Movie Information is : <br/>";
    echo "<br/><table>";
    echo "<tr>";
        echo "<td>Movie</td>";
        echo "<td>Year</td>";
    echo "</tr>";

    while ($row = mysql_fetch_assoc($result)) {
        echo "<tr>";
            $year = $row["year"];
            $id = $row["id"];
            $title = $row["title"];
            echo "<td>" . "<a href=\"./showMovie.php?id=$id\">$title</a>" . "</td>";
            echo "<td>" . $year . "</td>";
        echo "</tr>";
    }  
    echo "</table><br/>";

    //Search for Actor
    $condition = ""; 
    for ($i = 0; $i < (count($keywords) - 1); $i++){
        $condition .= "(last LIKE '%" . $keywords[$i] . "%' Or first LIKE '%" . $keywords[$i] . "%') AND" ;
    }
    $last_id = count($keywords) - 1;
    $condition .= "(last LIKE '%" . $keywords[$last_id] . "%' Or first LIKE '%" .               $keywords[$last_id] . "%')";
    $query = "select * from Actor where " . $condition . "ORDER BY dob;";

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

    if (!$result = mysql_query($query)){
            echo "Failed to search in Movie";
            exit(1);
    }

    if (mysql_num_rows($result) === 0)
        echo "No matching Actor found.<br/>";
    else
        echo "<br/>Found Actor:<br/>";

    // Print table with results
    echo "Actor Information is : <br/>";
    echo "<br/><table>";
    echo "<tr>";
        echo "<td>ID</td>";
        echo "<td>Name</td>";
        echo "<td>Date of Birth</td>";
    echo "</tr>";

    while ($row = mysql_fetch_assoc($result)) {
        echo "<tr>";
            $name = "$row[first] $row[last]";
            $aid = $row["id"];
            $dob = $row["dob"];
            echo "<td>" . $aid . "</td>";
            echo "<td>" . "<a href=\"./showActor.php?aid=$aid\">$name</a>" . "</td>";
            echo "<td>" . $dob . "</td>";
        echo "</tr>";
    }    
    echo "</table>";

    mysql_free_result($result);
    mysql_close($db_connection);

    ?>
    </div>  
</body>
</html>