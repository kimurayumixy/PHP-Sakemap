<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <title>Mapbox Example</title>
    <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.css' rel='stylesheet' />
    <script src='config.js'></script>
    <style>
        body { margin: 0; padding: 0; }
        #map { position: absolute; top: 0; bottom: 0; width: 100%; }
    </style>
</head>
<body>
    <div id='map'></div>
    <script>
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [139.6917, 35.6895], // 東京の座標
            zoom: 6, // ズームレベル
            bounds: [
            [139.5546, 35.5707], // 西側の経度、南側の緯度
            [139.9406, 35.8244]  // 東側の経度、北側の緯度
            ]
        });
    </script>
</body>
</html>
