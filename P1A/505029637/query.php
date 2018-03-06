<html>
<head>
    <title>CS 143 Project 1A</title>
</head>

<body>
    <header>
        <h1>CS 143 Project 1A</h1>
    </header>

    <p>
        <form action="" method="GET">
            <textarea name="query" cols="100" rows="10"><?php if (isset($_GET["query"])) echo htmlspecialchars($_GET["query"]);?>
            </textarea><br />
            <input type="submit" value="Submit" />
        </form>

        <?php
        if (!isset($_GET["query"]) || $_GET["query"] === "")
            die("No query entered.");
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

        $user_sql = $_GET["query"];
        if (!$result = mysql_query($user_sql)){
        	 echo "Connection failed: " . mysql_error($user_sql) . "\n";
            exit(1);
        }


        // Print table with results
        echo "Showing Results\n";
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

        mysql_free_result($result);
        mysql_close($db);
        ?>
    </p>
</body>
</html>