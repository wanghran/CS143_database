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
<h1>Add new Movie</h1>
<form action="" method="POST">	
	Title<br/><input type="text" name="title" size= "100" value= " Enter Title"/><br/><br />
	Company<br/> <input type="text" name="company" size= "100" value= " Enter Company"/><br/><br/>
	Year<br/> <input type="text" name="year" size= "100" value= " Enter Year"/><br/><br/>
	MPAA Rating<br \> 
	<select name="rating">
            <option value="G">G</option>
            <option value="NC-17">NC-17</option>
            <option value="PG">PG</option>
            <option value="PG-13">PG-13</option>
            <option value="R">R</option>
            <option value="surrendere">surrendere</option>
    </select><br/><br/>
	Genre<br/>
		<input type="checkbox" name="genre_Action" value="Action">Action</input>
        <input type="checkbox" name="genre_Adult" value="Adult">Adult</input>
        <input type="checkbox" name="genre_Adventure" value="Adventure">Adventure</input>
        <input type="checkbox" name="genre_Animation" value="Animation">Animation</input>
        <input type="checkbox" name="genre_Comedy" value="Comedy">Comedy</input>
        <input type="checkbox" name="genre_Crime" value="Crime">Crime</input>
        <input type="checkbox" name="genre_Documentary" value="Documentary">Documentary</input>
        <input type="checkbox" name="genre_Drama" value="Drama">Drama</input><br \>
        <input type="checkbox" name="genre_Family" value="Family">Family</input>
        <input type="checkbox" name="genre_Fantasy" value="Fantasy">Fantasy</input>
        <input type="checkbox" name="genre_Horror" value="Horror">Horror</input>
        <input type="checkbox" name="genre_Musical" value="Musical">Musical</input>
        <input type="checkbox" name="genre_Mystery" value="Mystery">Mystery</input>
        <input type="checkbox" name="genre_Romance" value="Romance">Romance</input>
        <input type="checkbox" name="genre_Sci-Fi" value="Sci-Fi">Sci-Fi</input>
        <input type="checkbox" name="genre_Short" value="Short">Short</input>
        <input type="checkbox" name="genre_Thriller" value="Thriller">Thriller</input><br \>
        <input type="checkbox" name="genre_War" value="War">War</input>
        <input type="checkbox" name="genre_Western" value="Western">Western</input>
        <br/><br/>
		(Optional)<br/>
        IMDB Rating<br/> <input type="text" name="imdb" maxlength="3" size = 100><br/><br/>
        Rotten Tomatoes Rating<br/> <input type="text" name="rot" maxlength="3" size = 100><br/><br/>
        Tickets Sold<br/> <input type="text" name="tickets" maxlength="11" size = 100><br/><br/>
        Total Income<br/> <input type="text" name="income" maxlength="11" size = 100><br/>
        <br/><br/>
        <input type="submit" value="Add movie"/>
</form>

<?php
    $title = $_POST["title"];
    $year = $_POST["year"];
    $rating = $_POST["rating"];
    $company = $_POST["company"];
    $imdb = $_POST["imdb"];
    $rot = $_POST["rot"];
    $tickets = $_POST["tickets"];
    $income = $_POST["income"];
    $succeed = true; 

    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($title) && !empty($year))
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
        $title = "'" . mysql_real_escape_string($title) . "'";

        if (!empty($rating))
            $rating = "'" . mysql_real_escape_string($rating) . "'";
        else
            $rating = "NULL";

        if (!empty($company))
            $company = "'" . mysql_real_escape_string($company) . "'";
        else
            $company= "NULL";
        if (!empty($imdb))
            $imdb = (int) $imdb;
        else
            $imdb = "NULL";
        if (!empty($rot))
            $rot = (int) $rot;
        else
            $rot = "NULL";
        if (!empty($tickets))
            $tickets = (int) $tickets;
        else
            $tickets = "NULL";
        if (!empty($income))
            $income = (int) $income;
        else
            $income = "NULL";

        //Get new ID for new movie
        $query = "SELECT id FROM MaxMovieID";
        if (!$result = mysql_query($query)){
        	echo "Failed to find maxmovieID ";
            exit(1);
        }
        $row = mysql_fetch_assoc($result);
        $old_id = $row["id"];
        $new_id = $old_id + 1;
        mysql_free_result($result);
        //echo "old id is " . $old_id . "new id is " . $new_id;

        //Add to "Movie"
        $query = "INSERT INTO Movie (id, title, year, rating, company) VALUES ($new_id, $title, $year, $rating, $company)";
		if (!$result = mysql_query($query)){
        	echo "Failed to add to Movie";
            $succeed = false; 
        }

        //Update MaxMovieID
        $query = "UPDATE MaxMovieID SET id = $new_id where id = $old_id";
        if (!$result = mysql_query($query)){
            echo "Failed to update the MaxMovieID";
            $succeed = false; 
        }

        //Add to "MovieGenre"
        $AllGenres = ["genre_Action", "genre_Adult", "genre_Adventure", "genre_Animation", "genre_Comedy", "genre_Crime", 
        			"genre_Documentary", "genre_Drama", "genre_Family", "genre_Fantasy", "genre_Horror", "genre_Musical", 
        			"genre_Mystery", "genre_Romance", "genre_Sci-Fi", "genre_Short", "genre_Thriller", "genre_War", 
        			"genre_Western"];
        for ($i = 0; $i < count($AllGenres); $i++)
        {
            if (isset($_POST[$AllGenres[$i]])){
                $query = "INSERT INTO MovieGenre (mid,genre) VALUES ($new_id, '$genre')";
                if (!$result = mysql_query($query)){
                	echo "Failed to add to MovieGenre";
         		 	$succeed = false;;
                }                  
            } 
        }

        //Add to "MovieRating"
        $query = "INSERT INTO MovieRating (mid, imdb, rot) VALUES ($new_id, $imdb, $rot)";
         if (!$result = mysql_query($query)){
                echo "Failed to add to MovieRating";
         		$succeed = false;
        }  

        //Add to "MovieRating"
        $query = "INSERT INTO MovieRating (mid, imdb, rot) VALUES ($new_id, $imdb, $rot)";
        if (!$result = mysql_query($query)){
            echo "Failed to add to MovieRating";
            $succeed = false;
        }  

        //Add to "Sales"
        $query = "INSERT INTO Sales (mid, ticketsSold, totalIncome) VALUES ($new_id, $tickets, $income)";
        if (!$result = mysql_query($query)){
            echo "Failed to add to Sales";
            $succeed = false;
        }

        if ($succeed){
            mysql_query("COMMIT");
            echo "Successfully added a new Movie";
        }else {
            mysql_query("ROLLBACK");
            echo "Unsuccessfully added a new Movie";
        }

        mysql_close($db_connection);  
	}

?> 

</div>



</body>
</html>