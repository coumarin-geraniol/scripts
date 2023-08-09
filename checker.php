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

$sql = "SELECT id, alias, content FROM modx_site_content WHERE parent IN (170, 187, 193, 506, 342, 512, 517, 725, 737, 806, 817, 3452, 3400, 3411, 728, 522) AND id <> 3424";
$result = $conn->query($sql);

$inconsistencies = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sql = "SELECT id, value, contentid FROM modx_site_tmplvar_contentvalues WHERE contentid = " . $row["id"];
        $result_translation = $conn->query($sql);

        if ($result_translation->num_rows > 0) {
            while ($row_translation = $result_translation->fetch_assoc()) {
                $values = explode(";", $row_translation["value"]);

                foreach ($values as $value) {
                    $translationData = explode(":", $value);
                    $contextKey = $translationData[0];
                    $translationId = $translationData[1];

                    if ($contextKey == 'web' && $translationId != $row["id"]) {
                        $inconsistencies[] = [
                            'sight_id' => $row["id"] . " ",
                            'alias' => $row["alias"] . " ",
                            'translation_id' => $translationId . " " . " "
                        ];
                    }
                }
            }
        }
    }
}

print_r($inconsistencies);

$conn->close();
?>


<h2>Tour price per person in USD</h2>
<table class="table tour-table">
    <tbody>
    <tr>
        <th style="width:50%;">FIT</th>
        <th>Tour price per pax in $</th>
    </tr>
    <tr>
        <td><strong>2 pax</strong></td>
        <td>1175</td>
    </tr>
    <tr>
        <td><strong>3 - 4 pax</strong></td>
        <td>1038</td>
    </tr>
    <tr>
        <td><strong>5 - 6 pax</strong></td>
        <td>941</td>
    </tr>
    <tr>
        <td><strong>7 - 8 pax</strong></td>
        <td>[[*pfrom]]</td>
    </tr>
    </tbody>
</table>

<p>&nbsp;</p>

<table class="table tour-table">
    <tbody>
    <tr>
        <th style="width:50%;">Cities</th>
        <th>Hotels or similars</th>
    </tr>
    <tr>
        <td><strong>Tashkent</strong></td>
        <td>Le Grande Plaza 4*</td>
    </tr>
    <tr>
        <td><strong>Khiva</strong></td>
        <td>Old Khiva 3*</td>
    </tr>
    <tr>
        <td><strong>Bukhara</strong></td>
        <td>Fatima 3*</td>
    </tr>
    <tr>
        <td><strong>Nurata</strong></td>
        <td>Yurt Camp</td>
    </tr>
    <tr>
        <td><strong>Samarkand</strong></td>
        <td>City 3*</td>
    </tr>
    <tr>
        <td><strong>Ferghana </strong></td>
        <td>Club Hotel 777 3*</td>
    </tr>
    </tbody>
</table>


<ul>
    <li>Double accommodation</li>
    <li>4-6 pax accommodation in yurt camp with full board.</li>
    <li>Breakfast only</li>
    <li>Transport service all over tour by a/c vehicle</li>
    <li>English, German, Italian, French, Spanish speaking local guides in each city</li>
    <li>From 7 persons escort guide provided</li>
    <li>Visa Support.</li>
</ul>


<p>It is believed that shurpa soup came back in the first century BC, when the East began to use clay and stone utensils
    for cooking. Shurpa has a lot of varieties. There is also a view that the cooking of shurpa applies only to a
    sedentary lifestyle. The Arabs were nomads for a long time, and they called this word any thin soup. The word
     "shurpa " comes from the Arabic word  "soup " and means rich soup with large chunks of meat, potatoes, and carrots.
    There are also other words for shurpa - Central Asian lamb, beef and vegetables soup. They are shurva, shorva.</p>
 <p>There is also a version that the name of this soup is not Turkic, but Persian -  "Shurpov ", which means salty or
    acidic water. Now in Uzbekistan shurpa is acidified with tomatoes, but a few centuries ago plum and other sweet and
    sour berries were used to do this.</p> <p>Despite the rather simple Uzbek shurpa recipe and affordable
    ingredients, the dish turns out very distinctive, delicious and hearty.</p> <p>According to some reports, the
    delicious soup shurpa was the favorite dish of the great medieval conqueror Tamerlane. You can meet mentions that
    shurpa was prepared for the famous conqueror Genghis
    Khan.</p>
