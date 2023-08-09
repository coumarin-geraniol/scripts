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

// Выполняем запрос к таблице modx_site_tmplvar_contentvalues_full, где tmplvarid = 35 (код поля tour_image)
$sql = "SELECT contentid, value FROM modx_site_tmplvar_contentvalues_full WHERE tmplvarid = 35";
$result = $conn->query($sql);

$counter=0;

if ($result->num_rows > 0) {
    // Выводим информацию о турах и их изображениях
    while ($row = $result->fetch_assoc()) {
        $content_id = $row["contentid"];
        $image_url = $row["value"];

        // Получаем alias из таблицы modx_site_content по contentid
        $sql_alias = "SELECT alias FROM modx_site_content WHERE context_key = 'web' and id = $content_id";
        $result_alias = $conn->query($sql_alias);

        if ($result_alias->num_rows > 0) {
            $row_alias = $result_alias->fetch_assoc();
            $alias = $row_alias["alias"];

            // Получаем tours_id из таблицы tours по slug (предполагая, что slug в новой таблице соответствует alias в таблице modx_site_content)
            $sql_tours_id = "SELECT id FROM tours WHERE slug = '$alias'";
            $result_tours_id = $conn->query($sql_tours_id);

            if ($result_tours_id->num_rows > 0) {
                $row_tours_id = $result_tours_id->fetch_assoc();
                $tours_id = $row_tours_id["id"];

                $counter++;
                // Выводим информацию о каждом туре (content_id), его изображении (value), алиасе и tours_id
                echo "Counter: " . $counter . "<br>";
                echo "Content ID тура: " . $content_id . "<br>";
                echo "Tours ID тура: " . $tours_id . "<br>";
                echo "URL изображения тура: " . $image_url . "<br>";
                echo "Алиас тура: " . $alias . "<br>";
                echo "--------------------------------<br>";
            }
        }
    }
} else {
    echo "Нет данных о турах и изображениях.";
}

$conn->close();

