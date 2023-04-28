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
    $brands_url = 'https://muro.sakenowa.com/sakenowa-data/api/brands';
    $brands_json = file_get_contents($brands_url);
    $brands_data = json_decode($brands_json, true);

    // 取得した銘柄情報をデータベースに登録
    foreach ($brands_data['brands'] as $brand) {
        $stmt = $dbh->prepare('INSERT INTO brands (id, name, brewery_id) VALUES (:id, :name, :brewery_id)');
        $stmt->bindParam(':id', $brand['id'], PDO::PARAM_INT);
        $stmt->bindParam(':name', $brand['name'], PDO::PARAM_STR);
        $stmt->bindParam(':brewery_id', $brand['breweryId'], PDO::PARAM_INT);
        $stmt->execute();
    }

    // データベース接続を閉じる
    $dbh = null;

    echo '銘柄情報をデータベースに登録しました。';

} catch (PDOException $e) {
    // エラー時の処理
    echo 'データベースに接続できませんでした。' . $e->getMessage();
    exit;
}

// // 1. APIから銘柄一覧のデータを取得する
// $url = 'https://muro.sakenowa.com/sakenowa-data/api/brands';
// $data = file_get_contents($url);
// $brands = json_decode($data, true)['brands'];

// // 2. 取得したデータをPHPで処理して、データベースに登録するためのSQL文を作成する
// $sql = "INSERT INTO sakes (sake_id, sake_name, makers_id) VALUES ";
// foreach ($brands as $brand) {
//     $print_r($brand);
//     $sake_id = $brand['id'];
//     $sake_name = $brand['name'];
//     $maker_id = $brand['breweryId'];
//     $sql .= "($sake_id, '$sake_name', $maker_id),";
// }
// // 最後のカンマを削除する
// $sql = rtrim($sql, ',');

// // データベース接続情報
// $host = 'localhost:8889';
// $dbname = 'products';
// $username = 'root';
// $password = 'root';


// // 3. SQL文を実行して、データベースに登録する
// $pdo = new PDO(
//     "mysql:host=$host;dbname=$dbname;charset=utf8",
//     $username,
//     $password
// );
// $stmt = $pdo->prepare($sql);
// $stmt->execute();

// // 4. 登録したデータを画面に表示するために、再度データベースからデータを取得する
// $sql = "SELECT * FROM sakes";
// $stmt = $pdo->query($sql);
// $sakes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// // 5. 取得したデータを画面に表示するためのHTMLを作成する
// $html = '<table>';
// $html .= '<tr><th>銘柄ID</th><th>銘柄名</th><th>蔵元ID</th></tr>';
// foreach ($sakes as $sake) {
//     $html .= "<tr><td>{$sake['sake_id']}</td><td>{$sake['sake_name']}</td><td>{$sake['makers_id']}</td></tr>";
// }
// $html .= '</table>';

// echo $html;
?>
