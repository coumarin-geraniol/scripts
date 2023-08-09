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

// Устанавливаем кодировку utf8
$conn->set_charset("utf8");

// Список ID историй городов
$historyIds = [169, 186, 192, 505, 341, 511, 516, 2204, 812, 816];
$idList = implode(',', $historyIds);

// Получаем все истории городов из старой таблицы modx_content
$sql = "SELECT id, pagetitle, alias FROM modx_site_content WHERE `id` IN ($idList)";
$result = $conn->query($sql);

$counter = 0;

if ($result->num_rows > 0) {
    // выводим данные каждой строки
    while ($row = $result->fetch_assoc()) {
        $counter++;

        // Выводим ID и название страницы
        echo "Record: " . $counter . "<br>";
        echo "ID: " . $row["id"] . "<br>";
        echo "Page title: " . $row["pagetitle"] . "<br><br>";

        // Ищем переводы
        $sql = "SELECT * FROM modx_site_tmplvar_contentvalues WHERE contentid = " . $row["id"];
        $result_translation = $conn->query($sql);

        // Если переводы найдены
        if ($result_translation->num_rows > 0) {
            while ($row_translation = $result_translation->fetch_assoc()) {
                $values = explode(";", $row_translation["value"]);

                // Для каждого значения выполняем поиск соответствующего контента
                foreach ($values as $value) {
                    $translationId = explode(":", $value)[1];

                    // Проверяем, не является ли перевод основным языком
                    if ($translationId != $row["id"]) {
                        $sql = "SELECT * FROM modx_site_content WHERE id = " . $translationId;
                        $result_final = $conn->query($sql);

                        if ($result_final->num_rows > 0) {
                            while ($row_final = $result_final->fetch_assoc()) {
                                echo "Translation Page Title: " . $row_final["pagetitle"] . "<br>";
                                echo "Translation ID: " . $row_final["id"] . "<br>";
                                echo "Translation context_key: " . $row_final["context_key"] . "<br><br>";
                            }
                        }
                    }
                }
                echo "<br>";
            }
        } else {
            echo "No translations found for city with ID: " . $row["id"] . "<br>";
        }

        echo " <br /> *************************** <br />  <br /> ";
    }
} else {
    echo "No history records found for given IDs";
}

$conn->close();

?>
