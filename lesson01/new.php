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

// フォームが送信された場合はデータベースに追加する
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // フォームから送信されたデータを取得する
    $sake_name = $_POST['sake_name'];
    $sake_description = $_POST['sake_description'];
    $flavor_type = $_POST['flavor_type'];
    $sake_type = $_POST['sake_type'];
    $price = $_POST['price'];
    $makers_id = $_POST['makers_id'];
    $alcohol_content = $_POST['alcohol_content'];

    // データベースに新しいデータを登録する
    $sql = "INSERT INTO sakes (sake_name, sake_description, flavor_type, sake_type, price, makers_id, alcohol_content) VALUES (:sake_name, :sake_description, :flavor_type, :sake_type, :price, :makers_id, :alcohol_content)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':sake_name', $sake_name, PDO::PARAM_STR);
    $stmt->bindParam(':sake_description', $sake_description, PDO::PARAM_STR);
    $stmt->bindParam(':flavor_type', $flavor_type, PDO::PARAM_STR);
    $stmt->bindParam(':sake_type', $sake_type, PDO::PARAM_STR);
    $stmt->bindParam(':price', $price, PDO::PARAM_INT);
    $stmt->bindParam(':makers_id', $makers_id, PDO::PARAM_INT);
    $stmt->bindParam(':alcohol_content', $alcohol_content, PDO::PARAM_STR);
    $stmt->execute();

    // 登録が完了したら、index.phpにリダイレクトする
    header('Location: sample01.php');
    exit;
}

// 酒造メーカーの一覧を取得する
$sql = 'SELECT * FROM makers';
$stmt = $pdo->query($sql);
$makers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新しい日本酒を追加する</title>
</head>
<body>
    <h1>新しい日本酒を追加する</h1>
    <form method="POST">
        <div>
            <label for="sake_name">名前：</label>
            <input type="text" name="sake_name" required>
        </div>
        <div>
            <label for="sake_description">詳細：</label>
            <input type="text" name="sake_description">
        </div>
        <div>
            <label for="flavor_type">フレーバータイプ：</label>
            <input type="text" name="flavor_type">
        </div>
        <div>
            <label for="sake_type">日本酒タイプ：</label>
            <input type="text" name="sake_type">
        </div>
        <div>
            <label for="price">価格：</label>
            <input type="number" name="price" min="0">
        </div>
        <div>
            <label for="makers_id">酒造メーカーID：</label>
            <input type="number" name="makers_id" min="1" required>
        </div>
        <div>
            <label for="alcohol_content">アルコール度数：</label>
            <input type="number" name="alcohol_content" min="0">
        </div>
        <button type="submit">追加</button>
    </form>
</body>
</html>
