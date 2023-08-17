<?php
// Параметры подключения к базе данных
$servername = "localhost";
$username = "root";
$password = "mynewpassword";
$dbname = "modx";

// Создаем подключение
$conn = new mysqli($servername, $username, $password, $dbname);
// Открываем файл для записи SQL запросов
$file = fopen("migrate_data.sql", "w");

// Проверяем подключение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function fetch_and_print_translations($conn, $contentid) {
    $query_translations = "
        SELECT value
        FROM modx_site_tmplvar_contentvalues
        WHERE tmplvarid = 25 AND contentid = $contentid;
    ";
    $result_translations = $conn->query($query_translations);

    while ($translation = $result_translations->fetch_assoc()) {
        $pairs = explode(';', $translation['value']);
        foreach ($pairs as $pair) {
            list($locale, $translated_id) = explode(':', $pair);
            echo "&nbsp;&nbsp;&nbsp;&nbsp;Translation - id: $translated_id - Language: $locale" . ", ";
        }
        echo "<br>";
    }
}

// Запрос для извлечения Main Pages
$query_main_pages = "
    SELECT id, context_key, parent, isfolder
    FROM modx_site_content
    WHERE parent = 124 AND context_key LIKE 'web' AND isfolder = 1
    AND id NOT IN (133, 135, 146, 149, 564, 2711, 3149, 564);
";
$result_main_pages = $conn->query($query_main_pages);

echo "Main Pages:<br>";
while($main_page = $result_main_pages->fetch_assoc()) {
    echo "id: " . $main_page['id']. " - parent: " . $main_page['parent']. " - isfolder: " . $main_page['isfolder'] . "&nbsp;&nbsp;&nbsp;&nbsp;------>";
    fetch_and_print_translations($conn, $main_page['id']);
    // Запрос для извлечения Sub Pages для текущей Main Page
    $query_sub_pages = "
        SELECT id, context_key, parent, isfolder
        FROM modx_site_content
        WHERE parent = " . $main_page['id'] . " AND isfolder = 0;
    ";
    $result_sub_pages = $conn->query($query_sub_pages);

    echo "&nbsp;&nbsp;Sub Pages:<br>";
    while($sub_page = $result_sub_pages->fetch_assoc()) {
        echo "&nbsp;&nbsp;id: " . $sub_page['id']. " - parent: " . $sub_page['parent']. " - isfolder: " . $sub_page['isfolder'] . "&nbsp;&nbsp;&nbsp;&nbsp;------>";
        fetch_and_print_translations($conn, $sub_page['id']);
    }

    echo "<br>";
}
echo "<br>";
echo "<br>";
// Запрос для извлечения Single Pages
$query_single_pages = "
    SELECT id, context_key, parent, isfolder
    FROM modx_site_content
    WHERE parent = 124 AND isfolder = 0 AND context_key LIKE 'web' AND id NOT IN (133, 135, 146, 149, 564, 2711, 3149, 564);
";
$result_single_pages = $conn->query($query_single_pages);

echo "<br>Single Pages:<br>";
while($single_page = $result_single_pages->fetch_assoc()) {
    echo "id: " . $single_page['id']. " - parent: " . $single_page['parent']. " - isfolder: " . $single_page['isfolder'] . "&nbsp;&nbsp;&nbsp;&nbsp;------>";
    fetch_and_print_translations($conn, $single_page['id']);
}

// Закрываем подключение
$conn->close();
?>
