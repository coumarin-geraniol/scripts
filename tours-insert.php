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

$dataEntries = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $contentId = $row["contentid"];
        $categoryValue = $row["value"];

        $sqlContent = "SELECT pagetitle, alias, longtitle, description, introtext 
                       FROM modx_site_content 
                       WHERE id = $contentId AND context_key = 'web'";

        $resultContent = $conn->query($sqlContent);

        if ($resultContent->num_rows > 0) {
            while ($rowContent = $resultContent->fetch_assoc()) {
                $categoryId = $categoryMap[$categoryValue];

                $name = $conn->real_escape_string($rowContent["pagetitle"]);
                $slug = $conn->real_escape_string($rowContent["alias"]);
                $seoTitle = $conn->real_escape_string($rowContent["longtitle"]);
                $seoDescr = $conn->real_escape_string($rowContent["description"]);
                $metaKeywords = $conn->real_escape_string($rowContent["introtext"]);
                $countryId = 1;
                $now = date('Y-m-d H:i:s');

                $dataEntries[] = "('$name', '$slug', '$seoTitle', '$seoDescr', '$metaKeywords', $categoryId, $countryId, '$now', '$now')";
            }
        }
    }
}

$conn->close();

$insertQuery = "INSERT INTO tours 
                 (name,  slug, seo_title, seo_descr, meta_keywords, category_id, country_id, created_at, updated_at) 
                 VALUES \n" . implode(",\n", $dataEntries) . ";\n";

$file = fopen("tours_insert.sql", "w");

fwrite($file, $insertQuery);

fclose($file);

echo "SQL file created successfully";

?>
