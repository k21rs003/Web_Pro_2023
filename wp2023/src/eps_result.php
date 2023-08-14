<h3 class="bg-primary">配属結果確認</h3>
<style>
    .red{
        color: red;
    }
</style>
<?php
require_once('db_inc.php');

$uid = $_SESSION['uid']; //ログイン中のユーザのIDを取得
$sid = strtoupper($uid); //学生であれば、学籍番号（ユーザIDの大文字変換）を求める

// 希望プログラムを検索するSQL文
$sql = "SELECT * FROM tbl_wish WHERE sid='{$sid}'";
//データベースへ問合せのSQL文($sql)を実行する・・・
// ・・・・・・
$rs= $conn -> query($sql);
if(!$rs) die('エラー : '. $conn -> error);

//問合せ結果があれば希望(pid)を求め、変数$pidに代入。空（未提出）の場合は、0を$pidに代入。
// ・・・・・・
$row = $rs -> fetch_assoc();
if($row){
    $pid= $row['pid'];
}else{
    $pid=0;
}
// 一覧データを検索するSQL文
$sql = "SELECT * FROM tbl_student WHERE sid='{$sid}'";
//データベースへ問合せのSQL文($sql)を実行する・・・
$rs= $conn -> query($sql);
if(!$rs) die('エラー : '. $conn -> error);

// 問合せ結果を表形式で出力する。
echo '<table class="table table-bordered table-hover">';
echo '<tr><th>学籍番号</th><th>氏名</th><th>性別</th><th>GPA</th><th>取得単位数</th><th>本人希望</th><th>配属結果</th></tr>';
$row= $rs->fetch_assoc();
while ($row) {
// 学籍番号(sid)、氏名(sname)、性別(sex)、GPA(gpa)、修得単位数(credit)、本人希望($pid)、配属結果(decided)を表示
// ・・・・・・
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
 $i  = $pid;     // コース種別のコードを数値で取得
 $pid = array(0=>'未提出', 1=>'総合教育', 2=>'応用教育'); //コース種別を定義する配列
 echo '<td>' . $pid[$i] . '</td>'; // コース種別名を配列の要素として出力
 
 $j  = $row['decided'];     // コース種別のコードを数値で取得
 $decided = array(0=>'未決定', 1=>'総合教育', 2=>'応用教育'); //コース種別を定義する配列
 echo '<td class="red">' . $decided[$j] . '</td>'; // コース種別名を配列の要素として出力
 //echo '<td>' . $row['decided']. '</td>';
 echo '</tr>';
 $row = $rs->fetch_assoc();//次の行へ
}
echo '</table>';
?>