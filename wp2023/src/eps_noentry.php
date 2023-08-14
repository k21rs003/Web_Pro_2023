<h3 class="bg-primary">未提出者一覧</h3>
<?php
require_once('db_inc.php');

//ここから、並べ替えの基準を決める
$by = isset($_GET['d']) ? -$_GET['d'] : 0;//降順 (DESC)
$by = isset($_GET['a']) ?  $_GET['a'] : $by;//昇順 (ASC)
$order = array(
  0=> 'sid',
  1=> 'sid ASC',   -1=> 'sid DESC',
  2=> 'sname ASC', -2=> 'sname DESC',
  3=> 'sex ASC', -3=> 'sex DESC',
  4=> 'gpa ASC', -4=> 'gpa DESC',
  5=> 'credit ASC', -5=> 'credit DESC',
);
// 並べ替え基準をSQL文に適用
$orderby = 'ORDER BY ' . $order[$by];
// 一覧データを検索するSQL
$sql = "SELECT * FROM tbl_student WHERE sid NOT IN (SELECT sid FROM tbl_wish) $orderby";
//データベースへ問合せのSQL文($sql)を実行する・・・
$rs= $conn -> query($sql);
if(!$rs) die('エラー : '. $conn -> error);

//学籍番号(sid)、氏名(sname)、性別(sex)、GPA(gpa)、修得単位数(credit)の一覧表示
echo '<table class="table table-bordered table-hover">';
// 並べ替えボタン「▲」「▼」をリンクとして作成する（「d=?」：降順「a=?」：昇順）
$link = '<a href="?do=eps_noentry&d=%d">▼</a><a href="?do=eps_noentry&a=%d">▲</a>';
echo '<tr><th>学籍番号'.sprintf($link,1,1).'</th><th>氏名'.sprintf($link,2,2).'</th><th>性別'.sprintf($link,3,3).'</th><th>GPA'.sprintf($link,4,4).'</th><th>取得単位数'.sprintf($link,5,5).'</th></tr>';
$row= $rs->fetch_assoc();

while ($row) {
    echo '<tr>';
    echo '<td>' . $row['sid'] . '</td>';
    echo '<td>' . $row['sname']. '</td>';
    if($row['sex'] == 1){
       echo '<td>男</td>'; 
   }else{
      echo '<td>女</td>';
   }
    echo '<td>' . $row['gpa']. '</td>';
    echo '<td>' . $row['credit']. '</td>';
    echo '</tr>';
    $row = $rs->fetch_assoc();//次の行へ
   }
   echo '</table>';

?>