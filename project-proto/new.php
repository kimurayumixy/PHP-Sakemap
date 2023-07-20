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
    $sake_image = $_FILES['sake_image'];

      // 画像をアップロード
    $upload_dir = 'images/';  // 画像をアップロードするディレクトリを指定します。
    $uploaded_file = $upload_dir . basename($sake_image['name']);
    if (move_uploaded_file($sake_image['tmp_name'], $uploaded_file)) {
        echo "画像がアップロードされました。";
    } else {
        echo "画像のアップロードに失敗しました。";
    }
    // データベースに新しいデータを登録する
    $sql = "INSERT INTO sakes (sake_name, sake_description, flavor_type, sake_type, price, makers_id, alcohol_content, sake_image) VALUES (:sake_name, :sake_description, :flavor_type, :sake_type, :price, :makers_id, :alcohol_content, :sake_image)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':sake_name', $sake_name, PDO::PARAM_STR);
    $stmt->bindParam(':sake_description', $sake_description, PDO::PARAM_STR);
    $stmt->bindParam(':flavor_type', $flavor_type, PDO::PARAM_STR);
    $stmt->bindParam(':sake_type', $sake_type, PDO::PARAM_STR);
    $stmt->bindParam(':price', $price, PDO::PARAM_INT);
    $stmt->bindParam(':makers_id', $makers_id, PDO::PARAM_INT);
    $stmt->bindParam(':alcohol_content', $alcohol_content, PDO::PARAM_STR);
    $stmt->bindParam(':sake_image', $uploaded_file, PDO::PARAM_STR);
    $stmt->execute();

    // 登録が完了したら、index.phpにリダイレクトする
    header('Location: index.php');
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
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;200;300;400&display=swap" rel="stylesheet">

</head>
<body>
    <div class="container">
        <h1>新しい日本酒を追加する</h1>
        <form class="form-container" method="POST">
            <div class="display-grid">
                <label for="sake_name">名前</label>
                <input type="text" name="sake_name" required>
            </div>
            <div class="display-grid">
                <label for="sake_description">詳細</label>
                <input type="text" name="sake_description">
            </div>
            <div class="display-grid">
                <label for="flavor_type">フレーバータイプ</label>
                <input type="text" name="flavor_type">
            </div>
            <div class="display-grid">
                <label for="sake_type">日本酒タイプ</label>
                <input type="text" name="sake_type">
            </div>
            <div class="display-grid">
                <label for="price">価格</label>
                <input type="number" name="price" min="0">
            </div>
            <div class="display-grid">
                <label for="makers_id">酒造メーカー</label>
                <select name="makers_id" required>
                    <?php foreach ($makers as $maker): ?>
                        <option value="<?php echo $maker['maker_id']; ?>"><?php echo $maker['maker_name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <a href="new-brewery.php">新しい酒造を追加する</a>
            </div>
            <div class="display-grid">
                <label for="alcohol_content">アルコール度数</label>
                <input type="number" name="alcohol_content" min="0">
            </div>
            <!-- <div>
                <label for="sake_image">写真：</label>
                <input type="file" name="sake_image">
            </div> -->
            <button class="button-container" type="submit">追加</button>
        </form>
    </div>
</body>
</html>
