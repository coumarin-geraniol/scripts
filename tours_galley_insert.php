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

// Создаем файл SQL для записи в него запросов INSERT
$sql_file = fopen("tours_galley_insert..sql", "w");

// Получаем id и preview_image из таблицы tours
$sql_tours = "SELECT id, preview_image FROM tours";
$result_tours = $conn->query($sql_tours);

if ($result_tours->num_rows > 0) {
    // Формируем запросы INSERT и записываем их в файл SQL
    while ($row_tours = $result_tours->fetch_assoc()) {
        $tour_id = $row_tours["id"];
        $preview_image = $row_tours["preview_image"];

        // Формируем SQL-запрос INSERT для добавления записи в таблицу galleries
        $insert_sql = "INSERT INTO galleries (tour_id, path) VALUES ($tour_id, '$preview_image');";

        // Записываем запрос INSERT в файл SQL
        fwrite($sql_file, $insert_sql . "\n");
    }
} else {
    echo "Нет данных о турах.";
}

fclose($sql_file);

$conn->close();

echo "Файл insert_queries.sql успешно создан. Откройте его и выполните содержащиеся в нем запросы INSERT в вашей базе данных.";

