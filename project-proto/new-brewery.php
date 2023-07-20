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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 新しい酒造メーカーの情報を受け取る
    $maker_name = $_POST['maker_name'];
    $address = $_POST['address'];
    $detail = $_POST['detail'];
    $url = $_POST['url'];

    // SQL文を作成
    $sql = "INSERT INTO makers (maker_name, address, detail, url) VALUES (:maker_name, :address, :detail, :url)";

    // SQL文を実行
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':maker_name', $maker_name, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt->bindParam(':detail', $detail, PDO::PARAM_STR);
    $stmt->bindParam(':url', $url, PDO::PARAM_STR);
    $stmt->execute();

    // 登録が完了したら、new.phpにリダイレクトする
    header('Location: new.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新しい日本酒を追加する</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>新しい日本酒を追加する</h1>
    <form method="post">
        <label for="maker_name">メーカー名:</label>
        <input type="text" id="maker_name" name="maker_name"><br>

        <label for="address">住所:</label>
        <input type="text" id="address" name="address"><br>

        <label for="detail">詳細:</label>
        <textarea id="detail" name="detail"></textarea><br>

        <label for="url">URL:</label>
        <input type="text" id="url" name="url"><br>

        <input type="submit" value="送信">
    </form>
</body>
</html>
