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

    $sql = 'SELECT * FROM brands';

    // クエリを実行する
    $stmt = $pdo->query($sql);
    ?>

    <table>
        <tr>
            <th>日本酒ID</th>
            <th>名前</th>
            <th>詳細</th>
        </tr>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
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