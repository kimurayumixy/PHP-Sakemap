<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>詳細</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
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

    $sake_id = $_GET['sake_id'];

    // sakesテーブルから該当する日本酒の情報を取得する
    $sql_sake = "SELECT * FROM sakes WHERE sake_id = $sake_id";
    $stmt_sake = $pdo->query($sql_sake);
    $sake = $stmt_sake->fetch(PDO::FETCH_ASSOC);

    // makersテーブルから該当する酒造メーカーの情報を取得する
    $maker_id = $sake['makers_id'];
    $sql_maker = "SELECT * FROM makers WHERE maker_id = $maker_id";
    $stmt_maker = $pdo->query($sql_maker);
    $maker = $stmt_maker->fetch(PDO::FETCH_ASSOC);

    // 日本酒名と酒造メーカー名を表示する
    echo '<h1>' . $sake['sake_name'] . ' (' . $maker['maker_name'] . ')' . '</h1>';

    // 日本酒の画像を表示する
    echo '<img src="' . $sake['sake_image'] . '" alt="' . $sake['sake_name'] . '">';

    // その他の情報を表示する
    echo '<ul>';
    echo '<li>種類：' . $sake['sake_type'] . '</li>';
    echo '<li>価格：' . $sake['price'] . '円</li>';
    echo '<li>アルコール度数：' . $sake['alcohol_content'] . '%</li>';
    echo '<li>詳細：' . $maker['details'] . '</li>';
    echo '<li>URL：' . $maker['url'] . '</li>';
    echo '<li>住所：' . $maker['address'] . '</li>';
    echo '</ul>';

    // データベース接続を切断する
    $pdo = null;
    ?>
</body>
</html>
