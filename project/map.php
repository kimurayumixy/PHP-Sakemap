<?php
// データベース接続情報
$host = 'localhost:8889';
$dbname = 'products';
$username = 'root';
$password = 'root';

// PDOオブジェクトを作成してデータベースに接続する
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $username,
        $password
    );
} catch (PDOException $e) {
    die('データベースに接続できません：' . $e->getMessage());
}

// makersテーブルから住所を取得する
$sql_maker = "SELECT * FROM breweries";
$stmt_maker = $pdo->query($sql_maker);
$makers = $stmt_maker->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Add a geocoder</title>
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
<link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
<script src='config.js'></script>
<style>
    body { margin: 0; padding: 0; }
    #map { position: absolute; top: 0; bottom: 0; width: 100%; }
</style>
</head>
<body>
    <!-- Load the `mapbox-gl-geocoder` plugin. -->
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">

    <div id="map"></div>

    <script>
    const map = new mapboxgl.Map({
        container: 'map',
        // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
        style: 'mapbox://styles/mapbox/streets-v12',
        center: [139.6917, 35.6895], // 東京の座標
        zoom: 6, // ズームレベル
        bounds: [
        [139.5546, 35.5707], // 西側の経度、南側の緯度
        [139.9406, 35.8244]  // 東側の経度、北側の緯度
        ]
    });

    // Add the control to the map.
    map.addControl(
        new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl
        })
    );
    const geocoder = new MapboxGeocoder({
        accessToken: mapboxgl.accessToken,
        mapboxgl: mapboxgl
    });

    // Add the control to the map.
    map.addControl(geocoder);
    // ジオコーダーで住所を検索し、マーカーを追加する
    const promises = [];
    <?php foreach ($makers as $maker) : ?>
        var address = '<?php echo $maker["address"]; ?>';
        promises.push(new Promise(function(resolve, reject) {
            geocoder.query(address, function (err, data) {
                if (err) {
                    reject(err);
                } else {
                    resolve(data);
                }
            });
        }));
    <?php endforeach; ?>

    Promise.all(promises)
    .then(function(dataArray) {
        for (let i = 0; i < dataArray.length; i++) {
            const data = dataArray[i];
            var marker = new mapboxgl.Marker({
                color: 'orange'
            })
            .setLngLat(data.features[0].center)
            .addTo(map);
        }
    })
    .catch(function(error) {
        console.error(error);
    });
    </script>
</body>
</html>
