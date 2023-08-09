<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "modx";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get all sights from modx_site_content
$sql = "SELECT id, pagetitle, alias FROM modx_site_content WHERE parent IN (170, 187, 193, 506, 342, 512, 517, 725, 737, 806, 817, 3452, 3400, 3411, 728, 522) AND id <> 3424";
$result = $conn->query($sql);

$counter = 0;

if ($result->num_rows > 0) {

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $sightId = $row["id"];
        $slug = $row["alias"];

        // Get new sight id from the new database
        $sql_new_id = "SELECT id FROM sights WHERE slug = '$slug'";
        $result_new_id = $conn->query($sql_new_id);
        $new_sight_id = $result_new_id->fetch_assoc()['id'];

        //Get translations from modx_site_tmplvar_contentvalues
        $sql = "SELECT id, value, contentid FROM modx_site_tmplvar_contentvalues WHERE contentid = $sightId";
        $result_translation = $conn->query($sql);

        if ($result_translation->num_rows > 0) {
            while ($row_translation = $result_translation->fetch_assoc()) {
                $counter++;
                echo "counter: " . $counter . "<br>";
                echo "old sight id: " . $sightId . "<br>";
                echo "new sight id: " . $new_sight_id . "<br>";
                echo "translation id: " . $row_translation["id"] . "<br>";
                echo "contentid: " . $row_translation["contentid"] . "<br><br>";
                $values = explode(";", $row_translation["value"]);
                foreach ($values as $value) {
                    $translationid = explode(":", $value)[1];

                        //Get final translations from modx_site_content
                        $sql = "SELECT * FROM modx_site_content WHERE id = " . $translationid;
                        $result_final = $conn->query($sql);
                        if ($result_final->num_rows > 0) {
                            while ($row_final = $result_final->fetch_assoc()) {
                                echo "pagetitle: " . $row_final["pagetitle"] . "<br>";
                                echo "contentid: " . $row_final["id"] . "<br>";
                                echo "context_key: " . $row_final["context_key"] . "<br>" . "<br>";
                            }
                        }
                    
                }
            }
        } else {
            echo "No translations found for sight id: " . $sightId . "<br>";
        }

        echo " <br /> *************************** <br />  <br /> ";
    }
} else {
    echo "No sights found";
}

$conn->close();
?>
