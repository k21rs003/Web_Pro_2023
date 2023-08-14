<h3 class="bg-primary">希望状況集計</h3>
<?php
require_once('db_inc.php');

// 一覧データを検索するSQL文
$sql = "
 SELECT pid, COUNT(*) as people FROM tbl_wish GROUP BY pid UNION
 SELECT pid, 0 as people FROM tbl_program WHERE pid NOT IN (SELECT pid FROM tbl_wish)
 ORDER BY pid";
//データベースへ問合せのSQL文($sql)を実行する・・・
$rs= $conn -> query($sql);
if(!$rs) die('エラー : '. $conn -> error);

//プログラムID(pid)、希望人数(people)の一覧表示
echo '<table class="table table-bordered table-hover">';
echo '<tr><th>プログラム名</th><th>希望人数</th></tr>';
$row= $rs->fetch_assoc();
$all=0;
while ($row) {
    echo '<tr>';
    $p= $row['pid'];
    $pid = array(1=>'総合教育', 2=>'応用教育');
    echo '<td>' /*. $row['pid'] .' : '*/. $pid[$p] .'</td>';
    echo '<td>' . $row['people']. '</td>';
    echo '</tr>';
    $all = $all + $row['people'];
    $row = $rs->fetch_assoc();//次の行へ
   }
   echo '<tr>';
   echo '<th>合計人数</th>';
   echo '<th>'.$all.'</th>';
   echo '</tr>';
   echo '</table>';
?>