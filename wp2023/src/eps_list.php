<h3 class="bg-primary">希望状況一覧</h3>
<!--<style>
    .blue{
        color: #FFF;
        background-color: #0099ff;
        border-radius: 6px;
    }
</style>-->
<?php
//---ここから--実行権限チェック---
if (!isset($_SESSION['urole'])){
    die ('<h3>エラー：この機能はログインしないと利用できません</h3>');
 }elseif($_SESSION['urole'] != 2 ){
    die ('<h3>エラー：この機能は教員でないと利用できません</h3>');
 }
//---ここまで--実行権限チェック---

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
  6=> 'pid ASC', -6=> 'pid DESC',
  7=> 'decided ASC', -7=> 'decided DESC',
);

// 一覧データを検索するSQL文
$orderby = 'ORDER BY ' . $order[$by];
//データベースへ問合せのSQL文($sql)を実行する。
$sql = "SELECT s.*,pid FROM tbl_student s LEFT JOIN tbl_wish w ON s.sid=w.sid $orderby, s.sid";
//$sql = "SELECT s.*,pid FROM tbl_student s LEFT JOIN tbl_wish w ON s.sid=w.sid ORDER BY s.sid";
$rs= $conn -> query($sql);
if(!$rs) die('エラー : '. $conn -> error);

// 問合せ結果を表形式で出力する。
echo '<table class="table table-bordered table-hover">';
$link = '<a href="?do=eps_list&d=%d">▼</a><a href="?do=eps_list&a=%d">▲</a>';
echo '<tr><th>学籍番号'.sprintf($link,1,1).'</th><th>氏名'.sprintf($link,2,2).'</th><th>性別'.sprintf($link,3,3).'</th><th>GPA'.sprintf($link,4,4).'</th><th>取得単位数'.sprintf($link,5,5).'</th><th>本人希望'.sprintf($link,6,6).'</th><th>配属結果'.sprintf($link,7,7).'</th><th>操作</th></tr>';
$row= $rs->fetch_assoc();

//学籍番号(sid)、氏名(sname)、性別(sex)、GPA(gpa)、修得単位数(credit), 本人希望(pid)、配属結果(decided)、「配属決定」ボタンの一覧表示
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
     
    if($row['pid']){
        $i= $row['pid'];
    }else{
        $i=0;
    }
     $pids = array(0=>'未提出', 1=>'総合教育', 2=>'応用教育');
     echo '<td>' . $pids[$i]. '</td>';
     $d = $row['decided'];
     $decided = array(0=>"", 1=>'総合教育', 2=>'応用教育');
     echo '<td>' . $decided[$d]. '</td>';
     //echo '<td><a href="?do=eps_decide&sid=' . $row['sid'] . '">配属決定</a></td>';
     echo '<td><a href="?do=eps_decide&sid='.$row['sid'] . '"><input type="button" value="配属決定" class="btn btn-info"></a></td>';
     echo '</tr>';
     $row = $rs->fetch_assoc();//次の行へ
    }
    echo '</table>';

?>