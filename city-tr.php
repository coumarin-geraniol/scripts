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

$counter = 0;

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        $slug = $row["slug"];

        $sql = "SELECT id FROM modx_site_content WHERE alias = '$slug' AND context_key = 'web' AND id NOT IN (616, 590)";

        $result_id = $conn->query($sql);
        if ($result_id->num_rows > 0) {
            while ($row_id = $result_id->fetch_assoc()) {
                $contentid = $row_id["id"];

                $sql = "SELECT id, value, contentid FROM modx_site_tmplvar_contentvalues WHERE contentid = $contentid";
                $result_translation = $conn->query($sql);

                if ($result_translation->num_rows > 0) {
                    while ($row_translation = $result_translation->fetch_assoc()) {
                        $counter++;
                        echo "counter: " . $counter . "<br>";
                        echo "id: " . $row["id"] . "<br>";
                        echo "id: " . $row_translation["id"] . "<br>";
                        echo "contentid: " . $row_translation["contentid"] . "<br><br>";
                        $values = explode(";", $row_translation["value"]);
                        foreach ($values as $value) {
                            $translationid = explode(":", $value)[1];
                            if ($translationid != $contentid) {  // Исключаем web версию

                                $sql = "SELECT * FROM modx_site_content WHERE id = " . $translationid;
                                $result_final = $conn->query($sql);
                                if ($result_final->num_rows > 0) {
                                    while ($row_final = $result_final->fetch_assoc()) {
                                        echo "pagetitle: " . $row_final["pagetitle"] . "<br>";
                                        echo "contentid: " . $row_final["id"] . "<br>";
                                        echo "context_key: " . $row_final["context_key"] . "<br>" . "<br>";
                                    }
                                }
                            }

                        }
                    }
                } else {
                    echo "No translations found for city: " . $slug . "<br>";
                }

                echo " <br /> *************************** <br />  <br /> ";
            }
        } else {
            echo "No id found for city: " . $slug . "<br>";
        }
    }
} else {
    echo "No cities found";
}

$conn->close();
?>
