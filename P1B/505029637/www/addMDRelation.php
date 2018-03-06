<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <style type="text/css">
        input[type="text"]{
            height: 30px;
            border: 1px solid grey;
            border-radius: 5px;
        }

        #select_bar {
            height: 30px;
            border: 1px solid grey;
            border-radius: 5px;
            width: 60%;
        }
    </style>
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
<h1>Add new Movie and Director Relation</h1>

<?php

    //get input variables
    $mid_tmp = explode("-", $_POST["movie"]);
    $mid = (int)$mid_tmp[0];
    $did_tmp = explode("-", $_POST["director"]);
    $did = (int)$did_tmp[0];


    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($mid) && !empty($did)){
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


        $query = "INSERT INTO MovieDirector(mid, did) VALUES ($mid, $did);";

        if (!$result = mysql_query($query)){
            echo "Failed to add Movie/Director Relation ";
            exit(1);
        }
            
        mysql_close($db_connection); 
        echo "Successfully added Movie and Director relation";
    }   


?>
<form action="" method="POST">  
    <?php 
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

        //Find all movies
        $query = "SELECT * FROM Movie ORDER BY title ASC;";
        if (!$result = mysql_query($query)){
            echo "Failed to search in Movie";
            exit(1);
        }

        echo "Movie <br/>";
        echo '<select name="movie" id="select_bar">';
        while ($row = mysql_fetch_assoc($result)) {
            $movie_title = $row["title"];
            $mid = $row["id"];
            echo "<option>" . $mid . "-" . $movie_title . "</option>";
        }    
        echo "</select><br/>";

        //Find all Director
        $query = "SELECT * FROM Director ORDER BY last ASC;";
        if (!$result = mysql_query($query)){
            echo "Failed to search in Movie";
            exit(1);
        }

        echo "<br/>Director<br/>";
        echo '<select name="director" id="select_bar">';
        while ($row = mysql_fetch_assoc($result)) {
            $first = $row["first"];
            $last = $row["last"];
            $did = $row["id"];
            echo "<option>" . $did . "-" .  $last . ", " . $first . "</option>";
        }    
        echo "</select><br/>";

        mysql_free_result($result);
        mysql_close($db_connection);

    ?>

    <br/><br/><br/><input type="submit" value="Add!"/>
</form> 

</div>



</body>
</html>