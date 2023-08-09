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

        $sqlContent = "SELECT id, pagetitle, content, alias, longtitle, introtext 
                       FROM modx_site_content 
                       WHERE id = $contentId AND context_key = 'web' AND id <> 9";

        $resultContent = $conn->query($sqlContent);

        if ($resultContent->num_rows > 0) {
            while ($rowContent = $resultContent->fetch_assoc()) {

                $categoryId = $categoryMap[$categoryValue];

                $sqlCategory = "SELECT name 
                                FROM categories 
                                WHERE id = $categoryId";

                $resultCategory = $conn->query($sqlCategory);

                $categoryName = ($resultCategory->num_rows > 0) ? $resultCategory->fetch_assoc()["name"] : "";

                $sqlDuration = "SELECT value
                                FROM modx_site_tmplvar_contentvalues_full
                                WHERE contentid = $contentId AND tmplvarid = 29";

                $resultDuration = $conn->query($sqlDuration);
                $duration = ($resultDuration->num_rows > 0) ? $resultDuration->fetch_assoc()["value"] : null;
                list($days, $nights) = $duration ? explode("/", str_replace([" days ", " nights"], "", $duration)) : [null, null];

                // Fetching the description of the tour
                $sqlDescription1 = "SELECT value
                                    FROM modx_site_tmplvar_contentvalues_full
                                    WHERE contentid = $contentId AND tmplvarid = 33";

                $sqlDescription2 = "SELECT value
                                    FROM modx_site_tmplvar_contentvalues_full
                                    WHERE contentid = $contentId AND tmplvarid = 34";

                $resultDescription1 = $conn->query($sqlDescription1);
                $resultDescription2 = $conn->query($sqlDescription2);

                $description1 = ($resultDescription1->num_rows > 0) ? $resultDescription1->fetch_assoc()["value"] : "";
                $description2 = ($resultDescription2->num_rows > 0) ? $resultDescription2->fetch_assoc()["value"] : "";

                $description1 = strip_tags($description1);
                $description2 = strip_tags($description2);

                $description = $description1 . ' ' . $description2;



                $sqlIncluded = "SELECT value FROM modx_site_tmplvar_contentvalues_full WHERE tmplvarid = 32 AND contentid = $contentId";
                $resultIncluded = $conn->query($sqlIncluded);

                $sqlExcluded = "SELECT value FROM modx_site_tmplvar_contentvalues_full WHERE tmplvarid = 36 AND contentid = $contentId";
                $resultExcluded = $conn->query($sqlExcluded);

                $included = ($resultIncluded->num_rows > 0) ? $resultIncluded->fetch_assoc()["value"] : "";
                $excluded = ($resultExcluded->num_rows > 0) ? $resultExcluded->fetch_assoc()["value"] : "";

                $included = preg_replace('/<li[^>]*>/', '', $included, 1); // Replace first occurrence with empty string
                $included = preg_replace('/<li[^>]*>/', ', ', $included);  // Replace the rest with comma
                $included = strip_tags($included);

                $excluded = preg_replace('/<li[^>]*>/', '', $excluded, 1); // Replace first occurrence with empty string
                $excluded = preg_replace('/<li[^>]*>/', ', ', $excluded);  // Replace the rest with comma
                $excluded = strip_tags($excluded);





                $counter++;

                echo "***************************<br>";
                echo "Content ID: " . $rowContent["id"] . "<br>";
                echo "Tour pagetitle: " . $rowContent["pagetitle"] . "<br>";
                echo "Context key: web<br>";
                echo "Category: " . $categoryName . "<br>";
                echo "Description: " . $description . "<br>";
                echo "Days: " . $days . "<br>";
                echo "Nights: " . $nights . "<br>";
                echo "Include in cost: " . $included . "<br>";
                echo "Not in include in cost: " . $excluded . "<br>";
                echo "Tour number: " . $counter . "<br>";
                echo "***************************<br><br>";
            }
        }
    }
}

$conn->close();

?>
