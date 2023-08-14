<h2 class="bg-primary">アカウント詳細</h2>
<?php
//---ここから--実行権限チェック---
if (!isset($_SESSION['urole'])){
    die ('<h3>エラー：この機能はログインしないと利用できません</h3>');
 }elseif($_SESSION['urole'] != 9 ){
    die ('<h3>エラー：この機能は管理者でないと利用できません</h3>');
 }
//---ここまで--実行権限チェック---

require_once('db_inc.php');
$uid  = $_GET['uid'];     // クエリ文字列で与えれれたユーザIDでユーザを特定
// 詳細を検索するSQL文
$sql = "SELECT * FROM tbl_user WHERE uid='{$uid}'";
//データベースへ問合せのSQL文($sql)を実行する・・・
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);

// 問合せ結果を表形式で出力する
echo '<table class="table table-bordered table-hover">';
$row= $rs->fetch_assoc();
if ($row) {
 $id = $row['uid'];
 echo '<tr><td rowspan="4"><img src="img/'. $id .'.png" height="150"></td></tr>';
 echo '<tr><th>ユーザID</th><td>' . $row['uid'] . '</td></tr>';
 echo '<tr><th>ユーザ名</th><td>' . $row['uname']. '</td></tr>';
 //echo '<tr><th>ユーザ種別</th><td>' . $row['urole']. '</td></tr>';
 $i  = $row['urole'];     // 数字のユーザ種別を取得
 $uroles= array(1=>'学生', 2=>'教員', 9=>'管理者' ); 
 echo '<tr><th>ユーザ種別</th><td>' . $uroles[$i]. '</td></tr>';
 //echo '<tr><th colspan=2>';
 //echo '</th></tr>';
}else{
 echo 'このユーザは存在しません！';
}
echo '</table>';
echo '<a href="?do=usr_edit&uid='  .$row['uid'].'"><button class="btn btn-default">編集</button></a> ';
echo '<a href="?do=usr_delete&uid='.$row['uid'].'"><button class="btn btn-danger">削除</button></a>';
?>