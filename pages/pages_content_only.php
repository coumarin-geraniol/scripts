<?php
// Параметры подключения к базе данных
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "modx_2";

// Создаем подключение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем подключение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Открываем файл для записи SQL запросов
$file = fopen("pages_content_only.txt", "w");

// Счетчик для генерации новых id для строк в таблице pages
$id_counter = 1;

// Функция для генерации SQL запросов
function generate_insert_sql($conn, $contentid, $newid, $parentid = "NULL") {
    $query_content = "
        SELECT pagetitle, content, alias, longtitle, description, introtext
        FROM modx_site_content
        WHERE id = $contentid;
    ";
    $result_content = $conn->query($query_content);
    $row = $result_content->fetch_assoc();

    $sql = "{{" . addslashes($row['content']) . "}}";

    return $sql;
}

// Функция для генерации SQL запросов для таблицы translations
function generate_translation_sql($conn, $contentid, $newid, $locale, $column_name, $value) {
//    $sql = "INSERT INTO translations (locale, column_name, value, translatable_id, translatable_type) VALUES ";
//    $sql .= "('$locale', '$column_name', ";
//    $sql .= "'" . addslashes($value) . "', ";
    $sql = "\n";
    return $sql;
}

function save_translations($conn, $file, $contentid, $newid) {
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
            $locale = ($locale === 'web') ? 'en' : $locale;


            $query_content = "SELECT pagetitle, content, alias, longtitle, description, introtext FROM modx_site_content WHERE id = $translated_id;";
            $result_content = $conn->query($query_content);
            $row = $result_content->fetch_assoc();

            fwrite($file, generate_translation_sql($conn, $translated_id, $newid, $locale, 'content', $row['content']));
        }
        fwrite($file,"\n");
    }
}

// Генерируем SQL запросы для Main Pages и их Sub Pages
$query_main_pages = "
    SELECT id
    FROM modx_site_content
    WHERE parent = 124 AND context_key LIKE 'web' AND isfolder = 1
    AND id NOT IN (133, 135, 146, 149, 564, 2711, 3149, 564);
";
$result_main_pages = $conn->query($query_main_pages);

while($main_page = $result_main_pages->fetch_assoc()) {

    $sql_main = generate_insert_sql($conn, $main_page['id'], $id_counter);
    fwrite($file, $sql_main);
    $parent = $id_counter;
    save_translations($conn, $file, $main_page['id'], $id_counter);

    // Запрос для извлечения Sub Pages для текущей Main Page
    $query_sub_pages = "
        SELECT id
        FROM modx_site_content
        WHERE parent = " . $main_page['id'] . " AND isfolder = 0;
    ";
    $result_sub_pages = $conn->query($query_sub_pages);

    while($sub_page = $result_sub_pages->fetch_assoc()) {
        $id_counter++;
        $sql_sub = generate_insert_sql($conn, $sub_page['id'], $id_counter, $parent);
        fwrite($file, $sql_sub);
        save_translations($conn, $file, $sub_page['id'], $id_counter);
    }

    $id_counter++;
}

// Генерируем SQL запросы для Single Pages
$query_single_pages = "
    SELECT id
    FROM modx_site_content
    WHERE parent = 124 AND isfolder = 0 AND context_key LIKE 'web' AND id NOT IN (133, 135, 146, 149, 564, 2711, 3149, 564);
";
$result_single_pages = $conn->query($query_single_pages);

while($single_page = $result_single_pages->fetch_assoc()) {
    $sql_single = generate_insert_sql($conn, $single_page['id'], $id_counter);
    fwrite($file, $sql_single);
    save_translations($conn, $file, $single_page['id'], $id_counter);

    $id_counter++;
}

// Закрываем файл и подключение к базе данных
fclose($file);
$conn->close();

echo "SQL queries have been generated and saved to migrate_data.sql";
?>
