<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>酒検索</title>
</head>
<body>
    <button onclick="redirectToMap()">Go to Map</button>
    <script>
    function redirectToMap() {
        window.location.href = 'map.php';
    }
    </script>
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

    // 検索フィールドに入力された値があれば、SQL文に条件を追加する
    $search_word = $_GET['search_word'] ?? '';
    if (!empty($search_word)) {
        $sql = 'SELECT brands.id, brands.name AS brand_name, breweries.name AS brewery_name, breweries.address AS address, areas.name AS area_name FROM brands JOIN breweries ON brands.brewery_id = breweries.id JOIN areas ON breweries.area_id = areas.id WHERE brands.name LIKE :search_word';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':search_word', "%$search_word%");
    } else {
        $sql = 'SELECT brands.id, brands.name AS brand_name, breweries.name AS brewery_name, breweries.address AS address, areas.name AS area_name FROM brands JOIN breweries ON brands.brewery_id = breweries.id JOIN areas ON breweries.area_id = areas.id';
        $stmt = $pdo->query($sql);
    }
    ?>

    <form method="GET">
        <label for="search_word">検索:</label>
        <input type="text" name="search_word" id="search_word" value="<?php echo htmlspecialchars($search_word, ENT_QUOTES, 'UTF-8'); ?>">
        <button type="submit">検索</button>
    </form>
    <table>
        <tr>
            <th>日本酒ID</th>
            <th>名前</th>
            <th>酒造名</th>
            <th>製造場所</th>
            <th>住所</th>
            <th>詳細</th>
        </tr>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['brand_name']; ?></td>
                <td><?php echo $row['brewery_name']; ?></td>
                <td><?php echo $row['area_name']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td>
                    <a href="details.php?id=<?php echo $row[
                        'id'
                    ]; ?>">
                        詳細
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php
    $pdo = null;
    ?>

</body>
</html>
