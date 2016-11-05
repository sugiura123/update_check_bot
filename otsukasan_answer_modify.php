<?php
date_default_timezone_set('Asia/Tokyo');

//DBへの接続arrayでURLをする｡これによりURLが増えても問題なし｡
$dbh = new PDO('mysql:host=localhost;dbname=test1','root');
//arrayでURLをする｡これによりURLが増えても問題なし｡
$WEBSITES = array('http://www.apple.com','http://www.amazon.co.jp','http://www.google.co.jp');

foreach($WEBSITES as $url) {
  //指定したWEBの容量の取得
   $get_web_byte = strlen(file_get_contents($url));
// var_dump($get_web_byte);
  //現行のバイト数をDBより選択.SQL文も実行｡これで初期データや現行のデータを見る
  //比較としても使用
   $db_byte = "select byte from test1.bot where url=\"$url\";";
// var_dump($db_byte);
   $stmt = $dbh->query($db_byte);
   $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($row);
//var_dump($row[0]['byte']);
 //[0]とは??
   //初期データがなかったらinsert文で投入する｡
   if(!$row) {
     $all_insert_db = "insert into test1.bot (URL, byte, last_check, last_modify) values (\"$url\",$get_web_byte, now(), now());";
     $stmt = $dbh->prepare($all_insert_db);
     $stmt->execute();

    } else {
    //同じように既存のデータ量と新しくGETしたバイトを比較する｡配列から現在の容量をまずはいったん取得する。
     $db_byte = $row[0]['byte'];
     if ($db_byte == $get_web_byte) {
//       // echo "OKです";
       $update_check = "update test1.bot SET last_check=now() where url=\"$url\";";
       $stmt = $dbh->prepare($update_check);
       $stmt->execute();
     } else {
//       // echo "違っています";
       $change_web = "update test1.bot SET byte=$get_web_byte, last__check=now(), last_modify=now() where URL=\"$url\";";
       $stmt = $dbh->prepare($change_web);
       $stmt->execute();
     }
   }
 }
?>