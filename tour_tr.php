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

$queryTours = "SELECT * FROM tours";
$resultTours = $conn->query($queryTours);

if ($resultTours->num_rows > 0) {
    while($rowTours = $resultTours->fetch_assoc()) {
        $slug = $rowTours['slug'];
        $queryModx = "SELECT id, alias FROM modx_site_content WHERE alias = '$slug'";
        $resultModx = $conn->query($queryModx);

        if ($resultModx->num_rows > 0) {
            while($rowModx = $resultModx->fetch_assoc()) {
                $contentId = $rowModx['id'];
                $queryTranslate = "SELECT value FROM modx_site_tmplvar_contentvalues WHERE contentid = '$contentId' AND tmplvarid = 25";
                $resultTranslate = $conn->query($queryTranslate);

                if ($resultTranslate->num_rows > 0) {
                    while($rowTranslate = $resultTranslate->fetch_assoc()) {
                        $translations = explode(';', $rowTranslate['value']);

                        foreach($translations as $translation) {
                            $translateData = explode(':', $translation);
                            $translateId = $translateData[1];
                            $queryLanguage = "SELECT pagetitle, context_key, alias, id FROM modx_site_content WHERE id = '$translateId' and id not in (4152, 21)";
                            $resultLanguage = $conn->query($queryLanguage);
                            if ($resultLanguage->num_rows > 0) {
                                while($rowLanguage = $resultLanguage->fetch_assoc()) {
                                    echo 'ID: ' . $contentId . '<br>';
                                    echo 'Content ID: ' . $rowLanguage['id'] . '<br>';
                                    echo 'Alias: ' . $rowLanguage['alias'] . '<br>' ;
                                    echo 'pagetitle: ' . $rowLanguage['pagetitle'] . '<br>' ;
                                    echo ' Tour ID: ' . $rowTours['id']  . '<br>';
                                    echo ' Language: ' . $rowLanguage['context_key'] . '<br>' ;
                                    echo '<br>';


                                }
                            }
                        }
                        echo '**************************'  . '<br>';

                    }
                }
            }
        }
    }
}
$conn->close();
?>
