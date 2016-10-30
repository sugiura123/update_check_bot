<?php
try
{
  // $dbh = new PDO(DSN, ユーザー名, パスワード)
  $dbh = new PDO('mysql:host=localhost;dbname=test1','root');
  echo '成功しました！';
}
catch (PDOException $e)
{
  echo($e->getMessage());
  exit;
};

?>


<?php

    $homepage1 = file_get_contents('http://www.apple.com/');
    $bytes1 = strlen($homepage1);
    //var_dump($bytes1)

    $homepage2 = file_get_contents('http://www.amazon.co.jp/');
    $bytes2 = strlen($homepage2);
    //var_dump($bytes2);

    $homepage3 = file_get_contents('http://192.168.33.10/db_connect/update_check_bot.php');
    $bytes3 = strlen($homepage3);
    //var_dump($bytes3);

    date_default_timezone_set('Asia/Tokyo');
    $createdAt = date('Y-m-d H:i:s');

    $sql = "insert into bot (id, URL, bite, 最終チェック, 最終更新) values
            ('', 'http://www.apple.com/',$bytes1, $createdAt,'')";
    $sql2 = "insert into bot (id, URL, bite, 最終チェック, 最終更新) values
            ('', 'http://www.amazon.co.jp/',$bytes2, $createdAt,'')";
    $sql3 = "insert into bot (id, URL, bite, 最終チェック, 最終更新) values
            ('', 'http://192.168.33.10/db_connect/db_connect.php',$bytes3, $createdAt,'')";

    $stmt = $dbh->prepare($sql,$sql2,$sql3);
    $stmt->execute();

    $row = $stmt->fetchALL(PDO::FETCH_ASSOC);
    var_dump($row);


?>

<!-- mysql→test1(DB)→bot(table) -->













