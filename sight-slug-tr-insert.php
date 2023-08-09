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

$sql = "SELECT id, alias, pagetitle, content FROM modx_site_content WHERE parent IN (170, 187, 193, 506, 342, 512, 517, 725, 737, 806, 817, 3452, 3400, 3411, 728, 522) AND id <> 3424";
$result = $conn->query($sql);

$sqlInserts = [];
$translatableType = 'App\\Models\\Sight';
$columnName = 'title';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $slug = $row["alias"];
        $sql_new_id = "SELECT id FROM sights WHERE slug = '$slug'";
        $result_new_id = $conn->query($sql_new_id);
        $new_sight_id = $result_new_id->fetch_assoc()['id'];

        $sql = "SELECT id, value, contentid FROM modx_site_tmplvar_contentvalues WHERE contentid = " . $row["id"];
        $result_translation = $conn->query($sql);

        if ($result_translation->num_rows > 0) {
            while ($row_translation = $result_translation->fetch_assoc()) {
                $values = explode(";", $row_translation["value"]);

                foreach ($values as $value) {
                    $translationId = explode(":", $value)[1];
                    if ($translationId != $row["id"]) {
                        $sql = "SELECT * FROM modx_site_content WHERE id = " . $translationId;
                        $result_final = $conn->query($sql);

                        if ($result_final->num_rows > 0) {
                            while ($row_final = $result_final->fetch_assoc()) {
                                $locale = $row_final["context_key"];
                                $value = addslashes($row_final["pagetitle"]);
                                $translatableId = $new_sight_id;

                                $sqlInserts[] = "('{$locale}', '{$columnName}', '{$value}', {$translatableId}, '{$translatableType}')";
                            }
                        }
                    }
                }
            }
        }
    }
}

$insertValues = implode(",\n", $sqlInserts);

$sqlInsert = <<<SQL
INSERT INTO translations (locale, column_name, value, translatable_id, translatable_type) VALUES
{$insertValues};
SQL;

file_put_contents('sight_title_tr_insert.sql', $sqlInsert);

$conn->close();
?>
