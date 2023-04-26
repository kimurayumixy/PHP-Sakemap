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
    $dbHost = 'localhost:8889';
    $dbUser = 'root';
    $password = 'root';
    $dbName = 'products';

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

    $sql = 'SELECT * FROM sakes';

    // クエリを実行する
    $stmt = $pdo->query($sql);

    // 結果をHTMLテーブルに書き出す
    echo '<table>';
    echo '<tr><th>日本酒ID</th><th>日本酒Code</th><th>名前</th><th>種類</th><th>価格</th><th>Created At</th><th>Updated At</th></tr>';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $row['sake_id'] . '</td>';
        echo '<td>' . $row['sake_code'] . '</td>';
        echo '<td>' . $row['sake_name'] . '</td>';
        echo '<td>' . $row['sake_type'] . '</td>';
        echo '<td>' . $row['price'] . '</td>';
        echo '<td>' . $row['created_at'] . '</td>';
        echo '<td>' . $row['updated_at'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';

    // データベース接続を切断する
    $pdo = null;
    ?>

</body>
</html>
