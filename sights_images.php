<?php

$mysqli = new mysqli("localhost", "root", "root", "modx");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$query = "SELECT id, content FROM sights";
$result = $mysqli->query($query);

$updateSQL = "";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $content = json_decode($row["content"], true);
        foreach ($content as $key => $item) {
            if (isset($item['images'][0]['path'])) {
                $imagePath = $mysqli->real_escape_string($item['images'][0]['path']);
                $updateSQL .= "UPDATE sights SET preview_image = '{$imagePath}' WHERE id = {$row['id']};\n";
                break;
            }
        }
    }
} else {
    echo "0 results";
}

if (!empty($updateSQL)) {
    file_put_contents('sights_images_update.sql', $updateSQL);
    echo "SQL file has been created.";
} else {
    echo "No updates needed.";
}

$mysqli->close();

?>
