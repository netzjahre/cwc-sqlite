<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "config.inc.php";
include "language.inc.php";
//next line for footer.inc.php
$siteid = $sid;


// Handle index drop request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['drop_indexes'])) {
    try {
        $db = new PDO("sqlite:$dbname");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $table = $tablename[$sid] ?? '';

        if (!empty($table)) {
            // Get the list of indexes
            $stmt = $db->query("PRAGMA index_list('$table')");
            $indexes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($indexes) {
                foreach ($indexes as $index) {
                    $indexName = $index['name'];
                    $isUnique = $index['unique']; // Check if it's a UNIQUE index

                    // Skip UNIQUE or PRIMARY KEY indexes
                    if ($isUnique) {
                        echo "<p style='color: orange;'>Skipped UNIQUE index: $indexName</p>";
                        continue;
                    }

                    // Drop regular index																				 
                    $db->exec("DROP INDEX IF EXISTS '$indexName'");
                    echo "<p style='color: green;'>Dropped index: $indexName</p>";																				  
                }
                echo "<p style='color: green;'>All indexes have been dropped successfully.</p>";
            } else {
                echo "<p style='color: orange;'>No indexes to drop.</p>";
            }
        } else {
            echo "<p style='color: red;'>Invalid table name.</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    } finally {
        $db = null;
    }
}
?>
<html>
<head>
    <title>Cookieless Web Counter - <?= htmlspecialchars($sitename[$sid] ?? 'Unknown') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes"/>
    <meta name="robots" content="noindex"/>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
    <h1>Cookieless Web Counter</h1>
    <p>Original (v. 20150324) by <a href="https://github.com/luciomarinelli/cwc">Lucio Marinelli</a>, modified by JF to meet own requirements</p>
    <br/>

    <?php
    echo "<h3>" . htmlspecialchars($sitename[$sid] ?? 'Unknown Site') . "</h3>";
    try {
        // Open the database
        $db = new PDO("sqlite:$dbname");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Enable TRUNCATE journal mode
        $db->exec("PRAGMA journal_mode = TRUNCATE;");

        // Fetch index list for the table
        $table = $tablename[$sid] ?? '';
        if (!empty($table)) {
            $stmt = $db->query("PRAGMA index_list('$table')");
            $indexes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($indexes) {
                echo "<h4>Indexes for table: $table</h4>";
				echo "<div class='flex-container'>";
                echo "<table border='1' cellpadding='5'>";
                echo "<tr><th>Seq</th><th>Name</th><th>Unique</th><th>Origin</th><th>Partial</th></tr>";
                foreach ($indexes as $index) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($index['seq']) . "</td>";
                    echo "<td>" . htmlspecialchars($index['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($index['unique']) . "</td>";
                    echo "<td>" . htmlspecialchars($index['origin']) . "</td>";
                    echo "<td>" . htmlspecialchars($index['partial']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
				echo "</div>";
                // Add a button to drop indexes
                echo "<form method='POST'>";
                echo "<button type='submit' name='drop_indexes' onclick=\"return confirm('Are you sure you want to drop all indexes?');\">Drop Indexes</button>";
                echo "</form>";												   
            } else {
                echo "<p>No indexes found for table: $table</p>";
            }
        } else {
            echo "<p>Table name is not defined for the given site ID.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    } finally {
        $db = null; // Close the database connection
    }
    ?>

    <?php include "footer.inc.php"; ?>
</body>
</html>
