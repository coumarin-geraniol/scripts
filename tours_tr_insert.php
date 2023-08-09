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

$columns = ['title' => 'pagetitle', 'slug' => 'alias', 'seo_title' => 'longtitle', 'seo_descr' => 'description', 'meta_keywords' => 'introtext'];

$sqlFile = fopen("tours_tr_insert.sql", "w") or die("Unable to open file!");

if ($resultTours->num_rows > 0) {
    while($rowTours = $resultTours->fetch_assoc()) {
        $slug = $rowTours['slug'];
        $queryModx = "SELECT id, alias, pagetitle, longtitle, description, introtext FROM modx_site_content WHERE alias = '$slug'";
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
                            $queryLanguage = "SELECT context_key, pagetitle, longtitle, description, introtext, alias, id FROM modx_site_content WHERE id = '$translateId' and id not in (4152, 21)";
                            $resultLanguage = $conn->query($queryLanguage);

                            if ($resultLanguage->num_rows > 0) {
                                while($rowLanguage = $resultLanguage->fetch_assoc()) {
                                    $locale = $rowLanguage['context_key'] == 'web' ? 'en' : $rowLanguage['context_key'];

                                    echo 'ID: ' . $contentId . '<br>';
                                    echo 'Content ID: ' . $rowLanguage['id'] . '<br>';
                                    echo 'Alias: ' . $rowLanguage['alias'] . '<br>' ;
                                    echo 'pagetitle: ' . $rowLanguage['pagetitle'] . '<br>' ;
                                    echo ' Tour ID: ' . $rowTours['id']  . '<br>';
                                    echo ' Language: ' . $locale . '<br>' ;
                                    echo '<br>';

                                    foreach ($columns as $column_name => $modx_field) {
                                        $value = $conn->real_escape_string($rowLanguage[$modx_field]);
                                        $sql = "INSERT INTO translations (locale, column_name, value, translatable_id, translatable_type) VALUES ('".$locale."', '".$column_name."', '".$value."', '".$rowTours['id']."', 'App\\Models\\Tour');".PHP_EOL;
                                        fwrite($sqlFile, $sql);
                                    }
                                }
                            }
                        } echo '**************************'  . '<br>';
                    }
                }
            }
        }
    }
}
$conn->close();
fclose($sqlFile);

?>
