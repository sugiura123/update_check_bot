<!-- mysql→test1(DB)→bot(table) -->


<?php
try
{
  // $dbh = new PDO(DSN, ユーザー名, パスワード)
  $dbh = new PDO('mysql:host=localhost;dbname=test1','root');
  //echo '成功しました！';
}
catch (PDOException $e)
{
  //echo($e->getMessage());
  exit;
};

?>

<?php
$APPLE_WEB = 'http://www.apple.com';
$AMAZON_WEB = 'http://www.amazon.co.jp/';
$INDEX_HTML = 'http://192.168.33.10/db_connect/index.html';
?>

<?php
//web上にあるコンテンツのバイト数を抽出
    $apple_web = file_get_contents($APPLE_WEB);
    $apple_web_byte = strlen($apple_web);
    //var_dump($apple_web_byte);

    $amazon_web = file_get_contents($AMAZON_WEB);
    $amazon_web_byte = strlen($amazon_web);
    //var_dump($amazon_web_byte);

    $index_html = file_get_contents($INDEX_HTML);
    $index_html_byte = strlen($index_html);
    //var_dump($index_html_byte);


    date_default_timezone_set('Asia/Tokyo');
    $createdAt = date('Y-m-d H:i:s');



//1. SQLのまとめたものを記載して(table botに記載されたbyte数を抽出)
$db_byte_check_apple = "select byte from bot where $APPLE_WEB;"
$db_byte_check_amazon = "select byte from bot where $AMAZON_WEB;"
$db_byte_check_index = "select byte from bot where $INDEX_HTML;"



//初期データの挿入
$initSql_apple = "insert into bot (URL, byte, last_check, last_modify) values ($APPLE_WEB,$apple_web_byte, now(), now());"
$initSql_amazon = "insert into bot (URL, byte, last_check, last_modify) values ($AMAZON_WEB,$amazon_web_byte, now(), now());"
$initSql_index = "insert into bot (URL, byte, last_check, last_modify) values ($INDEX_HTML,$index_html_byte, now(), now());"


//容量が同じ場合のSQL
$eqbyteSql_apple = "update test1.bot SET last_check=now() where URL=$APPLE_WEB";
$eqbyteSql_amazon = "update test1.bot SET last_check=now() where URL=$AMAZON_WEB";
$eqbyteSql_index = "update test1.bot SET last_check=now() where URL=$INDEX_HTML";

//容量が違う場合のSQL
$changeSql_apple = "update test1.bot SET byte=$apple_web_byte, last_check=now(), last_modify=now() where URL=$APPLE_WEB;"
$changeSql_amazon = "update test1.bot SET byte=$amazon_web_byte, last_check=now(), last_modify=now() where URL=$AMAZON_WEB;"
$changeSql_index = "update test1.bot SET byte=$index_html_byte, last_check=now(), last_modify=now() where URL=$INDEX_HTML;"

//2. クエリーの発行
// if($byte == null){
//   $db_byte_check_result = mysqli_query($db_byte_check_apple, $db_byte_check_amazon, $db_byte_check_index);
//     if(!$result) {
//      $message = "初期値の挿入に失敗しました";
//      die($message);
//     }
// } elseif () {
// }


if($byte == null){
    $stmt = $dbh->prepare($initSql_apple);
    $stmt->execute();
} elseif($db_byte_check_apple == $apple_web_byte){
    //容量が同じなので、バイト☓ lastcheck ◎ , lastmodify ☓
    $eqbyteSql_apple;
} else {
    //容量が違っていたら新しいサイトなので, lastcheck、byte、lastmodify を◎
    $changeSql_apple;

}

if($byte == null){
    $stmt = $dbh->prepare($initSql_amazon);
    $stmt->execute();
} elseif($db_byte_check_amazon == $amazon_web_byte){
    //容量が同じなので、バイト☓ lastcheck ◎ , lastmodify ☓
    $eqbyteSql_amazon ;
} else {
    //容量が違っていたら新しいサイトなので, lastcheck、byte、lastmodify を◎
    $changeSql_amazon;
}

if($byte == null){
    $stmt = $dbh->prepare($initSql_index);
    $stmt->execute();
} elseif($db_byte_check_index == $index_web_byte){
    //容量が同じなので、バイト☓ lastcheck ◎ , lastmodify ☓
    $eqbyteSql_index;
} else {
    //容量が違っていたら新しいサイトなので, lastcheck、byte、lastmodify を◎
    $changeSql_index ;
}

    // $row = $stmt->fetchALL(PDO::FETCH_ASSOC);
    // var_dump($row);

?>








