<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>酒検索</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <div class="rapper">
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

            // 検索キーワードを取得する
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            // SQLクエリを構築する
            $sql = 'SELECT * FROM sakes';
            $params = array();
            if (!empty($search)) {
                $sql = "SELECT * FROM sakes WHERE sake_name LIKE :search OR sake_type LIKE :search";
                $params = array(':search' => "%{$search}%");
            }

            // プリペアドステートメントを作成する
            $stmt = $pdo->prepare($sql);

            // パラメータを設定してクエリを実行する
            $stmt->execute($params);
            ?>

            <form class="search" method="GET">
                <input type="text" name="search" value="<?php echo $search; ?>" placeholder="検索ワードを入力">
                <button type="submit">検索</button>
            </form>
            <button class="space-between" onclick="redirectToMap()">Go to Map</button>
            <script>
                function redirectToMap() {
                    window.location.href = 'map.php';
                }
                function redirectToNew() {
                window.location.href = 'new.php';
                }
            </script>
        </div>
        <table>
            <tr>
                <th>日本酒ID</th>
                <th>名前</th>
                <th>種類</th>
                <th>詳細</th>
            </tr>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?php echo $row['sake_id']; ?></td>
                    <td><?php echo $row['sake_name']; ?></td>
                    <td><?php echo $row['sake_type']; ?></td>
                    <td>
                        <a href="details.php?sake_id=<?php echo $row['sake_id']; ?>">
                            詳細
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <div class="button-container">
            <button onclick="redirectToNew()">日本酒を追加する</button>
        </div>
            <?php // データベース接続を切断する
            $pdo = null;
            ?>
    </div>
</body>
</html>
