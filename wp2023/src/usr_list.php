<h3 class="bg-primary">アカウント一覧</h3>
<?php
//---ここから--実行権限チェック---
if (!isset($_SESSION['urole'])){
  die ('<h3>エラー：この機能はログインしないと利用できません</h3>');
}elseif($_SESSION['urole'] != 9 ){
  die ('<h3>エラー：この機能は管理者でないと利用できません</h3>');
}
//---ここまで--実行権限チェック---

require_once('db_inc.php');
//ここから、並べ替えの基準を決める
$by = isset($_GET['d']) ? -$_GET['d'] : 0;//降順 (DESC)
$by = isset($_GET['a']) ?  $_GET['a'] : $by;//昇順 (ASC)
$order = array(
  0=> 'urole, uid',
  1=> 'uid ASC',   -1=> 'uid DESC',
  2=> 'uname ASC', -2=> 'uname DESC',
  3=> 'urole ASC', -3=> 'urole DESC',
);
// 並べ替え基準をSQL文に適用
$orderby = 'ORDER BY ' . $order[$by];
$sql = "SELECT * FROM tbl_user $orderby";//$orderbyを適用


// 一覧するデータを検索するSQL
//$sql = "SELECT * FROM tbl_user ORDER BY urole, uid";
//データベースへの問合せ($sql)を実行する・・・
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);

// 問合せ結果を表形式で出力する。

echo '<table class="table table-bordered table-hover">';
// まず、ヘッド部分（項目名）を出力
//echo '<tr><th>No.</th><th>氏名</th><th>ユーザ種別</th></tr>';
// 並べ替えボタン「▲」「▼」をリンクとして作成する（「d=?」：降順「a=?」：昇順）
$link = '<a href="?do=usr_list&d=%d">▼</a><a href="?do=usr_list&a=%d">▲</a>';
echo '<tr><th>No.'.sprintf($link,1,1).'</th><th>氏名'.sprintf($link,2,2).'</th><th>ユーザ種別'.sprintf($link,3,3).'</th><th colspan="3">操作</th></tr>';
// ユーザID（uid）、ユーザ名(uname)、ユーザ種別(urole)を一覧表示
$row= $rs->fetch_assoc();
while ($row) {
  echo '<tr>';
  echo '<td>' . $row['uid'] . '</td>';
  echo '<td>' . $row['uname']. '</td>';
  //echo '<td>' . $row['urole']. '</td>';
  $codes = array(1=>'学生', 2=>'教員', 9=>'管理者');
 $i  = $row['urole'];     // 数字のユーザ種別をで取得
 echo '<td>' . $codes[$i] . '</td>'; // ユーザ種別名を出力
 $uid = $row['uid'];
 echo '<td><a href="?do=usr_detail&uid='. $uid .'" class="btn btn-link">詳細</a></td>';
 echo '<td><a href="?do=usr_edit&uid='  . $uid .'" class="btn btn-link">編集</a></td>';
 echo '<td><a href="?do=usr_delete&uid='. $uid .'" class="btn btn-link">削除</a></td>';
 echo '</tr>';
 $row= $rs->fetch_assoc();//次の行へ
}
?>