<p>Uzbek shurpa, is, definitely, the flagship of Uzbek cookery!</p> <p>Uzbek lamb soup is brewed and sold almost
    around the clock in every little teahouse or at the best VIP-restaurant!</p> <p>If you like, shurpa soup is a
    weighty part of the culture and the real everyday life of Central Asian peoples, and oldest food on the earth!</p>
 <p>Uzbek shurpa is a rich, thick soup, which is considered one of the crown first dishes in <a class= "external "
                                                                                                   href= "about-uzbekistan/uzbek-cuisine/ "
                                                                                                   title= "Uzbek
                                                                                                   cuisine ">Uzbek
    cuisine</a>.</p> <p>Uzbek soup shurpa - famous dish of Uzbek cuisine, without which any one meal and even a
    wedding can do. In some regions of Uzbekistan a wedding feast begins from Uzbek wedding shurpa.</p> <p>We can
    identify some indications of traditional Uzbek soup shurpa. Firstly, it is characterized by a high fat content that,
    in particular, is especially noticeable during the cooking shurpa from the pre roasted meat and vegetables.
    Secondly, for shurpa the use of a large number of herbs and spices is characterized. Thirdly, at a relatively
    constant set of coarsely chopped vegetables, namely, carrots, potatoes and onions in Uzbek shurpa various fruits -
    apples, apricots (dried apricots), quince, plum may be used (even welcome) in considerable quantities.</p> <p>As
    a rule, Uzbek shurpa soup is cooked from lamb, but it can be made from poultry, including small and wild.</p> <p>
    Herbs and spices vary from region to region, but almost everywhere Uzbek shurpa recipe includes parsley, dill,
    cilantro (kinza), red pepper and basil in large quantities.</p> <p>In Uzbekistan shurpa is very peculiarly made
    and served. Here it is not just soup, but also the second dish.</p> <p>The main difference of shurpa lamb in
    Uzbek from all other soups is special ritual of cooking. Shurpa is cooked in large quantities and in a pressure
    container. It is very important to achieve languor broth regime without traces of boiling. It is very problematic to
    do it in a small saucepan with thin walls and bottom. Therefore, in Uzbekistan shurpa is cooked in a cauldron. Uzbek
    shurpa turns out especially tasty on a live fire in the
    wood.</p><p>The great oriental scientist and healer Abu Ali Ibn Sina, who lived in the X-XI centuries mentioned shurpa in the
    Canon of Medicine. He recommended shurpa as a treatment dish that can quickly recover from illness.</p> <p>The
    main feature of this nourishing and delicious Uzbek shurpa is rich and extremely useful broth. In the spring it is
    added with shoots grapes; in the summer - green apples; in the autumn – turnips. And if instead of potatoes you put
    quince, you will get an easy and very fragrant soup with unforgettable pleasant taste.</p> <p>Avicenna said that
    shurpa is a cure for many diseases. And even now any self-respecting Uzbek treats colds with shurpa. Anemia,
    rheumatism, inflammation of the lungs, tuberculosis can be healed with very fat and hot Uzbek lamb shurpa. While the
    ulcer the lean beef shurpa on herbs could be helpful. Postoperative patients are recommended sparsely shurpa with
    mashed
    vegetables.</p><p>So, if you are willing to join the national cuisine of Uzbekistan, and even become the proud owner of a cast-iron
    cauldron, we try to tell what delicious Uzbek shurpa is. As the population of Uzbekistan is not small, there are
    many recipes of cooking shurpa - the most revered dish in the East.</p> <p>However, there are 2 main types of
    Uzbek shurpa - kaynatma shurpa and kovurma shurpa. The first type - kaynatma shurpa is a dietary meal, as it does
    not require frying in a large amount of oil, only broth and boiled vegetables. The name is derived from the verb
     "kaynatmok " ( "boil "). The second type of kovurma shurpa is fried shurpa, when major components: meat, onions,
    carrots are pre-fried in a cauldron, and then water is added; and everything is cooked until readiness with a lot of
    spices and herbs.</p> <p>The real Uzbek shurpa is made from the following ingredients: lamb (flesh on the bones
    and ribs), 100 grams of vegetable oil, 4 large carrots (preferably sweet, they give shurpa a special taste and
    aroma), 6 heads of onions (preferably white), 5 potatoes, 1 head of small garlic, a few pieces of tomatoes, peppers,
    salt, black pepper peas, red burning pepper, ground red pepper (not spicy), cumin, coriander, bay leaf, green.</p>
 <p>The secrets of cooking Uzbek soup as
    follows:</p><p>Heat the kettle on the fire, pour oil into it and when it is glowing enough, lay meat and roast it until crisp. It is
    necessary to constantly stir the meat, so not to burnt it.</p> <p>Cut onions into thin rings and place them on
    the top of the meat. As the meat has already allocated enough juice, do not stir. Let the meat and onions stew 10
    minutes, and then stir. Onions must acquire a golden hue.</p> <p>Cut the carrot into slices of 2-3 mm thick, put
    it on the top of the meat, and also stew about 10 minutes. Then, mix all well. Carrot should be half-ready, hardish
    within.</p> <p>Now lay the pepper, sliced into strips, cut into 4-6 pieces tomatoes. Add spices, water (half a
    cup) and cook, stirring constantly.</p> <p>Add the potatoes, peeled and cut into 4 pieces, and fill with water to
    the edges of the cauldron.</p> <p>Pour the chopped herbs, close the cauldron with the lid, strengthen the fire
    and bring to a boil. When shurpa boils, remove the lid, make a moderate fire and cook for about 40 min. Taste to
    salt, add salt, if
    necessary.</p><p>Unlike <strong>kovurma shurpa</strong>, here we need to cut the fat lamb into large, the size of a man's fist,
    pieces. Fat of tail cut into pieces of 4-6 cm. Bones should be hacked correctly, to leave no debris.</p> <p>The
    meat and fat is laid in the kettle, poured with cold spring water, covered with a lid and put on a strong fire. When
    Uzbek shurpa boils, remove the scum and put into the cauldron two large onions, two medium-sized turnips, cut in
    half and cut the carrots into large chunks. Cover the kettle with the lid, diminish the heat to medium and cook
    further, periodically checking the readiness of meat.</p> <p>Add potatoes at a rate of that meat should be cooked
    for at least half an hour. When the potatoes and meat are ready, salt, pepper and put bay leaf. Remove the kettle
    from heat, and give the dish  "ripen " for about 10 minutes, and if you have enough patience, about 15 minutes.</p>
 <p>Serve the dish separately. The broth of Uzbek shurpa, sprinkled with herbs is served in bowls; and meat with
    vegetables on a tray. Slowly, with awareness of the significance of the moment, we eat
    everything.</p>
