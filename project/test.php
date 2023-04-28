<?php
// データベース接続情報
$host = 'localhost:8889';
$dbname = 'products';
$username = 'root';
$password = 'root';

// データベースに接続
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "データベースに接続できませんでした。: " . $e->getMessage();
    exit;
}

// CSVファイルを開く
$csvFile = fopen('breweries.csv', 'r');

// CSVファイルを1行ずつ読み込み、住所情報を取得して、対応するbreweriesレコードに住所を追加する
while (($row = fgetcsv($csvFile)) !== false) {
    // CSVファイルの各行の住所情報を取得
    $id = $row[0];
    $address = $row[3];

    // breweriesテーブルの該当レコードの住所情報を更新する
    $stmt = $pdo->prepare("UPDATE breweries SET address = :address WHERE id = :id");
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

// CSVファイルを閉じる
fclose($csvFile);

?>
