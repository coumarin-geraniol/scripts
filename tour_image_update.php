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

// Создаем файл SQL для записи в него запросов UPDATE
$sql_file = fopen("update_queries.sql", "w");

// Выполняем запрос к таблице modx_site_tmplvar_contentvalues_full, где tmplvarid = 35 (код поля tour_image)
$sql = "SELECT contentid, value FROM modx_site_tmplvar_contentvalues_full WHERE tmplvarid = 35";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Формируем запросы UPDATE и записываем их в файл SQL
    while ($row = $result->fetch_assoc()) {
        $content_id = $row["contentid"];
        $image_url = $row["value"];

        // Получаем alias из таблицы modx_site_content по contentid
        $sql_alias = "SELECT alias FROM modx_site_content WHERE context_key = 'web' and id = $content_id";
        $result_alias = $conn->query($sql_alias);

        if ($result_alias->num_rows > 0) {
            $row_alias = $result_alias->fetch_assoc();
            $alias = $row_alias["alias"];

            // Формируем SQL-запрос UPDATE для обновления preview_image в таблице tours
            $update_sql = "UPDATE tours SET preview_image = '$image_url' WHERE slug = '$alias';";

            // Записываем запрос UPDATE в файл SQL
            fwrite($sql_file, $update_sql . "\n");
        }
    }
} else {
    echo "Нет данных о турах и изображениях.";
}

fclose($sql_file);

$conn->close();

echo "Файл update_queries.sql успешно создан. Откройте его и выполните содержащиеся в нем запросы UPDATE в вашей базе данных.";

