<?php

$servername = "localhost";  // имя сервера
$username = "root";  // ваше имя пользователя для базы данных
$password = "root";  // ваш пароль
$dbname = "modx";  // имя вашей базы данных

// создаем соединение
$conn = new mysqli($servername, $username, $password, $dbname);

// проверяем соединение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получаем все города из новой таблицы
$sql = "SELECT id, slug FROM cities";
$result = $conn->query($sql);

// Массив для хранения данных для translations
$translations_data = [];

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        $slug = $row["slug"];

        $sql = "SELECT id, alias FROM modx_site_content WHERE alias = '$slug' AND context_key = 'web' AND id NOT IN (616, 590)";

        $result_id = $conn->query($sql);
        if ($result_id->num_rows > 0) {
            while ($row_id = $result_id->fetch_assoc()) {
                $contentid = $row_id["id"];

                $sql = "SELECT id, value FROM modx_site_tmplvar_contentvalues WHERE contentid = $contentid";
                $result_translation = $conn->query($sql);

                if ($result_translation->num_rows > 0) {
                    while ($row_translation = $result_translation->fetch_assoc()) {

                        $values = explode(";", $row_translation["value"]);
                        foreach ($values as $value) {
                            $translationid = explode(":", $value)[1];
                            if ($translationid != $contentid) {  // Исключаем web версию

                                $sql = "SELECT * FROM modx_site_content WHERE id = " . $translationid;
                                $result_final = $conn->query($sql);
                                if ($result_final->num_rows > 0) {
                                    while ($row_final = $result_final->fetch_assoc()) {

                                        $translations_data[] = [
                                            'locale' => $row_final["context_key"],
                                            'column_name' => 'slug',
                                            'value' => $row_final["alias"],
                                            'translatable_id' => $row["id"],
                                            'translatable_type' => 'App\Models\City',
                                        ];
                                    }
                                }
                            }

                        }
                    }
                }
            }
        }
    }
} else {
    echo "No cities found";
}

$conn->close();

// Создаем SQL файл
$file = fopen("city_slug_tr_insert.sql", "w");

foreach ($translations_data as $data) {
    $sql = "INSERT INTO translations (locale, column_name, value, translatable_id, translatable_type) VALUES ('" . $data['locale'] . "', '" . $data['column_name'] . "', '" . $data['value'] . "', " . $data['translatable_id'] . ", '" . $data['translatable_type'] . "');\n";
    fwrite($file, $sql);
}

fclose($file);

echo "SQL file created successfully";

?>
