<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "modx";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

// Map the old category values to the new category ids
$categoryMap = [
    "budget" => 1,
    "classic" => 2,
    "self" => 3,
    "extreme" => 4,
    "mice" => 5
];

$sql = "SELECT contentid, value FROM modx_site_tmplvar_contentvalues_full WHERE tmplvarid = 37";
$result = $conn->query($sql);

$counter = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $contentId = $row["contentid"];
        $categoryValue = $row["value"];

        $sqlContent = "SELECT id, pagetitle, content, alias, longtitle, description, introtext 
                       FROM modx_site_content 
                       WHERE id = $contentId AND context_key = 'web' AND id <> 9";

        $resultContent = $conn->query($sqlContent);

        if ($resultContent->num_rows > 0) {
            while ($rowContent = $resultContent->fetch_assoc()) {

                $categoryId = $categoryMap[$categoryValue];

                $sqlCategory = "SELECT name, id
                                FROM categories 
                                WHERE id = $categoryId";

                $resultCategory = $conn->query($sqlCategory);

                if ($resultCategory->num_rows > 0) {
                    while ($rowCategory = $resultCategory->fetch_assoc()) {
                        $categoryName = $rowCategory["name"];
                        $categoryId = $rowCategory["id"];
                        $counter++;

                        echo "***************************<br>";
                        echo "Content ID: " . $rowContent["id"] . "<br>";
                        echo "Tour pagetitle: " . $rowContent["pagetitle"] . "<br>";
                        echo "Context key: web<br>";
                        echo "Category ID: " . $categoryId . "<br>";
                        echo "Category: " . $categoryName . "<br>";
                        echo "Description: " . $rowContent["description"] . "<br>";
                        echo "Tour number: " . $counter . "<br>";
                        echo "***************************<br><br>";
                    }
                }
            }
        }
    }
}

$conn->close();

?>
