<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "modx";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$conn->set_charset("utf8");

$sql = "SELECT contentid, value FROM modx_site_tmplvar_contentvalues_full WHERE tmplvarid = 31 and contentid <> 11";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $contentId = $row["contentid"];
        $html = $row["value"];

        // Получаем название тура
        $sqlTour = "SELECT pagetitle FROM modx_site_content WHERE id = $contentId ";
        $resultTour = $conn->query($sqlTour);
        $tourTitle = ($resultTour->num_rows > 0) ? $resultTour->fetch_assoc()["pagetitle"] : "";

        // Получаем минимальную цену
        $sqlMinPrice = "SELECT value FROM modx_site_tmplvar_contentvalues_full WHERE tmplvarid = 24 AND contentid = $contentId";
        $resultMinPrice = $conn->query($sqlMinPrice);
        $minPrice = ($resultMinPrice->num_rows > 0) ? $resultMinPrice->fetch_assoc()["value"] : "";

        // Разбираем HTML чтобы получить цены и количество людей
        $dom = new DOMDocument();
        $dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        $prices = [];
        $priceRows = $xpath->query("//table[1]/tbody/tr[position()>1]");
        foreach ($priceRows as $priceRow) {
            $pax = trim($xpath->query("td[1]", $priceRow)->item(0)->nodeValue);
            $price = trim($xpath->query("td[2]", $priceRow)->item(0)->nodeValue);

            if ($price === "[[*pfrom]]") {
                $price = $minPrice;
            }

            $prices[$pax] = $price;
        }

        // Отображаем цены и количество людей для тура
        echo "Тур: $tourTitle, ID контента: $contentId<br>";
        foreach ($prices as $pax => $price) {
            echo "Цена: $price, Количество человек: $pax<br>";
        }
        echo "<br>";
    }
}

$conn->close();

?>
