<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品検索</title>
</head>
<body>
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

    // productsテーブルからデータを取得するクエリを作成する
    $sql = 'SELECT * FROM products';

    // クエリを実行する
    $stmt = $pdo->query($sql);

    // 結果をHTMLテーブルに書き出す
    echo '<table>';
    echo '<tr><th>Product ID</th><th>Product Code</th><th>Product Name</th><th>Color</th><th>Price</th><th>Created At</th><th>Updated At</th></tr>';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $row['product_id'] . '</td>';
        echo '<td>' . $row['product_code'] . '</td>';
        echo '<td>' . $row['product_name'] . '</td>';
        echo '<td>' . $row['color'] . '</td>';
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
