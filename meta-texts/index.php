<?php
// Параметры подключения к базе данных
$servername = "localhost";  // имя сервера
$username = "root";  // ваше имя пользователя для базы данных
$password = "mynewpassword";  // ваш пароль
$dbname = "modx";  // имя вашей базы данных

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL-запрос
$sql = "SELECT c.id AS content_id, c.pagetitle, c.uri, c.context_key 
        FROM modx_site_tmplvar_contentvalues AS t 
        JOIN modx_site_content AS c ON t.contentid = c.id 
        WHERE t.tmplvarid = 33 OR t.tmplvarid = 34";

// Выполнение запроса
$result = $conn->query($sql);

// Обработка результатов
if ($result->num_rows > 0) {
    // Вывод данных каждой строки
    while($row = $result->fetch_assoc()) {
        $domain_prefix = "";
        switch($row["context_key"]) {
            case 'web':
                $domain_prefix = "https://www.people-travels.com/";
                break;
            case 'de':
                $domain_prefix = "https://de.people-travels.com/";
                break;
            case 'ru':
                $domain_prefix = "https://ru.people-travels.com/";
                break;
            case 'it':
                $domain_prefix = "https://it.people-travels.com/";
                break;
            case 'fr':
                $domain_prefix = "https://fr.people-travels.com/";
                break;
            case 'es':
                $domain_prefix = "https://es.people-travels.com/";
                break;
            default:
                $domain_prefix = "https://www.people-travels.com/";
        }


        echo "Content ID: " . $row["content_id"]. " - Page Title: " . $row["pagetitle"]. " - URI: <a href='" . $domain_prefix . $row["uri"] . "'>" . $domain_prefix . $row["uri"] . "</a><br>";
    }
} else {
    echo "0 results";
}

// Закрытие соединения
$conn->close();
?>