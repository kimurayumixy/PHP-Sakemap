<?php
// データベース接続情報
$host = 'localhost:8889';
$dbname = 'products';
$username = 'root';
$password = 'root';

try {
    // データベースに接続
    $dbh = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $username, $password);

    // 銘柄情報を取得
    $areas_url = 'https://muro.sakenowa.com/sakenowa-data/api/areas';
    $areas_json = file_get_contents($areas_url);
    $areas_data = json_decode($areas_json, true);

    // 取得した銘柄情報をデータベースに登録
    foreach ($areas_data['areas'] as $area) {
        $stmt = $dbh->prepare('INSERT INTO areas (id, name) VALUES (:id, :name)');
        $stmt->bindParam(':id', $area['id'], PDO::PARAM_INT);
        $stmt->bindParam(':name', $area['name'], PDO::PARAM_STR);
        $stmt->execute();
        print_r($area);
    }

    // データベース接続を閉じる
    $dbh = null;

    echo '地域情報をデータベースに登録しました。';

} catch (PDOException $e) {
    // エラー時の処理
    echo 'データベースに接続できませんでした。' . $e->getMessage();
    exit;
}
?>
