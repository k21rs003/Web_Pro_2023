<?php
require_once('db_inc.php');

// 入力フォームからデータを受け取り、変数$decided, $sidに代入
//・・・・
$decided = $_POST['decided'];
$sid = $_POST['sid'];

// 配属結果をtbl_studentに登録するSQL文
$sql = "UPDATE tbl_student SET decided={$decided} WHERE sid='{$sid}'";

// データベースへ問合せのSQL($sql)を実行する・・・ 
$rs= $conn -> query($sql);
if(!$rs) die('エラー : '. $conn -> error);

//  希望状況一覧画面へ自動遷移（header()関数を使用）
$url = 'index.php?do=eps_list';
header("Location: " . $url);

?>