<p>Nukhat shurpa or shurpa with chickpeas is the most popular type of Uzbek shurpa in <a class= "external "
                                                                                         href= "uzbekistan-cities/tashkent/ "
                                                                                         title= "Tashkent ">Tashkent</a>.
    And no wonder. The look in this shurpa is festive and elegant: chunks of juicy soft meat, orange carrots, yellow
    turnips, red tomatoes, green sparks of green, large yellow peas of chickpeas. And all this is in a transparent amber
    broth.</p> <p>There are also such kinds of Uzbek shurpa as kiyma shurvo (with meatballs) dolma shurvo (with
    peppers), kuzikorin shurvo (with mushrooms) – rarely; karam shurvo (with cabbage) – rarely; kaymok shurvo (cold soup
    with sour cream) - is hardly cooked.</p> <p>There is big set of Uzbek shurpa recipes, and only some of them are
    the most common. Due to the fact that Uzbek shurpa is always cooked fat, it is definitely served with Uzbek bread.
    Not for nothing Uzbek proverb says  "The fat sheep’s life is short ".</p> <p><a class= "external "
                                                                                       href= "https://www.people-travels.com/ "
                                                                                       title= "Come to Uzbekistan ">Come
    to Uzbekistan</a> availing you of tours from Peopletravel Company, enjoy Uzbek food and learn from Uzbek people how
    to cook right Uzbek shurpa.</p>


























