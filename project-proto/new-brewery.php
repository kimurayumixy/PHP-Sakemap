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
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;200;300;400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;200;300;400&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/dacbc5c95b.js" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container">
        <h1>新しい酒蔵を追加する</h1>
        <form class="form-container" method="post">
            <div class="display-grid">
                <label for="maker_name">メーカー名:</label>
                <input type="text" id="maker_name" name="maker_name"><br>
            </div>
            <div class="display-grid">
                <label for="address">住所:</label>
                <input type="text" id="address" name="address"><br>
            </div>
            <div class="display-grid">
                <label for="detail">詳細:</label>
                <textarea id="detail" name="detail"></textarea><br>
            </div>
            <div class="display-grid">
                <label for="url">URL:</label>
                <input type="text" id="url" name="url"><br>
            </div>
            <button class="button-container" type="submit">追加</button>
        </form>
    </div>
</body>
</html>
