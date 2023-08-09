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

$historyIds = [169, 186, 192, 505, 341, 511, 516, 2204, 812, 816];
$idList = implode(',', $historyIds);

$sql = "SELECT id, pagetitle, alias, content FROM modx_site_content WHERE `id` IN ($idList)";
$result = $conn->query($sql);

$sqlInserts = [];
$translatableType = 'App\\Models\\City';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sql = "SELECT * FROM modx_site_tmplvar_contentvalues WHERE contentid = " . $row["id"];
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
                                $value = addslashes($row_final["content"]);  // Экранируем кавычки
                                $columnName = 'value_json';
                                $translatableId = $row_final["id"];

                                $sqlInserts[] = "('{$locale}', '{$columnName}', NULL, '{$value}', {$translatableId}, '{$translatableType}')";
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
INSERT INTO translations (locale, column_name, value, value_json, translatable_id, translatable_type) VALUES
{$insertValues};
SQL;

// Записываем SQL в файл
file_put_contents('city_history_tr_insert.sql', $sqlInsert);

$conn->close();
?>
