<?php
// Параметры подключения к базе данных
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "modx";

// Создаем подключение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем подключение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Запрос для извлечения данных из таблицы modx_site_content
$query_1 = "
    SELECT id, context_key, parent, isfolder
    FROM modx_site_content
    WHERE parent = 124 AND context_key LIKE 'web' AND id NOT IN (133, 135, 146, 149, 564, 2711, 3149);
";

// Выполняем первый запрос
$result_1 = $conn->query($query_1);
$pages_uzbekistan_english_ids = [];

echo "Pages Uzbekistan in English:<br>";
while($row = $result_1->fetch_assoc()) {
    $pages_uzbekistan_english_ids[] = $row['id'];
    echo "id: " . $row['id']. " - context_key: " . $row['context_key']. " - parent: " . $row['parent']. " - isfolder: " . $row['isfolder'] . "<br>";
}

// Запрос для извлечения дочерних элементов, где isfolder=1
$query_2 = "
    SELECT id, context_key, parent, isfolder
    FROM modx_site_content
    WHERE parent IN (" . implode(',', $pages_uzbekistan_english_ids) . ") AND isfolder = 1;
";

// Выполняем второй запрос
$result_2 = $conn->query($query_2);
$child_pages_ids = [];

echo "<br>Child Pages:<br>";
while($row = $result_2->fetch_assoc()) {
    $child_pages_ids[] = $row['id'];
    echo "id: " . $row['id']. " - context_key: " . $row['context_key']. " - parent: " . $row['parent']. " - isfolder: " . $row['isfolder'] . "<br>";
}

// Запрос для извлечения переводов из таблицы modx_site_tmplvar_contentvalues
$query_3 = "
    SELECT contentid, value
    FROM modx_site_tmplvar_contentvalues
    WHERE tmplvarid = 25 AND contentid IN (" . implode(',', array_merge($pages_uzbekistan_english_ids, $child_pages_ids)) . ");
";

// Выполняем третий запрос
$result_3 = $conn->query($query_3);

echo "<br>Translations:<br>";
while($row = $result_3->fetch_assoc()) {
    echo "contentid: " . $row['contentid']. " - value: " . $row['value'] . "<br>";
}

// Закрываем подключение
$conn->close();
?>
